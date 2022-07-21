<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Schools;

class SchoolsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Schools::class;
    public function definition()
    {
        return [
            'name' =>$this->faker->name
        ];
    }
}
