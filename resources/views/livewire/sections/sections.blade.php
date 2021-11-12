@section('title', 'Sections')

<div class="container grid px-6 py-6 mx-auto">

    @if (session()->has('message'))
        <div class="flex items-center bg-blue-700 text-white text-sm font-bold px-4 py-4 my-3 rounded-lg" role="alert">
            <p class="text-sm">{{ session('message') }}</p>
        </div>
        <br>
    @endif
    @if (session()->has('warning'))
        <div class="flex items-center bg-yellow-400 text-white text-sm font-bold px-4 py-4 my-3 rounded-lg" role="alert">
            <p class="text-sm">{{ session('warning') }}</p>
        </div>
        <br>
    @endif
    @if (session()->has('alert'))
        <div class="flex items-center bg-red-400 text-white text-sm font-bold px-4 py-4 my-3 rounded-lg" role="alert">
            <p class="text-sm">{{ session('alert') }}</p>
        </div>
        <br>
    @endif
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Sections
    </h2>

    <!-- With avatar -->
    @include('includes.search', ["fields" => [
    "section_name" => "Section name",
    "grade_level" => "Grade level"
    ]])

    <div class="w-full my-5 overflow-hidden rounded-lg shadow-xs">
        @include('livewire.sections.section-edit-modal')
        @include('livewire.sections.section-delete-modal')
        @if ($openMakestar)
            @include('livewire.sections.section-makestar-modal')
        @endif
        @if ($removeStudent)
            @include('livewire.sections.section-remove-student-modal')
        @endif
        <div class="w-full overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Record ID
                                @include('includes.order-by', ["field" => "section_id"])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Section name
                                @include('includes.order-by', ["field" => "section_name"])
                            </span>
                        </th>
                        @if (Auth::user()->department_dept_id != 1)
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Star section?
                                    @include('includes.order-by', ["field" => "is_star"])
                                </span>
                            </th>
                        @endif
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Grade level
                                @include('includes.order-by', ["field" => "grade_level"])
                            </span>
                        </th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($sections as $sec)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-2 text-sm">
                                {{ $sec->section_id }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $sec->section_name }}
                            </td>
                            @if (Auth::user()->department_dept_id != 1)
                                <td class="px-4 py-2">
                                    @if ($sec->is_star)
                                        Yes
                                    @else
                                        No
                                    @endif
                            @endif
                            </td>
                            <td class="px-4 py-2">
                                Grade {{ $sec->grade_level }}
                            </td>
                            <td class="px-4 py-2">
                                <button wire:click.prevent="edit({{ $sec->section_id }})"
                                    class="mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-yellow-400 border border-transparent rounded-md active:bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:shadow-outline-purple">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <button wire:click.prevent="openDelete({{ $sec->section_id }})"
                                    class="mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-400 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @if ($sec->department_dept_id != 1)
                                    <button
                                        wire:click.prevent="makeStarModal({{ $sec->section_id }}, {{ $sec->department_dept_id }})"
                                        class="mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-orange-400 border border-transparent rounded-md active:bg-orange-600 hover:bg-orange-700 focus:outline-none focus:shadow-outline-purple">
                                        @if ($sec->is_star)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        @endif
                                    </button>
                                @endif
                                <!-- Toggle buttons -->

                                @if ($openMore && $sec->section_id == $section->section_id)
                                    <button wire:click.prevent="closeMoreModal()"
                                        class="mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-400 border border-transparent rounded-md active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7" />
                                        </svg>
                                    </button>
                                @else
                                    <button wire:click.prevent="openMoreModal({{ $sec->section_id }})"
                                        class="mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-400 border border-transparent rounded-md active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @if ($openMore && $sec->section_id == $section->section_id)
                            <tr>
                                <td colspan="5">
                                    <div class="m-3">
                                        <p
                                            class="mb-3 text-lg text-center font-semibold text-gray-700 dark:text-gray-300">
                                            Students in this section
                                        </p>
                                        <div class="grid gap-3 grid-cols-5">
                                            @foreach ($sec->students as $student)
                                                <div class="p-3 rounded-lg bg-purple-700">
                                                    <p class="text-gray-100 dark:text-gray-100">
                                                        {{ $student->last_name . ', ' . $student->first_name . ' ' . $student->middle_name }}
                                                    </p>
                                                    <button
                                                        wire:click.prevent="removeStudentModal({{ $student->student_id }})"
                                                        class="mt-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-400 border border-transparent rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $sections->links() }}
</div>
