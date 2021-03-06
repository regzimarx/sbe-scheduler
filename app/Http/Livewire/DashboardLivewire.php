<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\Subject;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Room;
use App\Models\Schedule;

class DashboardLivewire extends Component
{
    public $total_subjects, $total_students, $total_sections, $total_teachers, $total_rooms;

    public function mount()
    {
        if (Auth::user()->department_dept_id == null) {
            $this->total_subjects = Subject::all()->count();
            $this->total_students = Student::all()->count();
            $this->total_teachers = Teacher::all()->count();
            $this->total_sections = Section::all()->count();
            $this->total_rooms = Room::all()->count();
        } else {
            $this->total_subjects = Subject::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )->get()->count();

            $this->total_students = Student::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )->get()->count();

            $this->total_teachers = Teacher::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )->get()->count();

            $this->total_sections = Section::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )->get()->count();

            $this->total_rooms = Room::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )->get()->count();
        }
    }
    public function render()
    {
        return view("livewire.dashboard.dashboard");
    }
}
