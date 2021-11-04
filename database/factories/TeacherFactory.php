<?php

namespace Database\Factories;

use App\Models\Teacher;
use App\Models\Department;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $depts = Department::all();

        return [
            "first_name" => $this->faker->firstName(),
            "middle_name" => $this->faker->lastName(),
            "last_name" => $this->faker->lastName(),
            "department_dept_id" => $this->faker->randomElement(
                $array = $depts
            ),
        ];
    }
}
