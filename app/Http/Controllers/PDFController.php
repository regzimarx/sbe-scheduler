<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Section;
use App\Models\Teacher;

use PDF;

class PDFController extends Controller
{
    public $section, $teacher;
    public $schedules, $time_starts;
    //

    public function index($id)
    {
        $this->section = Section::findOrFail($id);
        $this->schedules = Schedule::where("section_id", $id)
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

        $this->time_starts = $this->schedules->unique("time_start");

        return view("livewire.sections.download-schedule", [
            "schedules" => $this->schedules,
            "section" => $this->section,
            "time_starts" => $this->time_starts,
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
