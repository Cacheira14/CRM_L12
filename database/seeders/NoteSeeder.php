<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Visit 1: TechCorp Solutions - Initial consultation (8 notes)
        $visit1Time = Carbon::now()->addDays(7)->setTime(10, 0);

        Note::create([
            'visit_id' => 1,
            'content' => 'Arrived at TechCorp Solutions headquarters. Met with CTO Sarah Johnson and Marketing Director Mike Chen. Company has 150 employees, focusing on SaaS solutions for small businesses.',
            'created_at' => $visit1Time->copy()->addMinutes(5),
        ]);

        Note::create([
            'visit_id' => 1,
            'content' => 'Discussed current marketing challenges: struggling with lead generation, inconsistent branding across platforms, and difficulty measuring ROI on digital campaigns.',
            'created_at' => $visit1Time->copy()->addMinutes(15),
        ]);

        Note::create([
            'visit_id' => 1,
            'content' => 'Sarah mentioned they\'ve tried Google Ads and LinkedIn campaigns but results have been mixed. Budget is $50K/month for marketing. They want to focus on B2B tech companies.',
            'created_at' => $visit1Time->copy()->addMinutes(25),
        ]);

        Note::create([
            'visit_id' => 1,
            'content' => 'Mike showed me their current website - looks outdated and not mobile-optimized. They have a blog but it\'s not updated regularly. Social media presence is minimal.',
            'created_at' => $visit1Time->copy()->addMinutes(35),
        ]);

        Note::create([
            'visit_id' => 1,
            'content' => 'Key pain points identified: 1) Lead quality issues, 2) Brand consistency, 3) Content strategy gaps, 4) Limited social media engagement. They\'re open to a comprehensive marketing overhaul.',
            'created_at' => $visit1Time->copy()->addMinutes(45),
        ]);

        Note::create([
            'visit_id' => 1,
            'content' => 'Proposed initial strategy: Content marketing focus, LinkedIn B2B campaigns, website redesign, and monthly reporting dashboard. They seemed very interested.',
            'created_at' => $visit1Time->copy()->addMinutes(55),
        ]);

        Note::create([
            'visit_id' => 1,
            'content' => 'Decision maker is Sarah Johnson (CTO) - she has final approval. Mike Chen will be the day-to-day contact. They want to start within 2 weeks.',
            'created_at' => $visit1Time->copy()->addMinutes(70),
        ]);

        Note::create([
            'visit_id' => 1,
            'content' => 'Meeting concluded positively. Follow-up scheduled for next week to present detailed proposal. Potential value: $75K annual contract. High priority client.',
            'created_at' => $visit1Time->copy()->addMinutes(85),
        ]);

        // Visit 2: TechCorp Solutions - Follow-up meeting (2 notes)
        $visit2Time = Carbon::now()->addDays(14)->setTime(14, 0);

        Note::create([
            'visit_id' => 2,
            'content' => 'Follow-up meeting with TechCorp Solutions. Sarah and Mike reviewed our proposal. They love the content strategy and website redesign sections.',
            'created_at' => $visit2Time->copy()->addMinutes(10),
        ]);

        Note::create([
            'visit_id' => 2,
            'content' => 'Negotiated pricing down from $75K to $68K annual. They want to add social media management to the package. Contract signing expected next week.',
            'created_at' => $visit2Time->copy()->addMinutes(45),
        ]);

        // Visit 3: Global Marketing Agency - Project kickoff (5 notes)
        $visit3Time = Carbon::now()->addDays(3)->setTime(9, 30);

        Note::create([
            'visit_id' => 3,
            'content' => 'Kickoff meeting with Global Marketing Agency. Team of 8 people present. They specialize in digital marketing for e-commerce brands. Currently managing 12 client accounts.',
            'created_at' => $visit3Time->copy()->addMinutes(8),
        ]);

        Note::create([
            'visit_id' => 3,
            'content' => 'Their main challenge: scaling their agency while maintaining quality. They need help with lead generation and client acquisition. Current monthly revenue: $45K.',
            'created_at' => $visit3Time->copy()->addMinutes(20),
        ]);

        Note::create([
            'visit_id' => 3,
            'content' => 'CEO mentioned they\'ve grown 300% in 2 years but now hitting bottlenecks with client onboarding and project management. They want to expand to enterprise clients.',
            'created_at' => $visit3Time->copy()->addMinutes(35),
        ]);

        Note::create([
            'visit_id' => 3,
            'content' => 'Discussed partnership opportunities: We could provide them with qualified B2B leads and help them develop enterprise marketing packages. They\'re interested in a revenue-share model.',
            'created_at' => $visit3Time->copy()->addMinutes(50),
        ]);

        Note::create([
            'visit_id' => 3,
            'content' => 'Meeting concluded with action items: Send partnership proposal by end of week, schedule demo of our lead generation tools next Tuesday. Strong potential for long-term relationship.',
            'created_at' => $visit3Time->copy()->addMinutes(75),
        ]);
    }
}
