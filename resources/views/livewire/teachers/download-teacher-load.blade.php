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
                <h1 class="font-bold text-3xl my-5">Schedules for {{ $teacher->first_name }}
                    {{ $teacher->middle_name }} {{ $teacher->last_name }}</h1>
                <table class="table-auto my-5 w-full">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Time/Day

                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Monday

                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Tuesday

                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Wednesday

                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Thursday

                                </span>
                            </th>
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Friday

                                </span>
                            </th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @if ($teacher->schedules->count())
                            @foreach ($teacher->schedules as $key => $schedule)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-2">
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->time_start)->format('h:i A') }}
                                        to
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->time_end)->format('h:i A') }}
                                    </td>
                                    <td class="px-4 py-2">
                                        @php
                                            $days_array = explode(', ', $schedule->day);
                                            if (in_array('Monday', $days_array)) {
                                                echo $schedule->subject->subject_name;
                                            }
                                        @endphp
                                    </td>
                                    <td class="px-4 py-2">
                                        @php
                                            if (in_array('Tuesday', $days_array)) {
                                                echo $schedule->subject->subject_name;
                                            }
                                        @endphp
                                    </td>
                                    <td class="px-4 py-2">
                                        @php
                                            if (in_array('Wednesday', $days_array)) {
                                                echo $schedule->subject->subject_name;
                                            }
                                        @endphp
                                    </td>
                                    <td class="px-4 py-2">
                                        @php
                                            if (in_array('Thursday', $days_array)) {
                                                echo $schedule->subject->subject_name;
                                            }
                                        @endphp
                                    </td>
                                    <td class="px-4 py-2">
                                        @php
                                            if (in_array('Friday', $days_array)) {
                                                echo $schedule->subject->subject_name;
                                            }
                                        @endphp
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

        <div class="flex justify-end">
            <button onclick="window.print()" id="printBtn"
                class="mt-4 mb-4 px-3 py-2 text-xl font-medium leading-5 text-white transition-colors duration-150 bg-blue-400 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                Generate PDF
            </button>
        </div>
    </div>
</body>

</html>
