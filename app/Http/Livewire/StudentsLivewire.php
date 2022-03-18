<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\Section;
use App\Models\StudentsClass;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudentsLivewire extends Component
{
    use WithPagination;

    public $studentMore,
        $student_id,
        $first_name,
        $middle_name,
        $last_name,
        $grade_level,
        $department_dept_id,
        $gpa,
        $section,
        $section_id;

    public $openEdit,
        $openDelete,
        $openMore,
        $removeStudent = false;

    public $search = "";
    public $orderBy = "student_id";
    public $orderByOrder = "asc";
    public $searchBy = "all";
    public $grade_level_start, $grade_level_end;
    public $sections_for_grade_level = [];

    public function render()
    {
        if (Auth::user()->department_dept_id != null) {
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
                        ->orWhere(
                            "middle_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere(
                            "last_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere("grade_level", intval($this->search))
                        ->orWhere("gpa", "like", "%" . $this->search . "%")
                        ->orderBy($this->orderBy, $this->orderByOrder)
                        ->paginate(20)
                    : Student::orderBy($this->orderBy, $this->orderByOrder)
                        ->where(
                            "department_dept_id",
                            Auth::user()->department_dept_id
                        )
                        ->paginate(10);
            } else {
                $students = Student::where(
                    $this->searchBy,
                    "like",
                    "%" . $this->search . "%"
                )
                    ->where(
                        "department_dept_id",
                        Auth::user()->department_dept_id
                    )
                    ->orderBy($this->orderBy, $this->orderByOrder)
                    ->paginate(10);
            }
        } else {
            if ($this->searchBy == "all") {
                $students = $this->search
                    ? Student::where(
                        "first_name",
                        "like",
                        "%" . $this->search . "%"
                    )
                        ->orWhere(
                            "middle_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere(
                            "last_name",
                            "like",
                            "%" . $this->search . "%"
                        )
                        ->orWhere("grade_level", intval($this->search))
                        ->orWhere("gpa", "like", "%" . $this->search . "%")
                        ->orderBy($this->orderBy, $this->orderByOrder)
                        ->paginate(20)
                    : Student::orderBy(
                        $this->orderBy,
                        $this->orderByOrder
                    )->paginate(10);
            } else {
                $students = Student::where(
                    $this->searchBy,
                    "like",
                    "%" . $this->search . "%"
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

        return view("livewire.students.students", ["students" => $students]);
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
            "first_name" => "required",
            "middle_name" => "required",
            "last_name" => "required",
            "grade_level" => "required",
        ]);

        if (Auth::user()->department_dept_id == 1) {
            $this->gpa = 0;
        }

        Student::updateOrCreate(
            ["student_id" => $this->student_id],
            [
                "first_name" => $this->first_name,
                "middle_name" => $this->middle_name,
                "last_name" => $this->last_name,
                "grade_level" => $this->grade_level,
                "gpa" => $this->gpa,
                "department_dept_id" => $this->setDepartment(),
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

    private function setDepartment()
    {
        if (Auth::user()->department_dept_id != null) {
            return Auth::user()->department_dept_id;
        } else {
            if (in_array($this->grade_level, [1, 2, 3, 4, 5, 6, 13, 14])) {
                return 1;
            } elseif (in_array($this->grade_level, [7, 8, 9, 10])) {
                return 2;
            } elseif (in_array($this->grade_level, [11, 12])) {
                return 3;
            }
        }
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
        $this->department_dept_id = $student->department_dept_id;
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

    // ============= OPEN MORE ============================

    public function openMoreModal($student_id)
    {
        $this->studentMore = Student::findOrFail($student_id);
        $this->sections_for_grade_level = Section::where(
            "grade_level",
            $this->studentMore->grade_level
        )->get();
        $this->openMore = true;
    }

    public function closeMoreModal()
    {
        $this->studentMore = null;
        $this->openMore = false;
    }

    public function addStudentToSection()
    {
        StudentsClass::create([
            "student_student_id" => $this->studentMore->student_id,
            "section_section_id" => $this->section_id,
        ]);
        session()->flash("message", "Student added to section successfully.");
    }

    public function removeStudentModal($student_id)
    {
        $this->student = Student::findOrFail($student_id);
        $this->removeStudent = true;
    }

    public function closeRemoveStudentModal()
    {
        $this->removeStudent = false;
    }

    public function removeStudent($student_id)
    {
        StudentsClass::where("student_student_id", $student_id)->delete();
        session()->flash(
            "warning",
            "Student removed from section successfully."
        );
        $this->clear();
        $this->closeRemoveStudentModal();
    }
}
