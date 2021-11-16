@section('title', 'Teachers')

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
        Teachers
    </h2>

    <!-- With avatar -->
    @include('includes.search', ["fields" => [
    "first_name" => "First name",
    "middle_name" => "Middle name",
    "last_name" => "Last name"
    ]])

    <div class="w-full my-5 overflow-hidden rounded-lg shadow-xs">
        @include('livewire.teachers.teacher-edit-modal')
        @include('livewire.teachers.teacher-delete-modal')
        <div class="w-full overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Record ID
                                @include('includes.order-by', ["field" => 'teacher_id'])
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
                        @if (Auth::user()->department_dept_id == null)
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Department
                                    @include('includes.order-by', ["field" => "department_dept_id"])
                                </span>
                            </th>
                        @endif
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Actions
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @if ($teachers->count())
                        @foreach ($teachers as $teacher)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-2 text-sm">
                                    {{ $teacher->teacher_id }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $teacher->first_name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $teacher->middle_name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $teacher->last_name }}
                                </td>
                                @if (Auth::user()->department_dept_id == null)
                                    <td class="px-4 py-2">
                                        @php
                                            $dept = $teacher->department_dept_id;
                                        @endphp
                                        @if ($dept == 1) Elementary @elseif ($dept == 2) Junior High School @elseif ($dept == 3) Senior High School @endif
                                    </td>
                                @endif
                                <td class="px-4 py-2">
                                    <button wire:click.prevent="edit({{ $teacher->teacher_id }})"
                                        class="mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-yellow-400 border border-transparent rounded-md active:bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:shadow-outline-purple">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button wire:click.prevent="openDelete({{ $teacher->teacher_id }})"
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
                    @else
                        <tr>
                            <td colspan="  @if (Auth::user()->department_dept_id ==
                                null)
                                6
                            @else
                                5
                                @endif">
                                @include('includes.no-result')
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{ $teachers->links() }}
</div>
