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

        @page {
            size: auto;
            /* auto is the initial value */
            margin: 0 20px;
            /* this affects the margin in the printer settings */
        }

    </style>
</head>

<body>
    <div class="flex flex-col justify-center items-center py-10">
        <div class="">
            <div class="flex flex-col justify-center items-center">
                <div class="flex justify-around w-full">
                    <div class="scc-logo">
                        <img aria-hidden="true" src="{{ asset('img/scc.png') }}" alt="SCC" width="100px" />
                    </div>
                    <div class="heading text-center">
                        <h1 class="uppercase">Southern Christian College</h1>
                        <h2 class="uppercase">United Church of Christ in the Philippines</h2>
                        <h2 class="uppercase">Midsayap, North Cotabato</h2>
                        <br>
                        <h2 class="font-bold">Class Program</h2>
                        <h2 class="font-bold">Grade {{ $section->grade_level }} -
                            {{ $section->section_name }}</h2>
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
                        <h2 class="font-bold mb-5">Academic Year {{ now()->year }} - {{ now()->year + 1 }}</h2>
                    </div>
                    <div class="uccp-logo">
                        <img aria-hidden="true" src="{{ asset('img/uccp.png') }}" alt="UCCP" width="100px" />
                    </div>
                </div>

                @if ($schedules)
                    <table class="table-auto w-full m-5 text-left border text-center p-1">
                        <thead class="border text-center p-1">
                            <tr class="border text-center p-1">
                                <th class="border text-center p-1">Time</th>
                                <th class="border text-center p-1">Monday</th>
                                <th class="border text-center p-1">Tuesday</th>
                                <th class="border text-center p-1">Wednesday</th>
                                <th class="border text-center p-1">Thursday</th>
                                <th class="border text-center p-1">Friday</th>
                            </tr>
                        </thead>
                        <tbody class="border text-center p-1">
                            @foreach ($time_starts as $time)
                                <tr class="border text-center p-1">
                                    <td class="border text-center p-1">
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->time_start)->format('h:i A') }}
                                        -
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->time_end)->format('h:i A') }}
                                    </td>
                                    <td class="border text-center p-1">
                                        @foreach ($schedules as $sched)
                                            @if (in_array('Monday', explode(', ', $sched->day)) && $time->time_start == $sched->time_start)
                                                <p class="font-semibold">{{ $sched->subject->subject_name }}
                                                </p>
                                                <p class="italic">
                                                    {{ $sched->teacher->getFullNameAttribute() }}
                                                </p>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="border text-center p-1">
                                        @foreach ($schedules as $sched)
                                            @if (in_array('Tuesday', explode(', ', $sched->day)) && $time->time_start == $sched->time_start)
                                                <p class="font-semibold">{{ $sched->subject->subject_name }}
                                                </p>
                                                <p class="italic">
                                                    {{ $sched->teacher->getFullNameAttribute() }}
                                                </p>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="border text-center p-1">
                                        @foreach ($schedules as $sched)
                                            @if (in_array('Wednesday', explode(', ', $sched->day)) && $time->time_start == $sched->time_start)
                                                <p class="font-semibold">{{ $sched->subject->subject_name }}
                                                </p>
                                                <p class="italic">
                                                    {{ $sched->teacher->getFullNameAttribute() }}
                                                </p>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="border text-center p-1">
                                        @foreach ($schedules as $sched)
                                            @if (in_array('Thursday', explode(', ', $sched->day)) && $time->time_start == $sched->time_start)
                                                <p class="font-semibold">{{ $sched->subject->subject_name }}
                                                </p>
                                                <p class="italic">
                                                    {{ $sched->teacher->getFullNameAttribute() }}
                                                </p>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="border text-center p-1">
                                        @foreach ($schedules as $sched)
                                            @if (in_array('Friday', explode(', ', $sched->day)) && $time->time_start == $sched->time_start)
                                                <p class="font-semibold">{{ $sched->subject->subject_name }}
                                                </p>
                                                <p class="italic">
                                                    {{ $sched->teacher->getFullNameAttribute() }}
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
