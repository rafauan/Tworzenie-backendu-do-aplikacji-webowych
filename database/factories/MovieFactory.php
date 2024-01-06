<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence($nbWords = 3, $variableNbWords = true), // Tytuł filmu
            'director' => $this->faker->name(), // Imię i nazwisko reżysera
            'genre' => $this->faker->word(), // Gatunek filmu
            'release_date' => $this->faker->date(), // Data wydania
            'description' => $this->faker->text(), // Opis filmu
        ];
    }
}

