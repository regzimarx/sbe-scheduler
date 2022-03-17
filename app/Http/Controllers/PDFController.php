<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Section;
use App\Models\Teacher;

use Illuminate\Support\Facades\Auth;

use PDF;

class PDFController extends Controller
{
    public $section, $teacher;
    public $schedules, $time_starts;
    //

    public function index($id, $acad_year, $semester)
    {
        $this->section = Section::findOrFail($id);
        if (Auth::user()->department_dept_id == 3) {
            $this->schedules = Schedule::where("section_id", $id)
                ->where("acad_year", $acad_year)
                ->where("semester", $semester)
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
                ->orderBy("time_start", "asc")
                ->get();
        } else {
            $this->schedules = Schedule::where("section_id", $id)
                ->where("acad_year", $acad_year)
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
                ->orderBy("time_start", "asc")
                ->get();
        }

        $this->time_starts = $this->schedules->unique("time_start");

        return view("livewire.sections.download-schedule", [
            "schedules" => $this->schedules,
            "section" => $this->section,
            "time_starts" => $this->time_starts,
            "acad_year" => $acad_year,
            "semester" => $semester,
        ]);
    }

    public function load_teacher_schedules($id)
    {
        $this->teacher = Teacher::findOrFail($id);
        return view("livewire.teachers.download-teacher-load", [
            "teacher" => $this->teacher,
        ]);
    }
}
