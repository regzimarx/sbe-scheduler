<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Room;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;

class SchedulesLivewire extends Component
{
    use WithPagination;

    public $search = "";
    public $orderByOrder = "asc";
    public $orderBy = "schedule_id";
    public $openEdit,
        $openDelete = false;
    public $schedule_id, $searchBy, $existing_schedule;

    // Vars for create/edit

    public $subject,
        $teacher,
        $section,
        $room,
        $subject_id,
        $teacher_id,
        $room_id,
        $section_id,
        $time_start,
        $time_end,
        $acad_year,
        $semester,
        $day,
        $conflict_counter;
    public $subjects,
        $teachers,
        $students_classes = [],
        $time_starts = [];

    public $sched_grade_level,
        $sched_section,
        $sched_sections,
        $sched_room,
        $sched_rooms,
        $sched_time_start,
        $sched_time_end,
        $sched_day;

    public $sched_section_object, $sched_room_object, $sched_schedules;

    protected $perPage = 10;

    public function mount()
    {
        $this->searchBy = "all";
        $this->acad_year = now()->year;

        if (Auth::user()->department_dept_id != null) {
            $this->subjects = Subject::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )->get();

            $this->teachers = Teacher::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )->get();

            $this->sections = Section::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )->get();

            $this->rooms = Room::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )->get();
        } else {
            $this->subjects = Subject::all();
            $this->teachers = Teacher::all();
            $this->sections = Section::all();
            $this->rooms = Room::all();
        }

        $this->days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
    }

    public function render()
    {
        if (Auth::user()->department_dept_id == null) {
            if ($this->searchBy == "all") {
                $schedules = $this->search
                    ? Schedule::where(
                        "subjects.subject_name",
                        "like",
                        "%" . $this->search . "%"
                    )
                        ->orWhere(
                            "sections.section_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere(
                            "teachers.first_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere(
                            "teachers.middle_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere(
                            "teachers.last_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere(
                            "rooms.room_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->join(
                            "subjects",
                            "schedules.subject_subject_id",
                            "=",
                            "subjects.subject_id"
                        )
                        ->join(
                            "sections",
                            "schedules.section_section_id",
                            "=",
                            "sections.section_id"
                        )
                        ->join(
                            "teachers",
                            "schedules.teacher_teacher_id",
                            "=",
                            "teachers.teacher_id"
                        )
                        ->join(
                            "rooms",
                            "schedules.room_room_id",
                            "=",
                            "rooms.room_id"
                        )
                        ->orderBy($this->orderBy, $this->orderByOrder)
                        ->paginate(10)
                    : Schedule::join(
                        "subjects",
                        "schedules.subject_subject_id",
                        "=",
                        "subjects.subject_id"
                    )
                        ->join(
                            "sections",
                            "schedules.section_section_id",
                            "=",
                            "sections.section_id"
                        )
                        ->join(
                            "teachers",
                            "schedules.teacher_teacher_id",
                            "=",
                            "teachers.teacher_id"
                        )
                        ->join(
                            "rooms",
                            "schedules.room_room_id",
                            "=",
                            "rooms.room_id"
                        )
                        ->orderBy($this->orderBy, $this->orderByOrder)
                        ->paginate(10);
            } else {
                $schedules = Schedule::where(
                    $this->searchBy,
                    "like",
                    "%" . $this->search . "%"
                )
                    ->join(
                        "subjects",
                        "schedules.subject_subject_id",
                        "=",
                        "subjects.subject_id"
                    )
                    ->join(
                        "sections",
                        "schedules.section_section_id",
                        "=",
                        "sections.section_id"
                    )
                    ->join(
                        "teachers",
                        "schedules.teacher_teacher_id",
                        "=",
                        "teachers.teacher_id"
                    )
                    ->join(
                        "rooms",
                        "schedules.room_room_id",
                        "=",
                        "rooms.room_id"
                    )
                    ->orderBy($this->orderBy, $this->orderByOrder)
                    ->paginate(10);
            }
        } else {
            if ($this->searchBy == "all") {
                $schedules = $this->search
                    ? Schedule::where(
                        "subjects.department_dept_id",
                        Auth::user()->department_dept_id
                    )
                        ->orWhere(
                            "subjects.subject_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere(
                            "sections.section_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere(
                            "teachers.first_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere(
                            "teachers.middle_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere(
                            "teachers.last_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere(
                            "rooms.room_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->join(
                            "subjects",
                            "schedules.subject_subject_id",
                            "=",
                            "subjects.subject_id"
                        )
                        ->join(
                            "sections",
                            "schedules.section_section_id",
                            "=",
                            "sections.section_id"
                        )
                        ->join(
                            "teachers",
                            "schedules.teacher_teacher_id",
                            "=",
                            "teachers.teacher_id"
                        )
                        ->join(
                            "rooms",
                            "schedules.room_room_id",
                            "=",
                            "rooms.room_id"
                        )
                        ->orderBy($this->orderBy, $this->orderByOrder)
                        ->paginate(10)
                    : Schedule::where(
                        "subjects.department_dept_id",
                        Auth::user()->department_dept_id
                    )
                        ->join(
                            "subjects",
                            "schedules.subject_subject_id",
                            "=",
                            "subjects.subject_id"
                        )
                        ->join(
                            "sections",
                            "schedules.section_section_id",
                            "=",
                            "sections.section_id"
                        )
                        ->join(
                            "teachers",
                            "schedules.teacher_teacher_id",
                            "=",
                            "teachers.teacher_id"
                        )
                        ->join(
                            "rooms",
                            "schedules.room_room_id",
                            "=",
                            "rooms.room_id"
                        )
                        ->orderBy($this->orderBy, $this->orderByOrder)
                        ->paginate(10);
            } else {
                $schedules = Schedule::where(
                    $this->searchBy,
                    "like",
                    "%" . $this->search . "%"
                )
                    ->where(
                        "subjects.department_dept_id",
                        Auth::user()->department_dept_id
                    )
                    ->join(
                        "subjects",
                        "schedules.subject_subject_id",
                        "=",
                        "subjects.subject_id"
                    )
                    ->join(
                        "sections",
                        "schedules.section_section_id",
                        "=",
                        "sections.section_id"
                    )
                    ->join(
                        "teachers",
                        "schedules.teacher_teacher_id",
                        "=",
                        "teachers.teacher_id"
                    )
                    ->join(
                        "rooms",
                        "schedules.room_room_id",
                        "=",
                        "rooms.room_id"
                    )
                    ->orderBy($this->orderBy, $this->orderByOrder)
                    ->paginate(10);
            }
        }

        // Set grade levels based on department

        $dept = Auth::user()->department_dept_id;

        if ($dept == 1) {
            $this->grade_level_start = 1;
            $this->grade_level_end = 6;
        } elseif ($dept == 2) {
            $this->grade_level_start = 7;
            $this->grade_level_end = 10;
        } elseif ($dept == 3) {
            $this->grade_level_start = 11;
            $this->grade_level_end = 12;
        } else {
            $this->grade_level_start = 1;
            $this->grade_level_end = 12;
        }

        if ($this->sched_grade_level) {
            $this->sched_sections = Section::where(
                "grade_level",
                $this->sched_grade_level
            )->get();
        }

        if ($this->sched_section) {
            $this->sched_rooms = Room::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )->get();
            $this->sched_section_object = Section::where(
                "section_id",
                $this->sched_section
            )->first();
        }

        if ($this->sched_room) {
            $this->sched_room_object = Room::where(
                "room_id",
                $this->sched_room
            )->first();
        }

        $this->sched_schedules = Schedule::where(
            "section_section_id",
            $this->sched_section
        )
            ->where("semester", $this->semester)
            ->where("acad_year", $this->acad_year)
            ->orderBy("time_start", "asc")
            ->get();

        $this->time_starts = $this->sched_schedules->unique("time_start");

        return view("livewire.schedules.schedules", [
            "schedules" => $schedules,
        ]);
    }

    public function orderby($orderBy, $orderByOrder)
    {
        $this->orderBy = $orderBy;
        $this->orderByOrder = $orderByOrder;
    }

    //=================CREATE AND EDIT=================================

    public function store()
    {
        $this->validate([
            "acad_year" => "required",
            "subject_id" => "required",
            "day" => "required",
            "room_id" => "required",
            "time_end" => "required",
            "teacher_id" => "required",
            "section_id" => "required",
            "time_start" => "required",
        ]);

        // Check if there are schedules overlapping the new schedule
        if (Auth::user()->department_dept_id == 3) {
            $this->existing_schedule = Schedule::whereBetween("time_start", [
                $this->time_start,
                $this->time_end,
            ])
                ->where("section_section_id", $this->sched_section)
                ->where("acad_year", $this->acad_year)
                ->where("semester", $this->semester)
                ->get();
        } else {
            $this->existing_schedule = Schedule::whereBetween("time_start", [
                $this->time_start,
                $this->time_end,
            ])
                ->where("section_section_id", $this->sched_section)
                ->where("acad_year", $this->acad_year)
                ->get();
        }

        $this->checkConflict($this->existing_schedule);

        // Assign varaibles
        $time_start_orig = $this->time_start;
        $time_start_separate = explode(":", $this->time_start);
        $time_start_hour = intval($time_start_separate[0]);
        $time_start_min = intval($time_start_separate[1]);
        $time_start_hour_convert = $time_start_hour * 60;
        $total_start_time_min = $time_start_hour_convert + $time_start_min;

        $time_end_separate = explode(":", $this->time_end);
        $time_end_hour = intval($time_end_separate[0]);
        $time_end_min = intval($time_end_separate[1]);
        $time_end_hour_convert = $time_end_hour * 60;
        $total_end_time_min = $time_end_hour_convert + $time_end_min;

        $time_diff = $total_end_time_min - $total_start_time_min;
        $sched_interval = Auth::user()->department_dept_id == 1 ? 50 : 60;

        if ($this->schedule_id) {
            Schedule::updateOrCreate(
                ["schedule_id" => $this->schedule_id],
                [
                    "acad_year" => $this->acad_year,
                    "semester" => $this->semester,
                    "subject_subject_id" => $this->subject_id,
                    "time_end" => $this->time_end,
                    "room_room_id" => $this->room_id,
                    "time_start" => $this->time_start,
                    "teacher_teacher_id" => $this->teacher_id,
                    "section_section_id" => $this->section_id,
                    "day" => collect($this->day)->implode(", "),
                ]
            );
            $this->schedule_id
                ? session()->flash("message", "Schedule updated successfully!")
                : session()->flash("message", "Schedule added successfully!");
        } else {
            if ($this->conflict_counter > 0) {
                session()->flash("warning", "Schedule has conflict!");
            } else {
                // Check if correct interval
                if ($time_diff == $sched_interval) {
                    Schedule::updateOrCreate(
                        ["schedule_id" => $this->schedule_id],
                        [
                            "acad_year" => $this->acad_year,
                            "semester" => $this->semester,
                            "subject_subject_id" => $this->subject_id,
                            "time_end" => $this->time_end,
                            "room_room_id" => $this->room_id,
                            "time_start" => $this->time_start,
                            "teacher_teacher_id" => $this->teacher_id,
                            "section_section_id" => $this->section_id,
                            "day" => collect($this->day)->implode(", "),
                        ]
                    );
                    $this->schedule_id
                        ? session()->flash(
                            "message",
                            "Schedule updated successfully!"
                        )
                        : session()->flash(
                            "message",
                            "Schedule added successfully!"
                        );
                } else {
                    session()->flash(
                        "warning",
                        "Schedule should be " .
                            $sched_interval .
                            " minutes long."
                    );
                }
            }
        }

        $this->clearData();
        $this->openEdit = false;
    }

    public function sched_store()
    {
        $this->validate([
            "acad_year" => "required",
            "subject_id" => "required",
            "day" => "required",
            "sched_room" => "required",
            "sched_time_end" => "required",
            "teacher_id" => "required",
            "sched_section" => "required",
            "sched_time_start" => "required",
        ]);

        // Check if there are schedules overlapping the new schedule

        if (Auth::user()->department_dept_id == 3) {
            $this->existing_schedule = Schedule::whereBetween("time_start", [
                $this->sched_time_start,
                $this->sched_time_end,
            ])
                ->where("section_section_id", $this->sched_section)
                ->where("acad_year", $this->acad_year)
                ->where("semester", $this->semester)
                ->get();
        } else {
            $this->existing_schedule = Schedule::whereBetween("time_start", [
                $this->sched_time_start,
                $this->sched_time_end,
            ])
                ->where("section_section_id", $this->sched_section)
                ->where("acad_year", $this->acad_year)
                ->get();
        }

        $this->checkConflict($this->existing_schedule);

        // Assign varaibles
        $time_start_orig = $this->sched_time_start;
        $time_start_separate = explode(":", $this->sched_time_start);
        $time_start_hour = intval($time_start_separate[0]);
        $time_start_min = intval($time_start_separate[1]);
        $time_start_hour_convert = $time_start_hour * 60;
        $total_start_time_min = $time_start_hour_convert + $time_start_min;

        $time_end_separate = explode(":", $this->sched_time_end);
        $time_end_hour = intval($time_end_separate[0]);
        $time_end_min = intval($time_end_separate[1]);
        $time_end_hour_convert = $time_end_hour * 60;
        $total_end_time_min = $time_end_hour_convert + $time_end_min;

        $time_diff = $total_end_time_min - $total_start_time_min;
        $sched_interval = Auth::user()->department_dept_id == 1 ? 50 : 60;

        if ($this->schedule_id) {
            Schedule::updateOrCreate(
                ["schedule_id" => $this->schedule_id],
                [
                    "acad_year" => $this->acad_year,
                    "semester" => $this->semester,
                    "subject_subject_id" => $this->subject_id,
                    "time_end" => $this->sched_time_end,
                    "room_room_id" => $this->sched_room,
                    "time_start" => $this->sched_time_start,
                    "teacher_teacher_id" => $this->teacher_id,
                    "section_section_id" => $this->sched_section,
                    "day" => collect($this->day)->implode(", "),
                ]
            );
            $this->schedule_id
                ? session()->flash("message", "Schedule updated successfully!")
                : session()->flash("message", "Schedule added successfully!");
        } else {
            if ($this->conflict_counter > 0) {
                session()->flash("warning", "Schedule has conflict!");
            } else {
                // Check if correct interval
                if ($time_diff == $sched_interval) {
                    Schedule::updateOrCreate(
                        ["schedule_id" => $this->schedule_id],
                        [
                            "acad_year" => $this->acad_year,
                            "semester" => $this->semester,
                            "subject_subject_id" => $this->subject_id,
                            "time_end" => $this->sched_time_end,
                            "room_room_id" => $this->sched_room,
                            "time_start" => $this->sched_time_start,
                            "teacher_teacher_id" => $this->teacher_id,
                            "section_section_id" => $this->sched_section,
                            "day" => collect($this->day)->implode(", "),
                        ]
                    );
                    $this->schedule_id
                        ? session()->flash(
                            "message",
                            "Schedule updated successfully!"
                        )
                        : session()->flash(
                            "message",
                            "Schedule added successfully!"
                        );
                } else {
                    session()->flash(
                        "warning",
                        "Schedule should be " .
                            $sched_interval .
                            " minutes long."
                    );
                }
            }
        }
    }

    public function checkConflict($schedules)
    {
        $this->conflict_counter = 0;
        foreach ($schedules as $sched) {
            if (
                array_intersect(
                    array_map("trim", explode(",", $sched->day)),
                    $this->day
                )
            ) {
                $this->conflict_counter++;
            }
        }
    }

    public function edit($schedule_id)
    {
        $schedule = Schedule::findOrFail($schedule_id);
        $this->setData($schedule);

        $this->openEdit = true;
    }

    public function closeEditModal()
    {
        $this->openEdit = false;
    }

    //====================DELETE=================================

    public function openDeleteModal()
    {
        $this->openDelete = true;
    }

    public function openDelete($schedule_id)
    {
        $schedule = Schedule::findOrFail($schedule_id);
        $this->setData($schedule);

        $this->openDeleteModal();
    }

    public function closeDeleteModal()
    {
        $this->openDelete = false;
    }

    public function delete()
    {
        Schedule::findOrFail($this->schedule_id)->delete();
        $this->clearData();

        $this->closeDeleteModal();
    }

    public function setData($schedule)
    {
        $this->day = $schedule->day;
        $this->time_end = $schedule->time_end;
        $this->room_id = $schedule->room_room_id;
        $this->time_start = $schedule->time_start;
        $this->schedule_id = $schedule->schedule_id;
        $this->section_id = $schedule->section_section_id;
        $this->teacher_id = $schedule->teacher_teacher_id;
        $this->subject_id = $schedule->subject_subject_id;
    }

    public function clearData()
    {
        $this->day = null;
        $this->room_id = null;
        $this->time_end = null;
        $this->section_id = null;
        $this->teacher_id = null;
        $this->subject_id = null;
        $this->time_start = null;
        $this->schedule_id = null;
        $this->schedule_id = null;
    }

    //================== PRINT ==============================

    public function downloadSchedule()
    {
    }
}
