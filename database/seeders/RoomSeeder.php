<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'room_number' => '101',
                'room_type' => 'Standard Room',
                'price' => 1500,
                'capacity' => 2,
                'description' => 'A simple and comfortable room for two guests.',
                'status' => 'available',
            ],
            [
                'room_number' => '102',
                'room_type' => 'Deluxe Room',
                'price' => 2500,
                'capacity' => 3,
                'description' => 'A spacious room with better amenities.',
                'status' => 'available',
            ],
            [
                'room_number' => '201',
                'room_type' => 'Family Room',
                'price' => 3500,
                'capacity' => 5,
                'description' => 'A large room suitable for families.',
                'status' => 'available',
            ],
            [
                'room_number' => '202',
                'room_type' => 'Suite Room',
                'price' => 5000,
                'capacity' => 4,
                'description' => 'A premium room with a comfortable living area.',
                'status' => 'available',
            ],
            [
                'room_number' => '301',
                'room_type' => 'Single Room',
                'price' => 1000,
                'capacity' => 1,
                'description' => 'A budget-friendly room for one guest.',
                'status' => 'available',
            ],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(
                ['room_number' => $room['room_number']],
                $room
            );
        }
    }
}