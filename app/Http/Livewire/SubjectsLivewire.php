<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subject;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;

class SubjectsLivewire extends Component
{
    use WithPagination;

    public $subject_id, $subject_name, $department;
    public $openEdit,
        $openDelete = false;
    public $search = "";
    public $orderBy = "subject_id";
    public $orderByOrder = "asc";

    public function render()
    {
        $subjects = $this->search
            ? Subject::where("subject_name", "like", "%" . $this->search . "%")
                ->where("department_dept_id", Auth::user()->department_dept_id)
                ->orderBy($this->orderBy, $this->orderByOrder)
                ->paginate(20)
            : Subject::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )
                ->orderBy($this->orderBy, $this->orderByOrder)
                ->paginate(20);

        return view("livewire.subjects.subjects", ["subjects" => $subjects]);
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
            "subject_name" => "required",
        ]);

        Subject::updateOrCreate(
            ["subject_id" => $this->subject_id],
            ["subject_name" => $this->subject_name]
        );

        session()->flash(
            "message",
            $this->subject_id
                ? "Subject updated successfully."
                : "Subject created successfully."
        );

        $this->clear();

        $this->openEdit = false;
    }

    public function edit($subject_id)
    {
        $subject = Subject::findOrFail($subject_id);
        $this->subject_id = $subject->subject_id;
        $this->subject_name = $subject->subject_name;
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

    public function openDelete($subject_id)
    {
        $subject = Subject::findOrFail($subject_id);
        $this->subject_id = $subject->subject_id;
        $this->subject_name = $subject->subject_name;
        $this->openDeleteModal();
    }

    public function closeDeleteModal()
    {
        $this->clear();
        $this->openDelete = false;
    }

    public function delete()
    {
        Subject::findOrFail($this->subject_id)->delete();
        session()->flash("warning", "Subject deleted successfully");
        $this->clear();
        $this->closeDeleteModal();
    }

    public function clear()
    {
        $this->subject_id = null;
        $this->subject_name = "";
    }
}
