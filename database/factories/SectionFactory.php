<?php

namespace Database\Factories;

use App\Models\Section;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Section::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $depts = Department::all();

        return [
            "section_name" => $this->faker->lastName(),
            "is_star" => false,
            "department_dept_id" => $this->faker->randomElement(
                $array = $depts
            ),
        ];
    }
}
