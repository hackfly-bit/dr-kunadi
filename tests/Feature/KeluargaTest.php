<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Keluarga;
use Tests\TestCase;

class KeluargaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_keluarga()
    {
        // Use factory to generate sample data
        $keluargaData = Keluarga::factory()->count(6)->create();

        $response = $this->getJson('/api/keluarga?page=1&per_page=10');

        // Assert response status and structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'nama', 'deskripsi']
                ],
                'total',
                'page',
                'limit',
            ]);
    }

    /** @test */
    public function it_can_create_keluarga()
    {
        // Sample data to send in the request
        $data = [
            'nama' => 'Test Keluarga',
            'deskripsi' => 'Test Deskripsi'
        ];

        // Make POST request to create keluarga
        $response = $this->postJson('/api/keluarga', $data);

        // Assert response status and response structure
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'nama' => 'Test Keluarga',
                    'deskripsi' => 'Test Deskripsi'
                ],
                'message' => 'Data saved successfully'
            ]);

        // Assert data is actually saved in the database
        $this->assertDatabaseHas('keluargas', $data);
    }

    /** @test */
    public function it_can_show_keluarga()
    {
        // Create a keluarga record using factory
        $keluarga = Keluarga::factory()->create();

        // Send GET request to show keluarga
        $response = $this->getJson("/api/keluarga/{$keluarga->id}");

        // Assert response status and data structure
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $keluarga->id,
                    'nama' => $keluarga->nama,
                    'deskripsi' => $keluarga->deskripsi
                ]
            ]);
    }

    /** @test */
    public function it_can_update_keluarga()
    {
        // Create a keluarga record using factory
        $keluarga = Keluarga::factory()->create();

        // Data to update
        $data = [
            'nama' => 'Updated Keluarga',
            'deskripsi' => 'Updated Deskripsi'
        ];

        // Send PUT request to update keluarga
        $response = $this->putJson("/api/keluarga/{$keluarga->id}", $data);

        // Assert response status and structure
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $keluarga->id,
                    'nama' => 'Updated Keluarga',
                    'deskripsi' => 'Updated Deskripsi'
                ],
                'message' => 'Data updated successfully'
            ]);

        // Assert database has updated record
        $this->assertDatabaseHas('keluargas', $data);
    }

    /** @test */
    public function it_can_delete_keluarga()
    {
        // Create a keluarga record using factory
        $keluarga = Keluarga::factory()->create();

        // Send DELETE request to delete keluarga
        $response = $this->deleteJson("/api/keluarga/{$keluarga->id}");

        // Assert response status and message
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Data deleted successfully'
            ]);

        // Assert the keluarga record is deleted from the database
        $this->assertDatabaseMissing('keluargas', ['id' => $keluarga->id]);
    }
}
