<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Room;
use App\Models\User;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Section;
use App\Models\Department;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //==================== Don't delete========================

        // Insert departments

        $departments = ["elementary", "junior_high", "senior_high"];
        foreach ($departments as $dept) {
            DB::table("departments")->insert([
                "dept_name" => $dept,
            ]);
        }

        // Add superadmin

        DB::table("users")->insert([
            "first_name" => "SBE",
            "last_name" => "Admin",
            "middle_name" => "Super",
            "department_dept_id" => null,
            "admin_type" => "superadmin",
            "email" => "superadmin@gmail.com",
            "password" => Hash::make("superadmin123"),
        ]);

        // Add teams as required by Larawind but will not be used

        $super_admin = User::where("department_dept_id", null)
            ->where("admin_type", "superadmin")
            ->first();
        DB::table("teams")->insert([
            "user_id" => $super_admin->user_id,
            "name" => Str::random(10),
            "personal_team" => true,
        ]);

        //=========================================================

        //==================== Can be deleted =====================

        // Create admin for each department

        $depts = Department::all();

        foreach ($depts as $dept) {
            DB::table("users")->insert([
                "first_name" => Str::random(10),
                "admin_type" => "admin",
                "last_name" => Str::random(10),
                "middle_name" => Str::random(10),
                "department_dept_id" => $dept->dept_id,
                "email" => $dept->dept_name . "@gmail.com",
                "password" => Hash::make($dept->dept_name . "123"),
            ]);
        }

        // Get all admin types
        $elementary_admin = User::where("department_dept_id", 1)->first();
        $junior_high_admin = User::where("department_dept_id", 2)->first();
        $senior_high_admin = User::where("department_dept_id", 3)->first();

        // Add teams to avoid errors when creating users
        $teams = [
            $elementary_admin->user_id,
            $junior_high_admin->user_id,
            $senior_high_admin->user_id,
        ];

        foreach ($teams as $team) {
            DB::table("teams")->insert([
                "user_id" => $team,
                "name" => Str::random(10),
                "personal_team" => true,
            ]);
        }

        // Seed other DBs
        // Room::factory(50)->create();
        // Section::factory(50)->create();
        // Subject::factory(50)->create();
        // Teacher::factory(50)->create();
        // Student::factory(500)->create();
    }
}
