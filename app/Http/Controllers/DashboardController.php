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
     * Redirige l'utilisateur vers le tableau de bord approprié en fonction de son rôle.
     */
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'Secretaire':
                return redirect()->route('secretaire.dashboard');
            case 'Médecin':
                return redirect()->route('medecin.dashboard');
            case 'Infirmier':
            case 'Infirmier(e)':
                return redirect()->route('infirmier.dashboard');
            case 'Pharmacien':
                return redirect()->route('pharmacien.dashboard');
            case 'Caissier':
                return redirect()->route('caissier.dashboard');
            default:
                return redirect()->route('home'); 
        }
    }
    
    /**
     * Affiche le tableau de bord de l'administrateur.
     */
    public function admin()
    {
        $user = Auth::user();
        $today = now()->format('Y-m-d');
        
        $stats = [
            'totalPatients' => Patient::count(),
            'totalAppointments' => RendezVous::count(),
            'totalUsers' => User::count(),
            'totalMedecins' => User::whereIn('role', ['Médecin', 'Medecin'])->count(),
            'todayAppointments' => RendezVous::whereDate('date_rendez_vous', $today)->count(),
            'recentAppointments' => RendezVous::with(['patient', 'medecin'])
                ->latest()
                ->take(5)
                ->get(),
        ];
        
        return view('dashboards.admin', compact('stats', 'user'));
    }

    /**
     * Affiche le tableau de bord du médecin.
     */
    public function medecin()
    {
        $user = Auth::user();
        $medecinId = $user->id;
        $stats = [
            'todayAppointmentsCount' => RendezVous::where('medecin_id', $medecinId)->whereDate('date_rendez_vous', Carbon::today())->count(),
            'hospitalizedPatientsCount' => \App\Models\Hospitalisation::where('medecin_id', $medecinId)->where('statut', 'actif')->count(),
            'upcomingAppointments' => RendezVous::where('medecin_id', $medecinId)->where('date_rendez_vous', '>', Carbon::now())->orderBy('date_rendez_vous', 'asc')->with('patient')->take(5)->get(),
        ];
        return view('dashboards.medecin', compact('stats', 'user'));
    }

    /**
     * Affiche le tableau de bord de la secrétaire.
     */
    public function secretaire()
    {
        $user = Auth::user();
        $stats = [
            'todayAppointmentsCount' => RendezVous::whereDate('date_rendez_vous', Carbon::today())->count(),
            'newPatientsCount' => Patient::whereDate('created_at', Carbon::today())->count(),
            'upcomingAppointments' => RendezVous::with(['patient', 'medecin'])->where('date_rendez_vous', '>', Carbon::now())->orderBy('date_rendez_vous', 'asc')->take(5)->get(),
        ];
        return view('dashboards.secretaire', compact('stats', 'user'));
    }

    /**
     * Affiche le tableau de bord du patient.
     */
    public function patient()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->first();
        $patientId = $user->id;

        $upcomingAppointmentsQuery = RendezVous::where('patient_id', $patientId)
            ->where('date_rendez_vous', '>', Carbon::now());

        $pastAppointmentsQuery = RendezVous::where('patient_id', $patientId)
            ->where('date_rendez_vous', '<=', Carbon::now());

        $stats = [
            'upcomingAppointmentsCount' => $upcomingAppointmentsQuery->count(),
            'pastAppointmentsCount' => $pastAppointmentsQuery->count(),
        ];

        $upcomingAppointments = $upcomingAppointmentsQuery
            ->with('medecin.user')
            ->orderBy('date_rendez_vous', 'asc')
            ->take(5)
            ->get();

        $pastAppointments = $pastAppointmentsQuery
            ->with('medecin.user')
            ->orderBy('date_rendez_vous', 'desc')
            ->take(5)
            ->get();

        return view('dashboards.patient', compact('user', 'patient', 'stats', 'upcomingAppointments', 'pastAppointments'));
    }

    /**
     * Affiche le tableau de bord de l'infirmier.
     */
    public function infirmier()
    {
        $user = Auth::user();
        $stats = [
            'hospitalizedPatientsCount' => \App\Models\Hospitalisation::where('statut', 'actif')->count(),
            'recentlyAdmittedPatients' => \App\Models\Patient::whereHas('hospitalisations', function ($query) {
                $query->where('statut', 'actif');
            })->latest()->take(5)->get(),
            'todayCaresCount' => 0, // Logique à implémenter
        ];
        return view('dashboards.infirmier', compact('stats', 'user'));
    }

    /**
     * Affiche le tableau de bord du pharmacien.
     */
    public function pharmacien()
    {
        $user = Auth::user();
        $stats = [
            'pendingPrescriptionsCount' => \App\Models\Prescription::where('statut', 'en_attente')->count(),
            'lowStockMedicationsCount' => 0, // Logique à implémenter
            'latestPrescriptions' => \App\Models\Prescription::where('statut', 'en_attente')->with('patient', 'medecin')->latest()->take(5)->get(),
        ];
        return view('dashboards.pharmacien', compact('stats', 'user'));
    }

    /**
     * Affiche le tableau de bord du caissier.
     */
    public function caissier()
    {
        $user = Auth::user();
        $stats = [
            'pendingInvoicesCount' => Facture::where('statut', '!=', 'payée')->count(),
            'todayRevenue' => Facture::whereDate('updated_at', Carbon::today())->where('statut', 'payée')->sum('montant_ttc'),
            'latestInvoices' => Facture::with('patient')->where('statut', '!=', 'payée')->latest()->take(5)->get(),
        ];
        return view('dashboards.caissier', compact('stats', 'user'));
    }
}
