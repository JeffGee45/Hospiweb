@extends('layouts.app')

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    #calendar {
        max-width: 1100px;
        margin: 40px auto;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight">Calendrier des Rendez-vous</h2>
        <div id='calendar'></div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '{{ route("secretaire.rendez-vous.events") }}',
            eventClick: function(info) {
                alert('Motif: ' + info.event.extendedProps.motif + '\nStatut: ' + info.event.extendedProps.statut);
            }
        });
        calendar.render();
    });
</script>
@endsection
