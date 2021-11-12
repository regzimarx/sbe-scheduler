@section('title', 'Schedules')

<div class="container grid px-6 py-6 mx-auto">

    @include('includes.messages')

    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Schedules
    </h2>

    <!-- With avatar -->
    @include('includes.search', ["fields" => [
    "subject_name" => "Subject name",
    "first_name" => "Teacher first name",
    "middle_name" => "Teacher middle name",
    "last_name" => "Teacher last name",
    "section_name" => "Section name",
    "room_name" => "Room name",
    "time_start" => "Start time",
    "time_end" => "End time",
    "day" => "Day"
    ]])

    <div class="w-full my-5 overflow-hidden rounded-lg shadow-xs">
        @include('livewire.schedules.schedule-edit-modal')
        @include('livewire.schedules.schedule-delete-modal')
        <div class="w-full overflow-x-auto">
            <table class="table-auto">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Record ID
                                @include('includes.order-by', ["field" => "schedule_id"])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Subject
                                @include('includes.order-by', ["field" => "subjects.subject_name"])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Teacher
                                @include('includes.order-by', ["field" => "teachers.last_name"])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Section
                                @include('includes.order-by', ["field" => "sections.section_name"])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Room
                                @include('includes.order-by', ["field" => "rooms.room_name"])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Start time
                                @include('includes.order-by', ["field" => "time_start"])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                End time
                                @include('includes.order-by', ["field" => "time_end"])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Day/s
                                @include('includes.order-by', ["field" => "day"])
                            </span>
                        </th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
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
                            <td class="px-4 py-2 flex justify-between">
                                <button wire:click.prevent="edit({{ $schedule->schedule_id }})"
                                    class="mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-yellow-400 border border-transparent rounded-md active:bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:shadow-outline-purple">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <button wire:click.prevent="openDelete({{ $schedule->schedule_id }})"
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
    {{ $schedules->links() }}
</div>
