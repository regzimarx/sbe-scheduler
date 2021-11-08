<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $number = 0;

    public function definition()
    {
        return [
            "first_name" => $this->faker->firstName(),
            "middle_name" => $this->faker->lastName(),
            "last_name" => $this->faker->lastName(),
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
            "gpa" => $this->faker->randomElement(
                $array = [
                    80,
                    81,
                    82,
                    83,
                    84,
                    85,
                    86,
                    87,
                    88,
                    89,
                    90,
                    91,
                    92,
                    93,
                    94,
                    95,
                ]
            ),
        ];
    }
}
