<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Teacher;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;

class TeachersLivewire extends Component
{
    use WithPagination;

    public $teacher_id, $first_name, $middle_name, $last_name;
    public $openEdit,
        $openDelete = false;
    public $search = "";
    public $orderBy = "teacher_id";
    public $orderByOrder = "asc";
    public $searchBy = "all";

    public function render()
    {
        if ($this->searchBy == "all") {
            $teachers = $this->search
                ? Teacher::where(
                    "first_name",
                    "like",
                    "%" . $this->search . "%"
                )
                    ->orWhere("middle_name", "like", "%" . $this->search . "%")
                    ->orWhere("last_name", "like", "%" . $this->search . "%")
                    ->where(
                        "department_dept_id",
                        Auth::user()->department_dept_id
                    )
                    ->orderBy($this->orderBy, $this->orderByOrder)
                    ->paginate(20)
                : Teacher::where(
                    "department_dept_id",
                    Auth::user()->department_dept_id
                )
                    ->orderBy($this->orderBy, $this->orderByOrder)
                    ->paginate(20);
        } else {
            $teachers = Teacher::where(
                $this->searchBy,
                "like",
                "%" . $this->search . "%"
            )
                ->where("department_dept_id", Auth::user()->department_dept_id)
                ->orderBy($this->orderBy, $this->orderByOrder)
                ->paginate(20);
        }

        return view("livewire.teachers.teachers", ["teachers" => $teachers]);
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
        ]);

        Teacher::updateOrCreate(
            ["teacher_id" => $this->teacher_id],
            [
                "first_name" => $this->first_name,
                "middle_name" => $this->middle_name,
                "last_name" => $this->last_name,
            ]
        );

        session()->flash(
            "message",
            $this->teacher_id
                ? "Teacher record updated successfully."
                : "Teacher record created successfully."
        );

        $this->clear();

        $this->openEdit = false;
    }

    public function edit($teacher_id)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        $this->teacher_id = $teacher->teacher_id;
        $this->first_name = $teacher->first_name;
        $this->middle_name = $teacher->middle_name;
        $this->last_name = $teacher->last_name;
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

    public function openDelete($teacher_id)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        $this->teacher_id = $teacher->teacher_id;
        $this->first_name = $teacher->first_name;
        $this->middle_name = $teacher->middle_name;
        $this->last_name = $teacher->last_name;
        $this->openDeleteModal();
    }

    public function closeDeleteModal()
    {
        $this->clear();
        $this->openDelete = false;
    }

    public function delete()
    {
        Teacher::findOrFail($this->teacher_id)->delete();
        session()->flash("warning", "Teacher record deleted successfully");
        $this->clear();
        $this->closeDeleteModal();
    }

    public function clear()
    {
        $this->teacher_id = null;
        $this->first_name = null;
        $this->middle_name = null;
        $this->last_name = null;
    }
}
