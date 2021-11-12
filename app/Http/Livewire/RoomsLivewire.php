<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Room;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;

class RoomsLivewire extends Component
{
    use WithPagination;

    public $room_id, $room_name, $department, $searchBy;
    public $openEdit,
        $openDelete = false;
    public $search = "";
    public $orderBy = "room_id";
    public $orderByOrder = "asc";

    public function mount()
    {
        $this->searchBy = "all";
    }

    public function render()
    {
        $rooms = $this->search
            ? Room::where("room_name", "like", "%" . $this->search . "%")
                ->where("department_dept_id", Auth::user()->department_dept_id)
                ->orderBy($this->orderBy, $this->orderByOrder)
                ->paginate(10)
            : Room::where(
                "department_dept_id",
                Auth::user()->department_dept_id
            )
                ->orderBy($this->orderBy, $this->orderByOrder)
                ->paginate(10);

        return view("livewire.rooms.rooms", ["rooms" => $rooms]);
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
            "room_name" => "required",
        ]);

        Room::updateOrCreate(
            ["room_id" => $this->room_id],
            [
                "room_name" => $this->room_name,
                "department_dept_id" => Auth::user()->department_dept_id,
            ]
        );

        session()->flash(
            "message",
            $this->room_id
                ? "Room updated successfully."
                : "Room created successfully."
        );

        $this->clear();

        $this->openEdit = false;
    }

    public function edit($room_id)
    {
        $room = Room::findOrFail($room_id);
        $this->room_id = $room->room_id;
        $this->room_name = $room->room_name;
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

    public function openDelete($room_id)
    {
        $room = Room::findOrFail($room_id);
        $this->room_id = $room->room_id;
        $this->room_name = $room->room_name;
        $this->openDeleteModal();
    }

    public function closeDeleteModal()
    {
        $this->clear();
        $this->openDelete = false;
    }

    public function delete()
    {
        Room::findOrFail($this->room_id)->delete();
        session()->flash("warning", "Room deleted successfully");
        $this->clear();
        $this->closeDeleteModal();
    }

    public function clear()
    {
        $this->room_id = null;
        $this->room_name = "";
    }
}
