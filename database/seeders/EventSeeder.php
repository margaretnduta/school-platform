<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run()
    {
        $events = [
            [
                'title' => 'Opening Ceremony 2026',
                'description' => 'Grand opening ceremony of the academic year 2026. Join us for prayers, speeches, and celebrations.',
                'detailed_description' => 'Attend the official opening ceremony featuring speeches from school leadership, student performances, and a welcome address for the new academic year. Refreshments will be served.',
                'event_date' => Carbon::now()->addDays(5)->setTime(9, 0),
                'location' => 'School Assembly Ground',
                'organizer' => 'Principal\'s Office',
                'status' => 'upcoming',
                'max_participants' => 1000,
                'registered_participants' => 0,
                'category' => 'Ceremony',
                'is_public' => true,
            ],
            [
                'title' => 'Inter-House Sports Day',
                'description' => 'Annual inter-house athletics competition featuring track events, field events, and team games.',
                'detailed_description' => 'Students compete in various athletic disciplines including 100m, 400m, 1500m, relay races, high jump, long jump, shot put, and team sports. Top performers will be awarded.',
                'event_date' => Carbon::now()->addDays(15)->setTime(8, 0),
                'location' => 'School Sports Field',
                'organizer' => 'Sports Department',
                'status' => 'upcoming',
                'max_participants' => 500,
                'registered_participants' => 120,
                'category' => 'Sports',
                'is_public' => true,
            ],
            [
                'title' => 'Science Fair 2026',
                'description' => 'Showcase student science projects and innovations in Biology, Chemistry, Physics, and Technology.',
                'detailed_description' => 'Students present innovative science projects covering various STEM fields. Judges from industry will evaluate projects based on creativity, scientific integrity, and presentation.',
                'event_date' => Carbon::now()->addDays(22)->setTime(10, 0),
                'location' => 'School Science Block',
                'organizer' => 'Science Department',
                'status' => 'upcoming',
                'max_participants' => 300,
                'registered_participants' => 85,
                'category' => 'Academic',
                'is_public' => true,
            ],
            [
                'title' => 'Cultural Day',
                'description' => 'Celebration of diverse cultures within the school community through performances, food, and displays.',
                'detailed_description' => 'Experience cultural diversity with traditional dances, music performances, cultural attire displays, and ethnic cuisine from different communities. A celebration of our multicultural school.',
                'event_date' => Carbon::now()->addDays(30)->setTime(11, 0),
                'location' => 'School Grounds',
                'organizer' => 'Student Council',
                'status' => 'upcoming',
                'max_participants' => 800,
                'registered_participants' => 200,
                'category' => 'Cultural',
                'is_public' => true,
            ],
            [
                'title' => 'Parent-Teacher Conference',
                'description' => 'Meet with teachers to discuss student academic progress and development.',
                'detailed_description' => 'Parents/guardians schedule individual meetings with form teachers and subject teachers to review student performance, discuss challenges, and plan for improvement.',
                'event_date' => Carbon::now()->addDays(35)->setTime(14, 0),
                'location' => 'School Classrooms',
                'organizer' => 'Academic Department',
                'status' => 'upcoming',
                'max_participants' => 500,
                'registered_participants' => 0,
                'category' => 'Academic',
                'is_public' => false,
            ],
            [
                'title' => 'Debate Competition',
                'description' => 'Inter-school debate championship on national and international affairs.',
                'detailed_description' => 'Debate teams compete on topics ranging from environmental issues to technology and society. Both impromptu and prepared topics will be featured.',
                'event_date' => Carbon::now()->addDays(40)->setTime(9, 0),
                'location' => 'Main Auditorium',
                'organizer' => 'Debate Club',
                'status' => 'upcoming',
                'max_participants' => 200,
                'registered_participants' => 45,
                'category' => 'Academic',
                'is_public' => true,
            ],
            [
                'title' => 'End of Term Celebration',
                'description' => 'Prize-giving ceremony and celebration of student achievements.',
                'detailed_description' => 'Recognize and celebrate student achievements in academics, sports, and co-curricular activities. Top performers will receive prizes and certificates.',
                'event_date' => Carbon::now()->addDays(55)->setTime(15, 0),
                'location' => 'School Grounds',
                'organizer' => 'Principal\'s Office',
                'status' => 'upcoming',
                'max_participants' => 1000,
                'registered_participants' => 0,
                'category' => 'Ceremony',
                'is_public' => true,
            ],
            [
                'title' => 'Career Guidance Forum',
                'description' => 'Meet professionals from various fields to learn about career opportunities.',
                'detailed_description' => 'Industry professionals from engineering, medicine, law, business, and technology sectors share insights about their careers and answer student questions.',
                'event_date' => Carbon::now()->addDays(20)->setTime(13, 0),
                'location' => 'Main Hall',
                'organizer' => 'Career Department',
                'status' => 'upcoming',
                'max_participants' => 300,
                'registered_participants' => 150,
                'category' => 'Academic',
                'is_public' => true,
            ],
            [
                'title' => 'Music Concert',
                'description' => 'Student performances showcasing musical talents and rehearsed pieces.',
                'detailed_description' => 'Enjoy an evening of music featuring solo and group performances by students. Genres will include classical, contemporary, and traditional music.',
                'event_date' => Carbon::now()->addDays(45)->setTime(18, 0),
                'location' => 'School Auditorium',
                'organizer' => 'Music Club',
                'status' => 'upcoming',
                'max_participants' => 400,
                'registered_participants' => 100,
                'category' => 'Cultural',
                'is_public' => true,
            ],
            [
                'title' => 'Mathematics Olympiad',
                'description' => 'Challenging mathematics competition for gifted students.',
                'detailed_description' => 'Students solve complex mathematical problems and puzzles. Top scorers advance to district and national levels.',
                'event_date' => Carbon::now()->addDays(25)->setTime(9, 0),
                'location' => 'Exam Hall',
                'organizer' => 'Mathematics Department',
                'status' => 'upcoming',
                'max_participants' => 100,
                'registered_participants' => 60,
                'category' => 'Academic',
                'is_public' => true,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
