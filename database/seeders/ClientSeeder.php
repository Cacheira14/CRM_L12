<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'name' => 'TechCorp Solutions',
            'email' => 'contact@techcorp.com',
            'phone' => '+1-555-0123',
            'address' => '123 Innovation Drive',
            'city' => 'Silicon Valley',
            'country' => 'USA',
        ]);

        Client::create([
            'name' => 'Global Marketing Agency',
            'email' => 'hello@globalmarketing.com',
            'phone' => '+1-555-0456',
            'address' => '456 Business Avenue',
            'city' => 'New York',
            'country' => 'USA',
        ]);
    }
}
