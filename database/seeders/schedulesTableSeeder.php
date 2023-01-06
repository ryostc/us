<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class schedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'student_id' => 4,
            'instructor_id' => 15,
            'date' => '2022-08-20',
            'time' => '20:00',
            'lesson_type' => '個人レッスン月4回',
            'memo' => 'first',
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'student_id' => 2,
            'instructor_id' => 5,
            'date' => '2023-01-01',
            'time' => '12:00',
            'lesson_type' => 'ペアレッスン月2回',
            'memo' => 'ペア1',
        ];
        DB::table('schedules')->insert($param);

        $param = [
            'student_id' => 3,
            'instructor_id' => 12,
            'date' => '2022-03-12',
            'time' => '15:00',
            'lesson_type' => 'ペアレッスン月2回',
            'memo' => 'ペア2',
        ];
        DB::table('schedules')->insert($param);
    }
}
