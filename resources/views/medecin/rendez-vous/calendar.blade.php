@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Mon Agenda</h1>
            <div class="flex space-x-4">
                <a href="{{ route('medecin.rendez-vous.index') }}" 
                   class="flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Vue Liste
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4">
                {!! $calendar->calendar() !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    {!! $calendar->script() !!}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Rediriger vers les détails du rendez-vous lors du clic sur un événement
            document.addEventListener('click', function(e) {
                if (e.target.closest('.fc-event')) {
                    const event = e.target.closest('.fc-event');
                    const eventId = event.getAttribute('data-event-id');
                    if (eventId) {
                        window.location.href = '{{ url('medecin/rendez-vous') }}/' + eventId;
                    }
                }
            });
        });
    </script>
@endpush
