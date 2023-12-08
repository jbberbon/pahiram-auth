<?php

namespace App\Http\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Course;

class ExistsInCourses implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the course_id exists in the courses table
        return Course::where('id', $value)->exists();
    }

    public function message()
    {
        return 'The selected course does not exist.';
    }
}
