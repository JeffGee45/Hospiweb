<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Hospitalisation;
use App\Models\User;
use App\Models\Patient;
use App\Models\PrescriptionMedicament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RapportController extends Controller
{
    /**
     * Affiche la page principale des rapports avec des statistiques clés.
     */
    public function index()
    {
        $stats = [
            'consultations_par_medecin' => User::where('role', 'Medecin')->withCount('consultations')->get(),
            'hospitalisations_en_cours' => Hospitalisation::whereNull('date_sortie_reelle')->count(),
            'medicaments_plus_prescrits' => DB::table('ordonnance_medicament')
                ->join('medicaments', 'ordonnance_medicament.medicament_id', '=', 'medicaments.id')
                ->select('medicaments.nom_commercial', DB::raw('count(*) as total'))
                ->groupBy('medicaments.nom_commercial')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get(),
            'total_patients' => Patient::count(),
        ];

        return view('rapports.index', compact('stats'));
    }

    /**
     * Exporte le rapport des consultations par médecin en PDF.
     */
    public function exportConsultationsParMedecin()
    {
        $data = User::where('role', 'Medecin')->withCount('consultations')->get();
        $pdf = Pdf::loadView('rapports.pdf.consultations-par-medecin', ['data' => $data]);
        return $pdf->download('rapport-consultations-par-medecin-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exporte la liste des hospitalisations en cours en PDF.
     */
    public function exportHospitalisationsEnCours()
    {
        $data = Hospitalisation::with('patient')->whereNull('date_sortie_reelle')->get();
        $pdf = Pdf::loadView('rapports.pdf.hospitalisations-en-cours', ['data' => $data]);
        return $pdf->download('rapport-hospitalisations-en-cours-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exporte le rapport des médicaments les plus prescrits en PDF.
     */
    public function exportMedicamentsPrescrits()
    {
        $data = DB::table('ordonnance_medicament')
            ->join('medicaments', 'ordonnance_medicament.medicament_id', '=', 'medicaments.id')
            ->select('medicaments.nom_commercial', DB::raw('count(*) as total'))
            ->groupBy('medicaments.nom_commercial')
            ->orderBy('total', 'desc')
            ->limit(20)
            ->get();
        $pdf = Pdf::loadView('rapports.pdf.medicaments-prescrits', ['data' => $data]);
        return $pdf->download('rapport-medicaments-les-plus-prescrits-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exporte les statistiques sur les patients en PDF.
     */
    public function exportStatistiquesPatients()
    {
        $patients = Patient::all();
        $total = $patients->count();
        $par_sexe = $patients->groupBy('sexe')->map->count();

        $par_age = [
            '0-18 ans' => 0,
            '19-35 ans' => 0,
            '36-50 ans' => 0,
            '51+ ans' => 0,
        ];

        foreach ($patients as $patient) {
            $age = Carbon::parse($patient->date_naissance)->age;
            if ($age <= 18) $par_age['0-18 ans']++;
            elseif ($age <= 35) $par_age['19-35 ans']++;
            elseif ($age <= 50) $par_age['36-50 ans']++;
            else $par_age['51+ ans']++;
        }

        $data = compact('total', 'par_sexe', 'par_age');
        $pdf = Pdf::loadView('rapports.pdf.statistiques-patients', ['data' => $data]);
        return $pdf->download('rapport-statistiques-patients-' . date('Y-m-d') . '.pdf');
    }
}
