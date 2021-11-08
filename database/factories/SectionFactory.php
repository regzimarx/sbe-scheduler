<?php

namespace Database\Factories;

use App\Models\Section;
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

    protected $number = 0;

    public function definition()
    {
        return [
            "section_name" => $this->faker->lastName(),
            "is_star" => false,
            "grade_level" => function () {
                if ($this->number == 12) {
                    $this->number = 0;
                }
                return ++$this->number;
            },
            "department_dept_id" => function () {
                if (in_array($this->number, [1, 2, 3, 4, 5, 6])) {
                    return 1;
                }
                if (in_array($this->number, [7, 8, 9, 10])) {
                    return 2;
                }
                if (in_array($this->number, [11, 12])) {
                    return 3;
                }
            },
        ];
    }
}
