<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhonebookTest extends TestCase
{
    /** @test */
    public function it_can_create_a_entry_in_phonebook(): void
    {
        $response = $this->postJson('/api/V1/phonebook', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'birthdate' => '1990-01-01',
            'CPF' => '82075251002',
            'phones' => ['123456789', '987654321']
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message'   => 'Phonebook created!',
                "status"    => 200,
                'data' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'birthdate' => '1990-01-01',
                    'CPF' => '82075251002',
                    'phones' => ['123456789', '987654321']
                ]
            ]);
    }
}
