<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudentsLivewire extends Component
{
    use WithPagination;

    public $student_id,
        $first_name,
        $middle_name,
        $last_name,
        $grade_level,
        $department_dept_id,
        $gpa;
    public $openEdit,
        $openDelete = false;
    public $search = "";
    public $orderBy = "student_id";
    public $orderByOrder = "asc";
    public $searchBy = "all";
    public $grade_level_start, $grade_level_end;

    public function render()
    {
        if ($this->searchBy == "all") {
            $students = $this->search
                ? Student::where(
                    "first_name",
                    "like",
                    "%" . $this->search . "%"
                )
                    ->where(
                        "department_dept_id",
                        Auth::user()->department_dept_id
                    )
                    ->orWhere("middle_name", "like", "%" . $this->search . "%")
                    ->orWhere("last_name", "like", "%" . $this->search . "%")
                    ->orWhere("grade_level", intval($this->search))
                    ->orWhere("gpa", "like", "%" . $this->search . "%")
                    ->orderBy($this->orderBy, $this->orderByOrder)
                    ->paginate(20)
                : Student::orderBy($this->orderBy, $this->orderByOrder)
                    ->where(
                        "department_dept_id",
                        Auth::user()->department_dept_id
                    )
                    ->paginate(20);
        } else {
            $students = Student::where(
                $this->searchBy,
                "like",
                "%" . $this->search . "%"
            )
                ->where("department_dept_id", Auth::user()->department_dept_id)
                ->orderBy($this->orderBy, $this->orderByOrder)
                ->paginate(20);
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

        return view("livewire.students.students", ["students" => $students]);
    }

    public function students_orderby($orderBy, $orderByOrder)
    {
        $this->orderBy = $orderBy;
        $this->orderByOrder = $orderByOrder;
    }

    //=================CREATE AND EDIT=================================

    public function store()
    {
        $this->validate([
            "first_name" => "required",
            "middle_name" => "required",
            "last_name" => "required",
            "grade_level" => "required",
            "gpa" => "required",
        ]);

        Student::updateOrCreate(
            ["student_id" => $this->student_id],
            [
                "first_name" => $this->first_name,
                "middle_name" => $this->middle_name,
                "last_name" => $this->last_name,
                "grade_level" => $this->grade_level,
                "gpa" => $this->gpa,
            ]
        );

        session()->flash(
            "message",
            $this->student_id
                ? "Student record updated successfully."
                : "Student record created successfully."
        );

        $this->clear();

        $this->openEdit = false;
    }

    public function edit($student_id)
    {
        $student = Student::findOrFail($student_id);
        $this->student_id = $student->student_id;
        $this->first_name = $student->first_name;
        $this->middle_name = $student->middle_name;
        $this->last_name = $student->last_name;
        $this->grade_level = $student->grade_level;
        $this->gpa = $student->gpa;
        $this->openEdit = true;
    }

    public function closeEditModal()
    {
        $this->clear();
        $this->openEdit = false;
    }

    //====================DELETE=================================

    public function openDeleteModal()
    {
        $this->openDelete = true;
    }

    public function openDelete($student_id)
    {
        $student = Student::findOrFail($student_id);
        $this->student_id = $student->student_id;
        $this->first_name = $student->first_name;
        $this->middle_name = $student->middle_name;
        $this->last_name = $student->last_name;
        $this->openDeleteModal();
    }

    public function closeDeleteModal()
    {
        $this->clear();
        $this->openDelete = false;
    }

    public function delete()
    {
        Student::findOrFail($this->student_id)->delete();
        session()->flash("warning", "Student record deleted successfully");
        $this->clear();
        $this->closeDeleteModal();
    }

    public function clear()
    {
        $this->student_id = null;
        $this->first_name = null;
        $this->middle_name = null;
        $this->last_name = null;
        $this->grade_level = null;
        $this->gpa = null;
    }
}
