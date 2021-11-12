<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentsClass;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;

class SectionsLivewire extends Component
{
    use WithPagination;

    public $section,
        $section_id,
        $is_star,
        $section_name,
        $grade_level,
        $department_dept_id,
        $student,
        $searchBy;
    public $openEdit,
        $openDelete,
        $openMore,
        $removeStudent,
        $openMakestar = false;
    public $search = "";
    public $orderBy = "section_id";
    public $orderByOrder = "asc";
    public $star_section_classes = [];
    public $students_per_grade_level = [];
    public $grade_level_start, $grade_level_end;

    public function mount()
    {
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

        $this->searchBy = "all";
    }

    public function render()
    {
        if ($this->searchBy == "all") {
            $sections = $this->search
                ? Section::where(
                    "section_name",
                    "like",
                    "%" . $this->search . "%"
                )
                    ->where(
                        "department_dept_id",
                        Auth::user()->department_dept_id
                    )
                    ->orderBy($this->orderBy, $this->orderByOrder)
                    ->paginate(10)
                : Section::where(
                    "department_dept_id",
                    Auth::user()->department_dept_id
                )
                    ->orderBy($this->orderBy, $this->orderByOrder)
                    ->paginate(10);
        } else {
            $sections = Section::where(
                $this->searchBy,
                "like",
                "%" . $this->search . "%"
            )
                ->where("department_dept_id", Auth::user()->department_dept_id)
                ->orderBy($this->orderBy, $this->orderByOrder)
                ->paginate(10);
        }

        return view("livewire.sections.sections", ["sections" => $sections]);
    }

    public function orderby($orderBy, $orderByOrder)
    {
        $this->orderBy = $orderBy;
        $this->orderByOrder = $orderByOrder;
    }

    //=================CREATE AND EDIT=================================

    public function store()
    {
        //Validate input
        $this->validate([
            "section_name" => "required",
            "grade_level" => "required",
        ]);

        // Check if section_id is not empty
        // If empty, perform create, else perform update
        if ($this->section_id != null) {
            // Return if object with section_name exists
            $this->section = Section::where([
                "section_name" => $this->section_name,
            ])->firstOr(function () {
                // Update section if section_name does not exist
                Section::where(["section_id" => $this->section_id])->update([
                    "section_name" => $this->section_name,
                    "grade_level" => $this->grade_level,
                    "is_star" => $this->is_star,
                    "department_dept_id" => $this->department_dept_id,
                ]);
            })
                ? session()->flash(
                    "alert",
                    "Problem updating subject or subject already exists."
                )
                : session()->flash("message", "Section updated successfully.");
        } else {
            $this->section = Section::firstOrCreate(
                ["section_name" => $this->section_name],
                [
                    "section_name" => $this->section_name,
                    "is_star" => false,
                    "grade_level" => $this->grade_level,
                    "department_dept_id" => Auth::user()->department_dept_id,
                ]
            );

            $this->section->wasRecentlyCreated
                ? session()->flash("message", "Section created successfully.")
                : session()->flash("alert", "Section already exists.");
        }

        $this->clear();
        $this->openEdit = false;
    }

    public function edit($section_id)
    {
        $section = Section::findOrFail($section_id);
        $this->setData($section);
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

    public function openDelete($section_id)
    {
        $section = Section::findOrFail($section_id);
        $this->setData($section);
        $this->openDeleteModal();
    }

    public function closeDeleteModal()
    {
        $this->clear();
        $this->openDelete = false;
    }

    public function delete()
    {
        Section::findOrFail($this->section_id)->delete();
        session()->flash("warning", "Section deleted successfully");
        $this->clear();
        $this->closeDeleteModal();
    }

    //================================ MAKE STAR =========================

    public function makeStarModal($section_id, $dept_id)
    {
        $section = Section::where([
            "section_id" => $section_id,
            "department_dept_id" => $dept_id,
        ])->first();
        $this->setData($section);
        $this->openMakestar = true;
    }

    public function closeMakestarModal()
    {
        $this->openMakestar = false;
    }

    public function makeStar()
    {
        // Check if there's already a star section
        $old_star_section = Section::where("is_star", true)
            ->where("department_dept_id", $this->department_dept_id)
            ->first();

        if ($old_star_section) {
            // Check if class already exists for star section
            $this->star_section_classes = StudentsClass::where(
                "section_section_id",
                $old_star_section->section_id
            )->get();

            // Assign new star section

            $old_star_section->is_star = false;
            $old_star_section->save();
        }

        $new_star_section = Section::findOrFail($this->section_id);

        $new_star_section->is_star = true;
        $new_star_section->save();

        // Assign top 40 students to star section

        if ($this->star_section_classes) {
            foreach ($this->star_section_classes as $classes) {
                $classes->section_section_id = $new_star_section->section_id;
                $classes->save();
            }
        } else {
            $students = Student::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )
                ->where("grade_level", $new_star_section->grade_level)
                ->orderBy("gpa", "desc")
                ->limit(40)
                ->get();

            foreach ($students as $student) {
                $student_class = new StudentsClass();

                $student_class->student_student_id = $student->student_id;
                $student_class->section_section_id =
                    $new_star_section->section_id;
                $student_class->save();
            }
        }

        $this->clear();
        $this->closeMakestarModal();

        session()->flash(
            "message",
            "Star section updated. Top 40 students assigned to star section."
        );
    }

    // ======================= OPEN MORE ===================================

    public function openMoreModal($section_id)
    {
        $this->section = Section::findOrFail($section_id);
        $this->openMore = true;
    }

    public function closeMoreModal()
    {
        $this->section = null;
        $this->openMore = false;
    }

    // ================ Remove student from section ==================

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
            "Student removed from section successfully"
        );
        $this->clear();
        $this->closeRemoveStudentModal();
    }

    public function clear()
    {
        $this->section_id = null;
        $this->section_name = null;
        $this->is_star = false;
    }

    public function setData($section)
    {
        $this->section_id = $section->section_id;
        $this->section_name = $section->section_name;
        $this->grade_level = $section->grade_level;
        $this->department_dept_id = $section->department_dept_id;
        $this->is_star = $section->is_star;
    }
}
