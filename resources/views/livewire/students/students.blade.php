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

    <h2 class="text-center my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        STUDENTS
    </h2>

    <!-- With avatar -->
    <div class="flex justify-between">
        <!-- <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            List of subjects
        </h4> -->
        <!-- Search input -->
        <div class="container flex justify-between align-center">
            <div class="relative inset-y-0 flex items-center pl-2 mr-5">
                <label class="dark:text-white mr-5">Search by</label>
                <select
                    class="mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    wire:model="searchBy">
                    <option value="all" selected>All</option>
                    <option value="first_name">First name</option>
                    <option value="middle_name">Middle name</option>
                    <option value="last_name">Last name</option>
                    <option value="grade_level">Grade level</option>
                    <option value="gpa">GPA</option>
                </select>
            </div>
            <div class="relative flex items-center w-full max-w-xl mr-6 focus-within:text-purple-500">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input wire:model="search"
                    class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                    type="text" placeholder="Search" aria-label="Search" />
            </div>
            <button wire:click.prevent="$toggle('openEdit')"
                class=" mb-4 px-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-full active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>
    </div>

    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        @if ($openEdit)
            @include('livewire.students.student-edit-modal')
        @endif
        @if ($openDelete)
            @include('livewire.students.student-delete-modal')
        @endif
        <div class="w-full overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                ID
                                <span class="bg-blue-500 text-white ml-2 rounded-md px-2 py-1 cursor-pointer"
                                    wire:click="students_orderby('student_id', 'desc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                                <span class="bg-green-500 text-white ml-2 rounded-md px-2 py-1 cursor-pointer"
                                    wire:click="students_orderby('student_id', 'asc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 15l7-7 7 7" />
                                    </svg>
                                </span>
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                First name
                                <span class="bg-blue-500 text-white ml-2 rounded-md px-2 py-1 cursor-pointer"
                                    wire:click="students_orderby('first_name', 'desc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                                <span class="bg-green-500 text-white ml-2 rounded-md px-2 py-1 cursor-pointer"
                                    wire:click="students_orderby('first_name', 'asc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 15l7-7 7 7" />
                                    </svg>
                                </span>
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Middle name
                                <span class="bg-blue-500 text-white ml-2 rounded-md px-2 py-1 cursor-pointer"
                                    wire:click="students_orderby('middle_name', 'desc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                                <span class="bg-green-500 text-white ml-2 rounded-md px-2 py-1 cursor-pointer"
                                    wire:click="students_orderby('middle_name', 'asc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 15l7-7 7 7" />
                                    </svg>
                                </span>
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Last name
                                <span class="bg-blue-500 text-white ml-2 rounded-md px-2 py-1 cursor-pointer"
                                    wire:click="students_orderby('last_name', 'desc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                                <span class="bg-green-500 text-white ml-2 rounded-md px-2 py-1 cursor-pointer"
                                    wire:click="students_orderby('last_name', 'asc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 15l7-7 7 7" />
                                    </svg>
                                </span>
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Grade Level
                                <span class="bg-blue-500 text-white ml-2 rounded-md px-2 py-1 cursor-pointer"
                                    wire:click="students_orderby('grade_level', 'desc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                                <span class="bg-green-500 text-white ml-2 rounded-md px-2 py-1 cursor-pointer"
                                    wire:click="students_orderby('grade_level', 'asc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 15l7-7 7 7" />
                                    </svg>
                                </span>
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                GPA
                                <span class="bg-blue-500 text-white ml-2 rounded-md px-2 py-1 cursor-pointer"
                                    wire:click="students_orderby('gpa', 'desc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                                <span class="bg-green-500 text-white ml-2 rounded-md px-2 py-1 cursor-pointer"
                                    wire:click="students_orderby('gpa', 'asc')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 15l7-7 7 7" />
                                    </svg>
                                </span>
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $students->links() }}
</div>
