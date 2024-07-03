<?php

namespace Database\Factories;

use App\Models\ClassModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassModelFactory extends Factory
{
    protected $model = ClassModel::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word . ' Class',
            'size' => $this->faker->numberBetween(20, 40),
        ];
    }
}