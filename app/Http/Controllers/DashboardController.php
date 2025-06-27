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
    public function index()
    {
        $user = Auth::user();
        $viewName = 'dashboards.default'; // Fallback view
        $data = ['user' => $user];

        switch ($user->role) {
            case 'Admin':
                $viewName = 'dashboards.admin';
                $data['totalUsers'] = User::count();
                $data['totalPatients'] = Patient::count();
                $data['totalMedecins'] = User::where('role', 'Médecin')->count();
                $data['todayAppointments'] = RendezVous::whereDate('date_heure', Carbon::today())->count();
                break;
            case 'Médecin':
                $viewName = 'dashboards.medecin';
                $medecinId = $user->id;
                $data['todayAppointmentsCount'] = RendezVous::where('medecin_id', $medecinId)
                                                              ->whereDate('date_heure', Carbon::today())
                                                              ->count();
                // Supposant une relation et un statut 'actif' pour les hospitalisations
                $data['hospitalizedPatientsCount'] = \App\Models\Hospitalisation::where('medecin_id', $medecinId)
                                                                                ->where('statut', 'actif') // ou une logique équivalente
                                                                                ->count();
                $data['upcomingAppointments'] = RendezVous::where('medecin_id', $medecinId)
                                                          ->where('date_heure', '>', Carbon::now())
                                                          ->orderBy('date_heure', 'asc')
                                                          ->with('patient')
                                                          ->take(5)
                                                          ->get();
                break;
            case 'Secrétaire':
                $viewName = 'dashboards.secretaire';
                $data['todayAppointmentsCount'] = RendezVous::whereDate('date_heure', Carbon::today())->count();
                $data['newPatientsCount'] = Patient::whereDate('created_at', Carbon::today())->count();
                $data['upcomingAppointments'] = RendezVous::where('date_heure', '>', Carbon::now())
                                                          ->orderBy('date_heure', 'asc')
                                                          ->with('patient', 'medecin') // Eager load relationships
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
}
