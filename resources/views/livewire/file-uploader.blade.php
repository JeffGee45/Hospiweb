<div>
    @if(!$isUploaded)
        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
            <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-gray-600">
                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                        <span>Télécharger un fichier</span>
                        <input id="file-upload" name="file-upload" type="file" class="sr-only" wire:model="file">
                    </label>
                    <p class="pl-1">ou glisser-déposer</p>
                </div>
                <p class="text-xs text-gray-500">
                    {{ $attributes->get('file-types', 'PNG, JPG, PDF jusqu\'à 10MB') }}
                </p>
            </div>
        </div>
        @error('file')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    @else
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
            <div class="flex items-center space-x-3">
                @php
                    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                    $icon = 'document';
                    if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
                        $icon = 'photograph';
                    } elseif (strtolower($extension) === 'pdf') {
                        $icon = 'document-text';
                    } elseif (in_array(strtolower($extension), ['doc', 'docx'])) {
                        $icon = 'document-text';
                    } elseif (in_array(strtolower($extension), ['xls', 'xlsx'])) {
                        $icon = 'table';
                    }
                @endphp
                <div class="flex-shrink-0">
                    @if($icon === 'photograph' && $url)
                        <img class="h-10 w-10 object-cover rounded" src="{{ $url }}" alt="">
                    @else
                        <div class="h-10 w-10 flex items-center justify-center bg-blue-100 rounded">
                            <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                @if($icon === 'photograph')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                @elseif($icon === 'document-text')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                @elseif($icon === 'table')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                @endif
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ $originalName }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ Storage::disk('public')->size($path) / 1024 }} KB
                    </p>
                </div>
            </div>
            <button type="button" wire:click="removeFile" class="ml-4 bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <span class="sr-only">Supprimer</span>
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    @endif
</div>
