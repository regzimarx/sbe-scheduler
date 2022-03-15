@section('title', 'Schedules')

<div class="container grid px-6 py-6 mx-auto">

    @include('includes.messages')

    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Schedules
    </h2>

    <div class="mb-20 shadow-md">
        <form class="w-full p-5">
            <select
                class="block w-full mt-4 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                id="sched_grade_level" wire:model="sched_grade_level">
                <option value="">Please select grade level</option>
                @if (Auth::user()->department_dept_id == 1)
                    <option value="13">Kindergarten 1</option>
                    <option value="14">Kindergarten 2</option>
                @endif
                @for ($i = $grade_level_start; $i <= $grade_level_end; $i++)
                    <option value="{{ $i }}">
                        Grade {{ $i }}
                    </option>
                @endfor
            </select>
            @if ($sched_sections)
                <select
                    class="block w-full mt-4 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    id="sched_section" wire:model="sched_section">
                    <option value="">Please select section</option>
                    @foreach ($sched_sections as $section)
                        <option value="{{ $section->section_id }}">{{ $section->section_name }}</option>
                    @endforeach
                </select>
            @endif
            @if ($sched_rooms)
                <select
                    class="block w-full mt-4 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    id="sched_room" wire:model="sched_room">
                    <option value="">Please select room</option>
                    @foreach ($sched_rooms as $room)
                        <option value="{{ $room->room_id }}">{{ $room->room_name }}</option>
                    @endforeach
                </select>
            @endif
            @if ($sched_room)
                <label class="block text-sm mt-4">
                    <label class="mb-2 dark:text-gray-300">Start time</label>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Enter start time" type="time" wire:model="sched_time_start"
                        id="sched_time_start" />
                </label>
                <label class="block text-sm mt-4">
                    <label class="mb-2 dark:text-gray-300">End time</label>
                    <input
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Enter end time" type="time" wire:model="sched_time_end" id="sched_time_end" />
                </label>
                <label class="block text-sm mt-4">
                    <label class="mb-2 dark:text-gray-300">Days</label>
                    <select
                        class="block w-full mt-4 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        wire:model="day" id="day" multiple>
                        <option value="" disabled>Please select day/s (CTRL + click to select multiple days)
                        </option>
                        @foreach ($days as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </label>
                <select
                    class="block w-full mt-4 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    wire:model="subject_id" id="subject_id">
                    <option value="">Please select subject</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                    @endforeach
                </select>
                <select
                    class="block w-full mt-4 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    wire:model="teacher_id" id="teacher_id">
                    <option value="">Please select teacher</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->teacher_id }}">{{ $teacher->last_name }},
                            {{ $teacher->first_name }} {{ $teacher->middle_name }}</option>
                    @endforeach
                </select>
                <button
                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray mt-3">
                    Clear
                </button>
                <button
                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple mt-3"
                    wire:click.prevent="sched_store()" type="button">
                    Save
                </button>
            @endif
        </form>
        <div class="w-full p-5 mt-2 mr-5">
            <p class="text-xl text-center">Academic Year: {{ now()->year }} - {{ now()->year + 1 }}</p>
            @if ($sched_grade_level)
                <p class="text-xl text-center">Grade level: Grade {{ $sched_grade_level }}</p>
            @endif
            @if ($sched_section_object)
                <p class="text-xl text-center">Section: {{ $sched_section_object->section_name }}</p>
                @if (Auth::user()->department_dept_id == 3)
                    <p class="text-xl text-center">Strand:
                        @php
                            $strand = $sched_section_object->strand;
                        @endphp
                        @if ($strand == 'stem')
                            Science, Technology, Engineering, and Mathematics
                        @elseif ($strand == 'humss')
                            Humanities and Social Sciences
                        @elseif ($strand == 'abm')
                            Accountancy, Business and Management
                        @endif
                @endif
            @endif
            </p>
            @if ($sched_room_object)
                <p class="text-xl text-center">Room: {{ $sched_room_object->room_name }}</p>
            @endif
            @if ($sched_section_object)
                <table class="table-auto w-full m-5 text-left border text-center p-2">
                    <thead class="border text-center p-2">
                        <tr class="border text-center p-2">
                            <th class="border text-center p-2">Time</th>
                            <th class="border text-center p-2">Monday</th>
                            <th class="border text-center p-2">Tuesday</th>
                            <th class="border text-center p-2">Wednesday</th>
                            <th class="border text-center p-2">Thursday</th>
                            <th class="border text-center p-2">Friday</th>
                        </tr>
                    </thead>
                    <tbody class="border text-center p-2">
                        @foreach ($time_starts as $time)
                            <tr class="border text-center p-2">
                                <td class="border text-center p-2">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->time_start)->format('h:i A') }}
                                    -
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->time_end)->format('h:i A') }}
                                </td>
                                <td class="border text-center p-2">
                                    @foreach ($sched_schedules as $sched)
                                        @if (in_array('Monday', explode(', ', $sched->day)) && $time->time_start == $sched->time_start)
                                            <p class="font-semibold">{{ $sched->subject->subject_name }}
                                            </p>
                                            <p class="italic">{{ $sched->teacher->getFullNameAttribute() }}
                                            </p>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="border text-center p-2">
                                    @foreach ($sched_schedules as $sched)
                                        @if (in_array('Tuesday', explode(', ', $sched->day)) && $time->time_start == $sched->time_start)
                                            <p class="font-semibold">{{ $sched->subject->subject_name }}
                                            </p>
                                            <p class="italic">{{ $sched->teacher->getFullNameAttribute() }}
                                            </p>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="border text-center p-2">
                                    @foreach ($sched_schedules as $sched)
                                        @if (in_array('Wednesday', explode(', ', $sched->day)) && $time->time_start == $sched->time_start)
                                            <p class="font-semibold">{{ $sched->subject->subject_name }}
                                            </p>
                                            <p class="italic">{{ $sched->teacher->getFullNameAttribute() }}
                                            </p>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="border text-center p-2">
                                    @foreach ($sched_schedules as $sched)
                                        @if (in_array('Thursday', explode(', ', $sched->day)) && $time->time_start == $sched->time_start)
                                            <p class="font-semibold">{{ $sched->subject->subject_name }}
                                            </p>
                                            <p class="italic">{{ $sched->teacher->getFullNameAttribute() }}
                                            </p>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="border text-center p-2">
                                    @foreach ($sched_schedules as $sched)
                                        @if (in_array('Friday', explode(', ', $sched->day)) && $time->time_start == $sched->time_start)
                                            <p class="font-semibold">{{ $sched->subject->subject_name }}
                                            </p>
                                            <p class="italic">{{ $sched->teacher->getFullNameAttribute() }}
                                            </p>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        @if ($sched_section_object)
            <div class="flex justify-center pb-5"><a
                    href="{{ route('section-preview', ['section_id' => $sched_section_object->section_id]) }}"
                    target="_blank"
                    class="text-lg mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-400 border border-transparent rounded-md active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                    Generate PDF
                </a></div>
        @endif
    </div>

    <hr><br><br>

    <!-- With avatar -->
    @include('includes.search', [
        'fields' => [
            'subject_name' => 'Subject name',
            'first_name' => 'Teacher first name',
            'middle_name' => 'Teacher middle name',
            'last_name' => 'Teacher last name',
            'section_name' => 'Section name',
            'room_name' => 'Room name',
            'time_start' => 'Start time',
            'time_end' => 'End time',
            'day' => 'Day',
        ],
    ])

    <div class="w-full my-5 overflow-hidden rounded-lg shadow-xs">
        @include('livewire.schedules.schedule-edit-modal')
        @include('livewire.schedules.schedule-delete-modal')
        <div class="w-full overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Record ID
                                @include('includes.order-by', ['field' => 'schedule_id'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Subject
                                @include('includes.order-by', ['field' => 'subjects.subject_name'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Teacher
                                @include('includes.order-by', ['field' => 'teachers.last_name'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Section
                                @include('includes.order-by', ['field' => 'sections.section_name'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Room
                                @include('includes.order-by', ['field' => 'rooms.room_name'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Start time
                                @include('includes.order-by', ['field' => 'time_start'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                End time
                                @include('includes.order-by', ['field' => 'time_end'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Day/s
                                @include('includes.order-by', ['field' => 'day'])
                            </span>
                        </th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @if ($schedules->count())
                        @foreach ($schedules as $schedule)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-2 text-sm">
                                    {{ $schedule->schedule_id }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $schedule->subject_name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $schedule->last_name . ', ' . $schedule->first_name . ' ' . $schedule->middle_name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $schedule->section_name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $schedule->room_name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->time_start)->format('h:i A') }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->time_end)->format('h:i A') }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $schedule->day }}
                                </td>
                                <td class="px-4 py-2 flex justify-around">
                                    <button wire:click.prevent="edit({{ $schedule->schedule_id }})"
                                        class="mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-yellow-400 border border-transparent rounded-md active:bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:shadow-outline-purple">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button wire:click.prevent="openDelete({{ $schedule->schedule_id }})"
                                        class="mt-4 mb-4 ml-1 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-400 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
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
                            <td colspan="9">
                                @include('includes.no-result')
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{ $schedules->links() }}
</div>
