<?php

namespace App\Actions\Fortify;

use App\Models\Department;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    private $department;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            "first_name" => ["required", "string", "max:255"],
            "middle_name" => ["required", "string", "max:255"],
            "last_name" => ["required", "string", "max:255"],
            "department_dept_id" => ["required"],
            "email" => [
                "required",
                "string",
                "email",
                "max:255",
                "unique:users",
            ],
            "password" => $this->passwordRules(),
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(
                User::create([
                    "first_name" => $input["first_name"],
                    "middle_name" => $input["middle_name"],
                    "last_name" => $input["last_name"],
                    "admin_type" => "admin",
                    "email" => $input["email"],
                    "department_dept_id" => $input["department_dept_id"],
                    "password" => Hash::make($input["password"]),
                ]),
                function (User $user) {
                    $this->createTeam($user);
                }
            );
        });
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(
            Team::forceCreate([
                "user_id" => $user->id,
                "name" => explode(" ", $user->first_name, 2)[0] . "'s Team",
                "personal_team" => true,
            ])
        );
    }
}
