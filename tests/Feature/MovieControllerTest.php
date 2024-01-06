<?php

namespace Tests\Feature;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the index method.
     */
    public function testIndex()
    {
        $user = \App\Models\User::factory()->create(); // Tworzenie użytkownika

        Movie::factory()->count(3)->create();
    
        $response = $this->actingAs($user)->getJson('/api/movies'); // Używanie actingAs
    
        $response->assertOk();
        $response->assertJsonCount(3);
    }

    /**
     * Test the store method.
     */
    public function testStore(): void
    {
        $user = \App\Models\User::factory()->create(); // Tworzenie użytkownika

        $movieData = [
            'title' => $this->faker->sentence,
            'director' => $this->faker->name,
            'genre' => $this->faker->word,
            'release_date' => $this->faker->date,
            'description' => $this->faker->text,
        ];

        $response = $this->actingAs($user)->postJson('/api/movies', $movieData);

        $response->assertCreated();
        $this->assertDatabaseHas('movies', ['title' => $movieData['title']]);
    }

    /**
     * Test the show method.
     */
    public function testShow(): void
    {
        $user = \App\Models\User::factory()->create(); // Tworzenie użytkownika

        $movie = Movie::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/movies/' . $movie->id);

        $response->assertOk();
        $response->assertJson(['id' => $movie->id]);
    }

    /**
     * Test the update method.
     */
    public function testUpdate(): void
    {
        $user = \App\Models\User::factory()->create(); // Tworzenie użytkownika

        $movie = Movie::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'director' => 'Updated Director',
            'genre' => 'Updated Genre',
            'release_date' => '2021-01-01',
            'description' => 'Updated Description',
        ];

        $response = $this->actingAs($user)->putJson('/api/movies/' . $movie->id, $updateData);

        $response->assertOk();
        $this->assertDatabaseHas('movies', ['id' => $movie->id, 'title' => 'Updated Title']);
    }

    /**
     * Test the destroy method.
     */
    public function testDestroy(): void
    {
        $user = \App\Models\User::factory()->create(); // Tworzenie użytkownika

        $movie = Movie::factory()->create();

        $response = $this->actingAs($user)->deleteJson('/api/movies/' . $movie->id);

        $response->assertOk();
        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }
}
