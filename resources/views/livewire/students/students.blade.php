@section('title', 'Students')

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

    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Students
    </h2>

    <!-- With avatar -->
    @include('includes.search', ["fields" => [
    "first_name" => "First name",
    "middle_name" => "Middle name",
    "last_name" => "Last name",
    "grade_level" => "Grade level",
    "gpa" => "GPA"
    ]])

    <div class="w-full my-5 overflow-hidden rounded-lg shadow-xs">
        @include('livewire.students.student-edit-modal')
        @include('livewire.students.student-delete-modal')
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
                                @include('includes.order-by', ["field" => 'student_id'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                First name
                                @include('includes.order-by', ["field" => 'first_name'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Middle name
                                @include('includes.order-by', ["field" => 'middle_name'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Last name
                                @include('includes.order-by', ["field" => 'last_name'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Grade Level
                                @include('includes.order-by', ["field" => 'grade_level'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                GPA
                                @include('includes.order-by', ["field" => 'gpa'])
                            </span>
                        </th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($students as $student)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-2 text-sm">
                                {{ $student->student_id }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $student->first_name }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $student->middle_name }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $student->last_name }}
                            </td>
                            <td class="px-4 py-2">
                                Grade {{ $student->grade_level }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $student->gpa }}
                            </td>
                            <td class="px-4 py-2">
                                <button wire:click.prevent="edit({{ $student->student_id }})"
                                    class="mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-yellow-400 border border-transparent rounded-md active:bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:shadow-outline-purple">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <button wire:click.prevent="openDelete({{ $student->student_id }})"
                                    class="mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-400 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                                <!-- Toggle buttons -->

                                @if ($openMore && $student->student_id == $studentMore->student_id)
                                    <button wire:click.prevent="closeMoreModal()"
                                        class="mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-400 border border-transparent rounded-md active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7" />
                                        </svg>
                                    </button>
                                @else
                                    <button wire:click.prevent="openMoreModal({{ $student->student_id }})"
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
                        @if ($openMore && $student->student_id == $studentMore->student_id)
                            <tr wire:model="openMore">
                                <td colspan="6">
                                    <div class="m-10" class="transition duration-500 ease-in-out">
                                        <p
                                            class="mb-5 text-lg text-center font-semibold text-gray-700 dark:text-gray-300">
                                            More information about this student
                                        </p>
                                        @if ($student->section->count() != 0)
                                            @foreach ($student->section as $section)
                                                <div class="bg-purple-500 text-white rounded-lg w-max-content p-5">
                                                    <p>Student is
                                                        enrolled to
                                                        section <span
                                                            class="text-bold">{{ $section->section_name }}</span>
                                                    </p>
                                                    <button
                                                        wire:click.prevent="removeStudentModal({{ $student->student_id }})"
                                                        class="mt-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-800 border border-transparent rounded-md active:bg-purple-500 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg> Remove student from section
                                                    </button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="bg-purple-500 rounded-lg max-w-md p-5">
                                                <p class="text-white">Add student to section</p>
                                                <select wire:model="section_id"
                                                    class="block w-full mt-4 mb-4 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                                    <option value="">Please select a section to add to</option>
                                                    @foreach ($sections_for_grade_level as $section)
                                                        <option value="{{ $section->section_id }}">
                                                            {{ $section->section_name }}</option>
                                                    @endforeach
                                                </select>
                                                <button
                                                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                                                    wire:click.prevent="addStudentToSection()" type="button">
                                                    Add student
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $students->links() }}
</div>
