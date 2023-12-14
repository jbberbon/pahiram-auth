<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                "course_code" => "000",
                "course" => "No Course",
                "course_acronym" => "N/A",

            ],
            [
                "course_code" => "001",
                "course" => "BS in Information Technology With Specicialization in Mobile and Internet Technologies",
                "course_acronym" => "BSIT-MI",

            ],
            [
                "course_code" => "002",
                "course" => "BS in Architecture",
                "course_acronym" => "BSA",

            ],
            [
                "course_code" => "003",
                "course" => "BS in Business Administration",
                "course_acronym" => "BSBA",
            ],
            [
                "course_code" => "005",
                "course" => "BS in Computer Science",
                "course_acronym" => "BSCS",
            ],
            [
                "course_code" => "006",
                "course" => "BA in Psychology",
                "course_acronym" => "BAPsych",
            ],

        ];
        // Insert the users into the database
        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
