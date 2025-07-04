<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Nombre d'éléments par page pour la pagination
     */
    protected $perPage = 10;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin|Secretaire|Medecin')->only(['index', 'show']);
        $this->middleware('role:Admin|Secretaire')->only(['create', 'store', 'edit', 'update']);
        $this->middleware('role:Admin')->only(['destroy']);
    }

    /**
     * Affiche la liste des patients
     */
    public function index()
    {
        $search = request('q');
        
        $patients = Patient::when($search, function($query) use ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('numero_dossier', 'like', "%{$search}%");
            });
        })
        ->with('latestConsultation')
        ->latest()
        ->paginate($this->perPage)
        ->appends(['q' => $search]);

        return view('patients.index', compact('patients'));
    }

    /**
     * Affiche le formulaire de création d'un patient
     */
    public function create()
    {
        $groupesSanguins = [
            'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'
        ];

        return view('patients.create', compact('groupesSanguins'));
    }

    /**
     * Enregistre un nouveau patient
     */
    public function store(Request $request)
    {
        $validatedData = $this->validatePatient($request);
        
        try {
            DB::beginTransaction();
            
            $patient = Patient::create($validatedData);
            
            // Log de l'action
            Log::info('Nouveau patient créé', [
                'patient_id' => $patient->id,
                'par_utilisateur' => Auth::id(),
                'donnees' => $validatedData
            ]);
            
            DB::commit();
            
            $routeName = Auth::user()->role === 'Admin' ? 'admin.patients.show' : 'secretaire.patients.show';
            
            return redirect()
                ->route($routeName, $patient->id)
                ->with('success', 'Patient créé avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création du patient', [
                'erreur' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création du patient.');
        }
    }

    /**
     * Valide les données du formulaire patient
     *
     * @param Request $request
     * @param int|null $patientId ID du patient pour la validation unique de l'email
     * @return array
     */
    protected function validatePatient(Request $request, $patientId = null)
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date|before:today',
            'lieu_naissance' => 'nullable|string|max:255',
            'sexe' => 'required|in:Homme,Femme,Autre',
            'adresse' => 'required|string|max:500',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255|unique:patients,email',
            'groupe_sanguin' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'profession' => 'nullable|string|max:255',
            'antecedents_medicaux' => 'nullable|string',
            'traitements_en_cours' => 'nullable|string',
            'allergies' => 'nullable|string',
            'nom_contact_urgence' => 'nullable|string|max:255',
            'telephone_contact_urgence' => 'nullable|string|max:20',
            'lien_contact_urgence' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'statut' => 'sometimes|in:Actif,Inactif,Décédé',
        ];

        if ($patientId) {
            $rules['email'] .= ",{$patientId},id";
        }

        $validatedData = $request->validate($rules);
        
        // Valeurs par défaut
        if (!isset($validatedData['statut'])) {
            $validatedData['statut'] = 'Actif';
        }
        
        // Nettoyage des données
        $validatedData['email'] = !empty($validatedData['email']) ? strtolower(trim($validatedData['email'])) : null;
        $validatedData['telephone'] = preg_replace('/[^0-9+]/', '', $validatedData['telephone']);
        
        if (isset($validatedData['telephone_contact_urgence'])) {
            $validatedData['telephone_contact_urgence'] = preg_replace('/[^0-9+]/', '', $validatedData['telephone_contact_urgence']);
        }
        
        return $validatedData;
    }
    
    /**
     * Affiche les détails d'un patient
     */
    public function show(Patient $patient)
    {
        $patient->load([
            'consultations' => function($query) {
                $query->latest()->take(5);
            },
            'rendezVous' => function($query) {
                $query->where('date_rendez_vous', '>=', now())
                      ->orderBy('date_rendez_vous')
                      ->take(5);
            },
            'hospitalisations' => function($query) {
                $query->where('statut', 'en_cours')
                      ->latest()
                      ->take(3);
            },
            'ordonnances' => function($query) {
                $query->latest()->take(5);
            }
        ]);

        return view('patients.show', compact('patient'));
    }

    /**
     * Affiche le formulaire de modification d'un patient
     */
    public function edit(Patient $patient)
    {
        $groupesSanguins = [
            'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'
        ];

        $statuts = [
            'Actif' => 'Actif',
            'Inactif' => 'Inactif',
            'Décédé' => 'Décédé'
        ];

        return view('patients.edit', compact('patient', 'groupesSanguins', 'statuts'));
    }

    /**
     * Met à jour les informations d'un patient
     */
    public function update(Request $request, Patient $patient)
    {
        $validatedData = $this->validatePatient($request, $patient->id);
        
        try {
            DB::beginTransaction();
            
            // Journalisation avant la mise à jour
            $anciennesDonnees = $patient->toArray();
            
            $patient->update($validatedData);
            
            // Journalisation après la mise à jour
            Log::info('Mise à jour du patient', [
                'patient_id' => $patient->id,
                'anciennes_donnees' => $anciennesDonnees,
                'nouvelles_donnees' => $patient->fresh()->toArray(),
                'par_utilisateur' => Auth::id()
            ]);
            
            DB::commit();
            
            $routeName = Auth::user()->role === 'Admin' ? 'admin.patients.show' : 'secretaire.patients.show';

            return redirect()
                ->route($routeName, $patient->id)
                ->with('success', 'Patient mis à jour avec succès.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur lors de la mise à jour du patient', [
                'patient_id' => $patient->id,
                'erreur' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du patient.');
        }
    }

    /**
     * Supprime un patient de manière sécurisée
     */
    public function destroy(Patient $patient)
    {
        try {
            DB::beginTransaction();
            
            // Vérifier si le patient a des données liées
            $hasRelatedData = $patient->consultations()->exists() || 
                            $patient->rendezVous()->exists() ||
                            $patient->hospitalisations()->exists() ||
                            $patient->ordonnances()->exists() ||
                            $patient->paiements()->exists();
            
            if ($hasRelatedData) {
                // Journalisation de la tentative de suppression avec données liées
                Log::warning('Tentative de suppression d\'un patient avec des données liées', [
                    'patient_id' => $patient->id,
                    'nom_complet' => $patient->nom_complet,
                    'par_utilisateur' => Auth::id(),
                    'donnees_liees' => [
                        'consultations' => $patient->consultations()->count(),
                        'rendez_vous' => $patient->rendezVous()->count(),
                        'hospitalisations' => $patient->hospitalisations()->count(),
                        'ordonnances' => $patient->ordonnances()->count(),
                        'paiements' => $patient->paiements()->count(),
                    ]
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer ce patient car il possède des données associées (consultations, rendez-vous, etc.).',
                    'has_related_data' => true
                ], 422);
            }
            
            // Journalisation avant suppression
            Log::info('Suppression du patient', [
                'patient_id' => $patient->id,
                'nom_complet' => $patient->nom_complet,
                'par_utilisateur' => Auth::id(),
                'donnees' => $patient->toArray()
            ]);

            // Suppression du patient
            $patient->forceDelete();
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Patient supprimé avec succès.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur lors de la suppression du patient', [
                'patient_id' => $patient->id,
                'erreur' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression du patient.'
            ], 500);
        }
    }

    /**
     * Change le statut du patient (Actif, Inactif, Décédé).
     */
    public function changeStatus(Request $request, Patient $patient)
    {
        $request->validate([
            'statut' => 'required|string|in:Actif,Inactif,Décédé',
        ]);

        $patient->update(['statut' => $request->statut]);

        return back()->with('success', 'Statut du patient mis à jour avec succès.');
    }
}
