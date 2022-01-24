<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Teacher;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;

class TeachersLivewire extends Component
{
    use WithPagination;

    public $teacher_id,
        $first_name,
        $middle_name,
        $last_name,
        $department_dept_id,
        $teacher,
        $teach;
    public $openEdit,
        $openDelete,
        $openMore = false;
    public $search = "";
    public $orderBy = "teacher_id";
    public $orderByOrder = "asc";
    public $searchBy = "all";

    public function render()
    {
        if (Auth::user()->department_dept_id != null) {
            if ($this->searchBy == "all") {
                $teachers = $this->search
                    ? Teacher::where(
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
                    ->where(
                        "department_dept_id",
                        Auth::user()->department_dept_id
                    )
                    ->orderBy($this->orderBy, $this->orderByOrder)
                    ->paginate(20);
            }
        } else {
            if ($this->searchBy == "all") {
                $teachers = $this->search
                    ? Teacher::where(
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
                        ->orderBy($this->orderBy, $this->orderByOrder)
                        ->paginate(20)
                    : Teacher::orderBy(
                        $this->orderBy,
                        $this->orderByOrder
                    )->paginate(20);
            } else {
                $teachers = Teacher::where(
                    $this->searchBy,
                    "like",
                    "%" . $this->search . "%"
                )
                    ->orderBy($this->orderBy, $this->orderByOrder)
                    ->paginate(20);
            }
        }

        return view("livewire.teachers.teachers", ["teachers" => $teachers]);
    }

    public function orderby($orderBy, $orderByOrder)
    {
        $this->orderBy = $orderBy;
        $this->orderByOrder = $orderByOrder;
    }

    //=================CREATE AND EDIT=================================

    public function store()
    {
        $dept =
            Auth::user()->department_dept_id == null
                ? $this->department_dept_id
                : Auth::user()->department_dept_id;

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
                "department_dept_id" => $dept,
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
        $this->department_dept_id = $teacher->department_dept_id;
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

    // OPEN MORE

    public function openMoreModal($teacher_id)
    {
        $this->teach = Teacher::findOrFail($teacher_id);
        $this->openMore = true;
    }

    public function closeMoreModal()
    {
        $this->teacher = null;
        $this->openMore = false;
    }
}
