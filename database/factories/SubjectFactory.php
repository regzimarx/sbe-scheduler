<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Department;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $depts = Department::all();

        return [
            "subject_name" => $this->faker->sentence(6),
            "department_dept_id" => $this->faker->randomElement(
                $array = $depts
            ),
        ];
    }
}
