<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Facture;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord en fonction du rôle de l'utilisateur
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $viewName = 'dashboards.default'; // Fallback view
        $data = ['user' => $user];

        switch ($user->role) {
            case 'Admin':
                return $this->admin();
                
            case 'Patient':
                $viewName = 'dashboards.patient';
                $data['upcomingAppointments'] = RendezVous::where('patient_id', $user->id)
                    ->where('date_rendez_vous', '>', Carbon::now())
                    ->orderBy('date_rendez_vous', 'asc')
                    ->with('medecin')
                    ->take(5)
                    ->get();
                $data['pastAppointments'] = RendezVous::where('patient_id', $user->id)
                    ->where('date_rendez_vous', '<=', Carbon::now())
                    ->orderBy('date_rendez_vous', 'desc')
                    ->with('medecin')
                    ->take(5)
                    ->get();
                break;
            case 'Medecin':
                $viewName = 'dashboards.medecin';
                $medecinId = $user->id;
                $data['todayAppointmentsCount'] = RendezVous::where('medecin_id', $medecinId)
                                                              ->whereDate('date_rendez_vous', Carbon::today())
                                                              ->count();
                // Supposant une relation et un statut 'actif' pour les hospitalisations
                $data['hospitalizedPatientsCount'] = \App\Models\Hospitalisation::where('medecin_id', $medecinId)
                                                                                ->where('statut', 'actif') // ou une logique équivalente
                                                                                ->count();
                $data['upcomingAppointments'] = RendezVous::where('medecin_id', $medecinId)
                                                          ->where('date_rendez_vous', '>', Carbon::now())
                                                          ->orderBy('date_rendez_vous', 'asc')
                                                          ->with('patient')
                                                          ->take(5)
                                                          ->get();
                break;
            case 'Secretaire':
                $viewName = 'dashboards.secretaire';
                $data['todayAppointmentsCount'] = RendezVous::whereDate('date_rendez_vous', Carbon::today())->count();
                $data['newPatientsCount'] = Patient::whereDate('created_at', Carbon::today())->count();
                $data['upcomingAppointments'] = RendezVous::with([
                    'patient.user',
                    'medecin'
                ])
                ->where('date_rendez_vous', '>', Carbon::now())
                ->orderBy('date_rendez_vous', 'asc')
                ->take(5)
                ->get();
                break;
            case 'Caissier':
                $viewName = 'dashboards.caissier';
                $data['pendingInvoicesCount'] = Facture::where('statut', '!=', 'payée')->count();
                $data['todayRevenue'] = Facture::whereDate('updated_at', Carbon::today())
                    ->where('statut', 'payée')
                    ->sum('montant_ttc');
                $data['latestInvoices'] = Facture::with('patient')
                    ->where('statut', '!=', 'payée')
                    ->latest()
                    ->take(5)
                    ->get();
                break;
            case 'Infirmier(e)':
                $viewName = 'dashboards.infirmier';
                // Nombre total de patients actuellement hospitalisés
                $data['hospitalizedPatientsCount'] = \App\Models\Hospitalisation::where('statut', 'actif')->count();

                // Liste des 5 derniers patients admis (supposant que les plus récents sont pertinents)
                $data['recentlyAdmittedPatients'] = \App\Models\Patient::whereHas('hospitalisations', function ($query) {
                    $query->where('statut', 'actif');
                })->latest()->take(5)->get();

                // Placeholder pour les soins à venir
                $data['todayCaresCount'] = 0; // Logique à implémenter plus tard
                break;
            case 'Pharmacien':
                $viewName = 'dashboards.pharmacien';
                // Nombre de prescriptions en attente
                $data['pendingPrescriptionsCount'] = \App\Models\Prescription::where('statut', 'en_attente')->count();

                // Placeholder pour le stock faible
                $data['lowStockMedicationsCount'] = 0; // Logique à implémenter plus tard

                // 5 dernières prescriptions à traiter
                $data['latestPrescriptions'] = \App\Models\Prescription::where('statut', 'en_attente')
                                                                      ->with('patient', 'medecin')
                                                                      ->latest()
                                                                      ->take(5)
                                                                      ->get();
                break;
            case 'Caissier':
                $viewName = 'dashboards.caissier';
                // Je suppose l'existence d'un modèle Facture avec un statut et un montant.
                // Nombre de factures en attente de paiement.
                $data['pendingInvoicesCount'] = 0; // App\Models\Facture::where('statut', 'non_payee')->count();

                // Total des revenus du jour.
                $data['todayRevenue'] = 0; // App\Models\Facture::where('statut', 'payee')->whereDate('updated_at', Carbon::today())->sum('montant');

                // 5 dernières factures à encaisser.
                $data['latestInvoices'] = []; // App\Models\Facture::where('statut', 'non_payee')->with('patient')->latest()->take(5)->get();
                break;
        }

        return view($viewName, $data);
    }
    
    /**
     * Affiche le tableau de bord administrateur
     *
     * @return \Illuminate\View\View
     */
    public function admin()
    {
        $user = Auth::user();
        
        // Statistiques générales
        $totalUsers = User::count();
        $totalPatients = Patient::count();
        $totalMedecins = User::where('role', 'Medecin')->count();
        
        // Rendez-vous du jour
        $todayAppointments = RendezVous::whereDate('date_rendez_vous', now()->toDateString())
            ->count();
            
        // Dernières activités (exemple avec les 5 derniers utilisateurs créés)
        $recentActivities = User::latest()
            ->take(5)
            ->get();

        return view('dashboards.admin', [
            'user' => $user,
            'totalUsers' => $totalUsers,
            'totalPatients' => $totalPatients,
            'totalMedecins' => $totalMedecins,
            'todayAppointments' => $todayAppointments,
            'recentActivities' => $recentActivities
        ]);
    }
}
