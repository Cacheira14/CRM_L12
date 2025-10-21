<?php

namespace Database\Seeders;

use App\Models\Visit;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the commercial user (ID 2)
        $commercialUserId = 2;

        // Visit 1: TechCorp Solutions - Initial consultation
        Visit::create([
            'client_id' => 1, // TechCorp Solutions
            'user_id' => $commercialUserId,
            'scheduled_at' => Carbon::now()->addDays(7)->setTime(10, 0), // Next week at 10 AM
            'completed_at' => Carbon::now()->addDays(7)->setTime(11, 30), // Completed 1.5 hours later
        ]);

        // Visit 2: TechCorp Solutions - Follow-up meeting
        Visit::create([
            'client_id' => 1, // TechCorp Solutions
            'user_id' => $commercialUserId,
            'scheduled_at' => Carbon::now()->addDays(14)->setTime(14, 0), // Two weeks from now at 2 PM
            'completed_at' => null, // Not completed yet
        ]);

        // Visit 3: Global Marketing Agency - Project kickoff
        Visit::create([
            'client_id' => 2, // Global Marketing Agency
            'user_id' => $commercialUserId,
            'scheduled_at' => Carbon::now()->addDays(3)->setTime(9, 30), // In 3 days at 9:30 AM
            'completed_at' => Carbon::now()->addDays(3)->setTime(11, 0), // Completed 1.5 hours later
        ]);
    }
}
