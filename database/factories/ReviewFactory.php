<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        $reviewDate = fake()->dateTimeBetween(
            '-60 days',
            'now'
        );

        $rating = fake()->randomElement([
            4.0,
            5.0,
            6.0,
            7.0,
            8.0,
            9.0,
            10.0,
        ]);

        $positive = fake()->randomElement([
            'Great location and friendly staff.',
            'The room was comfortable and clean.',
            'Very convenient location.',
            'Reception staff were helpful and welcoming.',
            'Excellent value for the location.',
        ]);

        $negative = fake()->randomElement([
            null,
            null,
            'The room was a little noisy.',
            'The bathroom could have been cleaner.',
            'Check-in took longer than expected.',
            'The room was smaller than expected.',
            'Some facilities need improvement.',
        ]);

        $rawText = $positive . ' ' . ($negative ?? '');

        return [
            'property_id' => Property::inRandomOrder()->first()->id,

            'fingerprint' => hash(
                'sha256',
                Str::lower(
                    $reviewDate->format('Y-m-d')
                    . '|'
                    . $rating
                    . '|'
                    . $rawText
                )
            ),

            'external_id' => null,

            'rating' => $rating,

            'review_date' => $reviewDate,

            'positive_text' => $positive,

            'negative_text' => $negative,

            'reviewer_name' => fake()->firstName(),

            'reviewer_country' => fake()->country(),

            'room_type' => fake()->randomElement([
                'Standard Room',
                'Double Room',
                'Deluxe Room',
                'King Room',
            ]),

            'travel_type' => fake()->randomElement([
                'Couple',
                'Solo traveller',
                'Family',
                'Business traveller',
                'Group',
            ]),

            'source_url' => 'https://www.booking.com/',

            'scraped_at' => now(),
        ];
    }
}
