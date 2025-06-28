<?php

namespace App\Http\Controllers\Medecin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class RendezVousController extends Controller
{
    /**
     * Affiche la liste des rendez-vous du médecin connecté
     */
    public function index(Request $request)
    {
        if ($request->has('vue') && $request->vue === 'calendrier') {
            return $this->calendar();
        }

        $rendezVous = RendezVous::with(['patient', 'medecin'])
            ->where('medecin_id', Auth::id())
            ->latest('date_rendez_vous')
            ->paginate(15);

        return view('medecin.rendez-vous.index', compact('rendezVous'));
    }

    /**
     * Affiche le calendrier des rendez-vous
     */
    public function calendar()
    {
        $events = [];
        $rendezVous = RendezVous::with(['patient'])
            ->where('medecin_id', Auth::id())
            ->get();

        foreach ($rendezVous as $rdv) {
            $events[] = [
                'title' => $rdv->patient->prenom . ' ' . $rdv->patient->nom . ' - ' . $rdv->motif,
                'start' => $rdv->date_rendez_vous,
                'end' => $rdv->date_rendez_vous->addHour(),
                'url' => route('medecin.rendez-vous.show', $rdv->id),
                'backgroundColor' => $this->getStatusColor($rdv->statut),
                'borderColor' => $this->getStatusColor($rdv->statut),
                'textColor' => '#fff',
                'id' => $rdv->id
            ];
        }

        $calendar = Calendar::addEvents($events)
            ->setOptions([
                'locale' => 'fr',
                'header' => [
                    'left' => 'prev,next today',
                    'center' => 'title',
                    'right' => 'month,agendaWeek,agendaDay'
                ],
                'buttonText' => [
                    'today' => 'Aujourd\'hui',
                    'month' => 'Mois',
                    'week' => 'Semaine',
                    'day' => 'Jour'
                ],
                'navLinks' => true,
                'editable' => false,
                'selectable' => false,
                'displayEventTime' => true,
                'timeFormat' => 'H:mm',
                'firstDay' => 1,
                'weekNumbers' => true,
                'eventLimit' => true,
            ]);

        return view('medecin.rendez-vous.calendar', compact('calendar'));
    }

    /**
     * Retourne la couleur en fonction du statut du rendez-vous
     */
    protected function getStatusColor($status)
    {
        return match ($status) {
            'Confirmé' => '#10B981', // Vert
            'En attente' => '#F59E0B', // Jaune
            'Annulé' => '#EF4444', // Rouge
            'Terminé' => '#6B7280', // Gris
            default => '#3B82F6', // Bleu par défaut
        };
    }

    /**
     * Affiche les détails d'un rendez-vous spécifique
     */
    public function show($id)
    {
        $rendezVous = RendezVous::with(['patient', 'medecin'])
            ->where('medecin_id', Auth::id())
            ->findOrFail($id);

        return view('medecin.rendez-vous.show', compact('rendezVous'));
    }

    /**
     * Annule un rendez-vous
     */
    public function annuler($id)
    {
        $rendezVous = RendezVous::where('medecin_id', Auth::id())
            ->findOrFail($id);

        if ($rendezVous->statut !== 'Annulé') {
            $rendezVous->update(['statut' => 'Annulé']);
            return redirect()
                ->route('medecin.rendez-vous.index')
                ->with('success', 'Le rendez-vous a été annulé avec succès.');
        }

        return redirect()
            ->route('medecin.rendez-vous.index')
            ->with('error', 'Ce rendez-vous est déjà annulé.');
    }
}
