<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $properties = Property::pluck('id', 'name');

        $reviews = [
            [
                'property' => 'Olympic Hotel Paddington',
                'rating' => 9.0,
                'date' => '2026-09-22',
                'positive' => 'Fantastic location and very friendly staff. Check-in was easy.',
                'negative' => null,
                'country' => 'Australia',
                'room' => 'Double Room',
                'travel' => 'Couple',
            ],
            [
                'property' => 'Olympic Hotel Paddington',
                'rating' => 4.0,
                'date' => '2026-09-21',
                'positive' => 'The location was convenient.',
                'negative' => 'The room was dirty and there was a lot of noise at night.',
                'country' => 'Australia',
                'room' => 'Standard Room',
                'travel' => 'Solo traveller',
            ],
            [
                'property' => 'Olympic Hotel Paddington',
                'rating' => 7.0,
                'date' => '2026-09-18',
                'positive' => 'Staff were helpful and check-in was quick.',
                'negative' => 'The bathroom needed better cleaning.',
                'country' => 'United Kingdom',
                'room' => 'Double Room',
                'travel' => 'Business traveller',
            ],

            [
                'property' => 'Potts Point',
                'rating' => 9.0,
                'date' => '2026-09-23',
                'positive' => 'Excellent location close to restaurants and public transport. Very clean room.',
                'negative' => null,
                'country' => 'Australia',
                'room' => 'Deluxe Room',
                'travel' => 'Couple',
            ],
            [
                'property' => 'Potts Point',
                'rating' => 5.0,
                'date' => '2026-09-20',
                'positive' => 'The receptionist was polite.',
                'negative' => 'The room was small and the bed was uncomfortable.',
                'country' => 'New Zealand',
                'room' => 'Standard Room',
                'travel' => 'Solo traveller',
            ],
            [
                'property' => 'Potts Point',
                'rating' => 8.0,
                'date' => '2026-09-17',
                'positive' => 'Great value for money and convenient location.',
                'negative' => 'There was some traffic noise during the night.',
                'country' => 'Canada',
                'room' => 'Double Room',
                'travel' => 'Couple',
            ],

            [
                'property' => 'Central Sydney',
                'rating' => 10.0,
                'date' => '2026-09-24',
                'positive' => 'Amazing staff, clean room and excellent location.',
                'negative' => null,
                'country' => 'Australia',
                'room' => 'King Room',
                'travel' => 'Business traveller',
            ],
            [
                'property' => 'Central Sydney',
                'rating' => 6.0,
                'date' => '2026-09-19',
                'positive' => 'Good location.',
                'negative' => 'The bathroom was not clean and some facilities were old.',
                'country' => 'Singapore',
                'room' => 'Standard Room',
                'travel' => 'Family',
            ],
            [
                'property' => 'Central Sydney',
                'rating' => 8.0,
                'date' => '2026-09-16',
                'positive' => 'Easy check-in and helpful reception staff.',
                'negative' => 'The room was a little noisy.',
                'country' => 'United States',
                'room' => 'Double Room',
                'travel' => 'Couple',
            ],

            [
                'property' => 'Darling Harbour',
                'rating' => 9.0,
                'date' => '2026-09-25',
                'positive' => 'Fantastic location and comfortable room. Great facilities.',
                'negative' => null,
                'country' => 'Australia',
                'room' => 'Deluxe Room',
                'travel' => 'Family',
            ],
            [
                'property' => 'Darling Harbour',
                'rating' => 4.0,
                'date' => '2026-09-22',
                'positive' => 'The location was good.',
                'negative' => 'Very noisy at night and the room was not clean.',
                'country' => 'Ireland',
                'room' => 'Standard Room',
                'travel' => 'Couple',
            ],
            [
                'property' => 'Darling Harbour',
                'rating' => 7.0,
                'date' => '2026-09-15',
                'positive' => 'Friendly staff and reasonable value.',
                'negative' => 'The check-in process was slow.',
                'country' => 'Australia',
                'room' => 'Double Room',
                'travel' => 'Solo traveller',
            ],
        ];

        foreach ($reviews as $data) {
            $propertyId = $properties[$data['property']];

            $text = $data['positive'] . ' ' . ($data['negative'] ?? '');

            $fingerprint = hash(
                'sha256',
                $propertyId . '|' .
                $data['date'] . '|' .
                $data['rating'] . '|' .
                Str::lower(trim($text))
            );

            Review::updateOrCreate(
                [
                    'property_id' => $propertyId,
                    'fingerprint' => $fingerprint,
                ],
                [
                    'rating' => $data['rating'],
                    'review_date' => $data['date'],
                    'positive_text' => $data['positive'],
                    'negative_text' => $data['negative'],
                    'reviewer_country' => $data['country'],
                    'room_type' => $data['room'],
                    'travel_type' => $data['travel'],
                    'source_url' => 'sample-data',
                    'scraped_at' => now(),
                ]
            );
        }
    }
}
