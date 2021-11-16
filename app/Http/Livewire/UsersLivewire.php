<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Department;
use Livewire\WithPagination;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash;

class UsersLivewire extends Component
{
    use WithPagination;

    public $user_id,
        $first_name,
        $last_name,
        $middle_name,
        $email,
        $password,
        $department_dept_id,
        $searchBy,
        $department,
        $temp_password;
    public $openEdit,
        $openReset,
        $openDelete = false;
    public $search = "";
    public $orderBy = "id";
    public $orderByOrder = "asc";

    public function mount()
    {
        $this->searchBy = "all";
    }

    public function render()
    {
        if ($this->searchBy == "all") {
            $users = $this->search
                ? User::where("first_name", "like", "%" . $this->search . "%")
                    ->orWhere("middle_name", "like", "%" . $this->search . "%")
                    ->orWhere("last_name", "like", "%" . $this->search . "%")
                    ->orWhere("email", "like", "%" . $this->search . "%")
                    ->orderBy($this->orderBy, $this->orderByOrder)
                    ->paginate(10)
                : User::orderBy($this->orderBy, $this->orderByOrder)->paginate(
                    10
                );
        } else {
            $users = User::where(
                $this->searchBy,
                "like",
                "%" . $this->search . "%"
            )
                ->orderBy($this->orderBy, $this->orderByOrder)
                ->paginate(10);
        }

        return view("livewire.users.users", ["users" => $users]);
    }

    public function orderby($orderBy, $orderByOrder)
    {
        $this->orderBy = $orderBy;
        $this->orderByOrder = $orderByOrder;
    }

    //=================CREATE AND EDIT=================================

    public function store()
    {
        if ($this->user_id == null) {
            $this->validate([
                "first_name" => "required",
                "middle_name" => "required",
                "last_name" => "required",
                "email" => "required",
                "password" => "required",
                "department_dept_id" => "required",
            ]);
            User::create([
                "first_name" => $this->first_name,
                "middle_name" => $this->middle_name,
                "last_name" => $this->last_name,
                "email" => $this->email,
                "department_dept_id" => $this->department_dept_id,
                "password" => Hash::make($this->password),
                "admin_type" => "admin",
            ]);
        } else {
            $this->validate([
                "first_name" => "required",
                "middle_name" => "required",
                "last_name" => "required",
                "email" => "required",
                "department_dept_id" => "required",
            ]);
            User::where("id", $this->user_id)->update([
                "first_name" => $this->first_name,
                "middle_name" => $this->middle_name,
                "last_name" => $this->last_name,
                "email" => $this->email,
                "department_dept_id" => $this->department_dept_id,
                "admin_type" => "admin",
            ]);
        }

        session()->flash(
            "message",
            $this->user_id
                ? "User updated successfully."
                : "User created successfully."
        );

        $this->clear();

        $this->openEdit = false;
    }

    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);
        $this->user_id = $user->id;
        $this->first_name = $user->first_name;
        $this->middle_name = $user->middle_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->department_dept_id = $user->department_dept_id;
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

    public function openDelete($user_id)
    {
        $user = User::findOrFail($user_id);
        $this->user_id = $user->id;
        $this->openDeleteModal();
    }

    public function closeDeleteModal()
    {
        $this->clear();
        $this->openDelete = false;
    }

    public function delete()
    {
        User::findOrFail($this->user_id)->delete();
        session()->flash("warning", "User deleted successfully");
        $this->clear();
        $this->closeDeleteModal();
    }

    public function openResetPassword($user_id)
    {
        $this->user_id = $user_id;
        $this->openReset = true;
    }

    public function closeResetModal()
    {
        $this->openReset = false;
    }

    public function generateTempPassword()
    {
        $this->temp_password = Str::random(8);
    }

    public function saveTempPassword()
    {
        User::where("id", $this->user_id)->update([
            "password" => Hash::make($this->temp_password),
        ]);
        session()->flash("message", "Temporary password created successfully");
        $this->clear();
        $this->closeResetModal();
    }

    public function clear()
    {
        $this->user_id = null;
        $this->first_name = null;
        $this->middle_name = null;
        $this->last_name = null;
        $this->email = null;
        $this->department_dept_id = null;
    }
}
