<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'full_name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'birth_date' => $this->faker->date(),
            'hometown' => $this->faker->city,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password'), 
            'avatar' => null,
            'note' => $this->faker->sentence,
            'class_id' => ClassModel::factory(),
        ];
    }
}