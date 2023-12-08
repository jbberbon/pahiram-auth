<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCourseRequest;
use App\Http\Requests\EditCourseRequest;
use App\Models\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the course resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isEmployee) {
            $courses = Course::all();

            return response([
                'status' => true,
                'data' => $courses,
                'method' => "GET"
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'Unauthorized Access',
            'method' => "GET"
        ], 401);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddCourseRequest $request)
    {
        $user = Auth::user();

        if ($user->isEmployee) {
            $validatedData = $request->validated();
            Course::create($validatedData);
            return response([
                'status' => true,
                'message' => "Added course successfully",
                'method' => "POST"
            ], 200);
        }

        return response([
            'status' => false,
            'message' => 'Unauthorized Access',
            'method' => "POST"
        ], 401);

    }

    /**
     * Display the specified resource.
     */
    public function show($courseId)
    {
        $user = Auth::user();
        if ($user->isEmployee) {
            try {
                /** 
                 * Use findOrFail to explicitly throw an exception 
                 * if the course is not found
                 */
                $course = Course::findOrFail($courseId);

                return response([
                    'status' => true,
                    'data' => $course,
                    'method' => 'GET',
                ], 200);
            } catch (ModelNotFoundException $e) {
                return response([
                    'status' => false,
                    'message' => 'Course not found',
                    'method' => 'GET',
                ], 404);
            }
        }

        return response([
            'status' => false,
            'message' => 'Unauthorized Access',
            'method' => "POST"
        ], 401);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCourseRequest $request, $courseId)
    {
        $user = Auth::user();
        if ($user->isEmployee) {
            try {
                /** 
                 * Use findOrFail to explicitly throw an exception 
                 * if the course is not found
                 */
                $course = Course::findOrFail($courseId);
                $validatedData = $request->validated();

                // Update the course
                $course->update($validatedData);
                $updatedCourse = Course::findOrFail($courseId);

                return response([
                    'status' => true,
                    'message' => 'Course updated successfully',
                    'data' => $updatedCourse,
                    'method' => 'PATCH',
                ], 200);
            } catch (ModelNotFoundException $e) {
                return response([
                    'status' => false,
                    'message' => 'Course not found',
                    'method' => 'PATCH',
                ], 404);
            }
        }

        return response([
            'status' => false,
            'message' => 'Unauthorized Access',
            'method' => "PATCH"
        ], 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($courseId)
    {
        $user = Auth::user();
        if ($user->isEmployee) {
            try {
                /** 
                 * Use findOrFail to explicitly throw an exception 
                 * if the course is not found
                 */
                $course = Course::findOrFail($courseId);
                $course->delete();

                return response([
                    'status' => true,
                    'message' => 'Course deleted successfully',
                    'method' => 'DELETE',
                ], 200);
            } catch (ModelNotFoundException $e) {
                return response([
                    'status' => false,
                    'message' => 'Course not found',
                    'method' => 'DELETE',
                ], 404);
            }
        }

        return response([
            'status' => false,
            'message' => 'Unauthorized Access',
            'method' => "POST"
        ], 401);
    }
}
