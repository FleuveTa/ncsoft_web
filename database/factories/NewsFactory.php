<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'heading_vn' => 'NCSoft THAM DỰ INDIA TELECOM 2023 VÀ NATHEALTH'.Str::random(10),
            'heading_en' => 'OMIGROUP PARTICIPATES INDIA TELECOM 2023 AND NATHE' .Str::random(10),
            'slug' => 'news'.str::random(4),
            'title_vn' => 'Từ ngày 22-23/03, đại diện OmiGroup, ông Phan Mạnh'.str::random(6),
            'title_en' => 'From March 22 to 23, the representative of OmiGrou..'.str::random(6),
            'image' => 'banner2.jpg',
            'user_id' => '70',
            'time_display' => '2023-04-12'
        ];
    }
}
