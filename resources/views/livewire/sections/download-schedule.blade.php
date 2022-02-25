<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SBE Scheduler</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tailwind.output.css') }}" />
    <style>
        @media print {
            #printBtn {
                display: none;
            }
        }

    </style>
</head>

<body>
    <div class="flex flex-col justify-center items-center py-10">
        <div class="container">
            <div class="flex flex-col justify-center items-center">
                <h1 class="font-bold text-3xl">Schedules for Grade {{ $section->grade_level }} -
                    {{ $section->section_name }}</h1>
                <h2 class="font-bold text-2xl">
                    @php
                        $strand = $section->strand;
                    @endphp
                    @if ($strand == 'stem')
                        Science, Technology, Engineering, and Mathematics
                    @elseif ($strand == 'humss')
                        Humanities and Social Sciences
                    @elseif ($strand == 'abm')
                        Accountancy, Business and Management
                    @endif
                </h2>
                <h2 class="font-bold text-2xl mb-5">Academic Year {{ now()->year }} - {{ now()->year + 1 }}</h2>
                <table class="table-auto my-5 w-full">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    #
                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Subject

                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Teacher

                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Section

                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Room

                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Start time

                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    End time

                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Day/s

                                </span>
                            </th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @if ($schedules->count())
                            @foreach ($schedules as $key => $schedule)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-2 text-sm">
                                        {{ ++$key }}
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
                <h2 class="font-bold text-2xl my-3">List of students</h2>
            </div>
        </div>
        <div class="container">
            <div class="flex flex-col justify-start">
                @foreach ($section->students as $key => $student)
                    <p class="mb-1">{{ ++$key }}.
                        {{ $student->last_name . ', ' . $student->first_name . ' ' . $student->middle_name }}</p>
                @endforeach
            </div>
        </div>
        <div class="flex justify-end">
            <button onclick="window.print()" id="printBtn"
                class="mt-4 mb-4 px-3 py-2 text-xl font-medium leading-5 text-white transition-colors duration-150 bg-blue-400 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                Generate PDF
            </button>
        </div>
    </div>
</body>

</html>
