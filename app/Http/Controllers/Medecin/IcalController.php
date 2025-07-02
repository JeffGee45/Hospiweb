<?php

namespace App\Http\Controllers\Medecin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Components\Timezone;
use Symfony\Component\HttpFoundation\Response;

class IcalController extends Controller
{
    /**
     * Génère un fichier iCal pour un rendez-vous spécifique
     */
    public function show($id)
    {
        $rendezVous = RendezVous::with(['patient', 'medecin'])
            ->where('medecin_id', Auth::id())
            ->findOrFail($id);

        $event = Event::create()
            ->name('Rendez-vous avec ' . $rendezVous->patient->prenom . ' ' . $rendezVous->patient->nom)
            ->description('Motif: ' . $rendezVous->motif . '\nNotes: ' . ($rendezVous->notes ?? 'Aucune note'))
            ->startsAt($rendezVous->date_rendez_vous)
            ->endsAt($rendezVous->date_rendez_vous->copy()->addHour())
            ->address($rendezVous->lieu ?? 'Non spécifié');

        $calendar = Calendar::create()
            ->timezone(Timezone::create('Europe/Paris'))
            ->event($event);

        return response($calendar->get())
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="rendez-vous-' . $rendezVous->id . '.ics"');
    }

    /**
     * Génère un fichier iCal pour tous les rendez-vous du médecin
     */
    public function index()
    {
        $rendezVous = RendezVous::with(['patient', 'medecin'])
            ->where('medecin_id', Auth::id())
            ->get();

        $events = [];
        foreach ($rendezVous as $rdv) {
            $events[] = Event::create()
                ->name('Rendez-vous avec ' . $rdv->patient->prenom . ' ' . $rdv->patient->nom)
                ->description('Motif: ' . $rdv->motif . '\nNotes: ' . ($rdv->notes ?? 'Aucune note'))
                ->startsAt($rdv->date_rendez_vous)
                ->endsAt($rdv->date_rendez_vous->copy()->addHour())
                ->address($rdv->lieu ?? 'Non spécifié');
        }

        $calendar = Calendar::create()
            ->timezone(Timezone::create('Europe/Paris'))
            ->event($events);

        return response($calendar->get())
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="mes-rendez-vous.ics"');
    }
}
