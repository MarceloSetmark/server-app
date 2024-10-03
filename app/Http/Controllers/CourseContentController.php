<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseContent;
use App\Models\Course;
use App\Http\Requests\StoreCourseContentRequest;
use App\Http\Requests\UpdateCourseContentRequest;

class CourseContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CourseContent::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseContentRequest $request)
    {
        $content = CourseContent::create($request->all());
        return response()->json($content, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::find($id);

        if ($course) {
            $contents = CourseContent::where('course_id', $id)->get();

            return response()->json([
                'course' => $course,
                'contents' => $contents
            ], 200);
        }

        return response()->json(['message' => 'Course not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseContentRequest $request, string $id)
    {
        $content = CourseContent::findOrFail($id);
        $content->update($request->all());
        return response()->json($content, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /* public function destroy(string $id)
    {
        CourseContent::findOrFail($id)->delete();
        return response()->json(null, 204);
    } */
}
