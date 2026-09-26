<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Property::create([
            'name' => 'Olympic Hotel Paddington',
            'booking_url' => 'https://www.booking.com/hotel/au/olympic-paddington.html',
        ]);

        Property::create([
            'name' => 'Potts Point',
            'booking_url' => 'https://www.booking.com/hotel/au/venus-potts-point-sydney.html',
        ]);

        Property::create([
            'name' => 'Central Sydney',
            'booking_url' => 'https://www.booking.com/hotel/au/venus-surry-hills.html',
        ]);

        Property::create([
            'name' => 'Darling Harbour',
            'booking_url' => 'https://www.booking.com/hotel/au/chateau-de-venus.html',
        ]);
    }
}
