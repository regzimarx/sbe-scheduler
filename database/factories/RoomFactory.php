<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Department;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $depts = Department::all();

        return [
            "room_name" => $this->faker->sentence(2),
            "department_dept_id" => $this->faker->randomElement(
                $array = $depts
            ),
        ];
    }
}
