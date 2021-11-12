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
    public $schedule_id, $searchBy;

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
        $day;
    public $subjects,
        $teachers,
        $students_classes = [];

    protected $perPage = 10;

    public function mount()
    {
        $this->searchBy = "all";

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

        $this->days = [
            "Everyday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday",
        ];
    }

    public function render()
    {
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
                ->join("rooms", "schedules.room_room_id", "=", "rooms.room_id")
                ->orderBy($this->orderBy, $this->orderByOrder)
                ->paginate(10);
        }

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
            "subject_id" => "required",
            "day" => "required",
            "room_id" => "required",
            "time_end" => "required",
            "teacher_id" => "required",
            "section_id" => "required",
            "time_start" => "required",
        ]);

        Schedule::updateOrCreate(
            ["schedule_id" => $this->schedule_id],
            [
                "subject_subject_id" => $this->subject_id,
                "time_end" => $this->time_end,
                "room_room_id" => $this->room_id,
                "time_start" => $this->time_start,
                "teacher_teacher_id" => $this->teacher_id,
                "section_section_id" => $this->section_id,
                "day" => collect($this->day)->implode(", "),
            ]
        );

        session()->flash(
            "message",
            $this->schedule_id
                ? "Schedule updated successfully."
                : "Schedule created successfully."
        );

        $this->clearData();
        $this->openEdit = false;
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
}
