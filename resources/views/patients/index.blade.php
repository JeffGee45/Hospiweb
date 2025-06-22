@extends('layouts.app')

@section('content')
    


          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4">
              <p class="text-[#111518] tracking-light text-[32px] font-bold leading-tight min-w-72">Patients</p>
              <a href="{{ route('patients.create') }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-blue-600 text-white text-sm font-medium leading-normal hover:bg-blue-700">
                <span class="truncate">Ajouter un patient</span>
              </a>
            </div>
            <div class="px-4 py-3">
              <label class="flex flex-col min-w-40 h-12 w-full">
                <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                  <div
                    class="text-[#637988] flex border-none bg-[#f0f3f4] items-center justify-center pl-4 rounded-l-lg border-r-0"
                    data-icon="MagnifyingGlass"
                    data-size="24px"
                    data-weight="regular"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"
                      ></path>
                    </svg>
                  </div>
                  <input
                    placeholder="Search patients"
                    class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111518] focus:outline-0 focus:ring-0 border-none bg-[#f0f3f4] focus:border-none h-full placeholder:text-[#637988] px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal"
                    value=""
                  />
                </div>
              </label>
            </div>
            <div class="flex justify-between items-center px-4 py-3">
              <h2 class="text-xl font-semibold text-[#111518]">Liste des patients</h2>
              {{-- <a href="{{ route('patients.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Ajouter un patient</a> --}}
            </div>

            @if ($message = Session::get('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4" role="alert">
                    <span class="block sm:inline">{{ $message }}</span>
                </div>
            @endif

            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-lg border border-[#dce1e5] bg-white">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-white">
                      <th class="px-4 py-3 text-left text-sm font-medium leading-normal text-[#111518]">Nom</th>
                      <th class="px-4 py-3 text-left text-sm font-medium leading-normal text-[#111518]">Date de naissance</th>
                      <th class="px-4 py-3 text-left text-sm font-medium leading-normal text-[#111518]">Genre</th>
                      <th class="px-4 py-3 text-left text-sm font-medium leading-normal text-[#111518]">Dernière consultation</th>
                      <th class="px-4 py-3 text-left text-sm font-medium leading-normal text-[#111518]">Status</th>
                      <th class="px-4 py-3 text-left text-sm font-medium leading-normal text-[#111518]">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($patients as $patient)
                    <tr class="border-t border-t-[#dce1e5]">
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-[#111518]">
                            {{ $patient->prenom }} {{ $patient->nom }}
                        </td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-[#637988]">
                            {{ $patient->date_of_birth ?? 'N/D' }}
                        </td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-[#637988]">
                            {{ $patient->gender ?? 'N/D' }}
                        </td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-[#637988]">
                            {{ $patient->last_visit ?? 'N/D' }}
                        </td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal text-[#637988]">
                           {{ $patient->status }}
                        </td>
                        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('patients.show', $patient->id) }}" class="text-gray-500 hover:text-blue-600" title="Voir le patient">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="{{ route('patients.edit', $patient->id) }}" class="text-gray-500 hover:text-green-600" title="Modifier le patient">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce patient ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-500 hover:text-red-600" title="Supprimer le patient">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <style>
                          @container(max-width:120px){.table-d0cf809f-0ebf-4f15-9b1c-e4c56bb135c1-column-120{display: none;}}
                @container(max-width:240px){.table-d0cf809f-0ebf-4f15-9b1c-e4c56bb135c1-column-240{display: none;}}
                @container(max-width:360px){.table-d0cf809f-0ebf-4f15-9b1c-e4c56bb135c1-column-360{display: none;}}
                @container(max-width:480px){.table-d0cf809f-0ebf-4f15-9b1c-e4c56bb135c1-column-480{display: none;}}
                @container(max-width:600px){.table-d0cf809f-0ebf-4f15-9b1c-e4c56bb135c1-column-600{display: none;}}
              </style>
            </div>
          </div>

           
          @endsection