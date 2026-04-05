<?php

namespace Database\Seeders;

use App\Models\Dormitory;
use App\Models\DormitoryRoom;
use App\Models\DormitoryBed;
use Illuminate\Database\Seeder;

class DormitorySeeder extends Seeder
{
    public function run()
    {
        // Male Dormitories
        $maleDoorms = [
            [
                'name' => 'Kilimanjaro Hostel',
                'gender' => 'male',
                'rooms_count' => 24,
                'beds_per_room' => 4,
                'warden_name' => 'Mr. James Kipchoge',
                'warden_phone' => '+254701123456',
                'description' => 'Premium male dormitory with modern facilities',
                'is_active' => true,
            ],
            [
                'name' => 'Mount Kenya Hostel',
                'gender' => 'male',
                'rooms_count' => 20,
                'beds_per_room' => 4,
                'warden_name' => 'Mr. David Mutua',
                'warden_phone' => '+254702234567',
                'description' => 'Standard male dormitory with good amenities',
                'is_active' => true,
            ],
        ];

        // Female Dormitories
        $femaleDoorms = [
            [
                'name' => 'Rift Valley Hostel',
                'gender' => 'female',
                'rooms_count' => 24,
                'beds_per_room' => 4,
                'warden_name' => 'Mrs. Grace Wanjiru',
                'warden_phone' => '+254703345678',
                'description' => 'Premium female dormitory with modern facilities',
                'is_active' => true,
            ],
            [
                'name' => 'Serengeti Hostel',
                'gender' => 'female',
                'rooms_count' => 20,
                'beds_per_room' => 4,
                'warden_name' => 'Mrs. Agnes Kariuki',
                'warden_phone' => '+254704456789',
                'description' => 'Standard female dormitory with good amenities',
                'is_active' => true,
            ],
        ];

        $allDorms = array_merge($maleDoorms, $femaleDoorms);

        foreach ($allDorms as $dormData) {
            $dormitory = Dormitory::create($dormData);

            // Create rooms for each dormitory
            for ($i = 1; $i <= $dormData['rooms_count']; $i++) {
                $room = DormitoryRoom::create([
                    'dormitory_id' => $dormitory->id,
                    'room_number' => $i,
                    'total_beds' => $dormData['beds_per_room'],
                    'occupied_beds' => 0,
                    'status' => 'available',
                ]);

                // Create beds for each room (alternating top and bottom)
                for ($j = 1; $j <= $dormData['beds_per_room']; $j++) {
                    $position = ($j % 2 === 0) ? 'bottom' : 'top';
                    DormitoryBed::create([
                        'dormitory_id' => $dormitory->id,
                        'dormitory_room_id' => $room->id,
                        'bed_number' => $j,
                        'position' => $position,
                        'status' => 'empty',
                    ]);
                }
            }
        }
    }
}
