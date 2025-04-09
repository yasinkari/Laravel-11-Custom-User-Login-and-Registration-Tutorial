<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tone;

class ToneSeeder extends Seeder
{
    public function run(): void
    {
        $tones = [
            [
                'tone_name' => 'Fair',
                'tone_code' => '#F8D5C2'
            ],
            [
                'tone_name' => 'Olive',
                'tone_code' => '#C5A98B'
            ],
            [
                'tone_name' => 'Light Brown',
                'tone_code' => '#BB8E6C'
            ],
            [
                'tone_name' => 'Brown',
                'tone_code' => '#8D5524'
            ],
            [
                'tone_name' => 'Black Brown',
                'tone_code' => '#4A2C1A'
            ]
        ];

        foreach ($tones as $tone) {
            Tone::create($tone);
        }
    }
}