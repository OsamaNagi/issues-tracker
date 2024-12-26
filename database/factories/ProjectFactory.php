<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'user_id' => User::first()->id,
            'status' => $this->faker->randomElement(['open', 'closed']),
            'visibility' => $this->faker->randomElement(['public', 'private']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
