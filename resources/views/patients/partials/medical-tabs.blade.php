@props(['patient', 'active' => 'overview'])

<div class="bg-white rounded-lg shadow overflow-hidden mb-6">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <a href="{{ route('dossiers.show', $patient) }}" 
               class="{{ $active === 'overview' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                      border-b-2 py-4 px-6 text-sm font-medium">
                Vue d'ensemble
            </a>
            <a href="{{ route('dossiers.consultations', $patient) }}" 
               class="{{ $active === 'consultations' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                      border-b-2 py-4 px-6 text-sm font-medium">
                Consultations
                <span class="ml-1 bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                    {{ $patient->consultations_count ?? 0 }}
                </span>
            </a>
            <a href="{{ route('dossiers.hospitalisations', $patient) }}" 
               class="{{ $active === 'hospitalisations' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                      border-b-2 py-4 px-6 text-sm font-medium">
                Hospitalisations
                <span class="ml-1 bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                    {{ $patient->hospitalisations_count ?? 0 }}
                </span>
            </a>
            <a href="{{ route('dossiers.examens', $patient) }}" 
               class="{{ $active === 'examens' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                      border-b-2 py-4 px-6 text-sm font-medium">
                Examens
                <span class="ml-1 bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                    {{ $patient->examens_count ?? 0 }}
                </span>
            </a>
            <a href="{{ route('dossiers.prescriptions', $patient) }}" 
               class="{{ $active === 'prescriptions' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                      border-b-2 py-4 px-6 text-sm font-medium">
                Ordonnances
                <span class="ml-1 bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                    {{ $patient->prescriptions_count ?? 0 }}
                </span>
            </a>
        </nav>
    </div>
</div>
