<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\VideoAnnotation;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses);
    }
    public function show($id)
    {
        $course = Course::find($id);
        if ($course) {
            return response()->json($course);
        } else {
            return response()->json(['message' => 'Course not found'], 404);
        }
    }
    public function annotate(Request $request)
    {
        $course = new VideoAnnotation();
        $course->video_id = $request->video_id;
        $course->annotation_text = $request->annotation;
        $course->save();

        return response()->json(['message' => 'Annotation added successfully']);
    }
    public function annotationEdit(Request $request)
    {
        $request->validate([
            'annotation_id' => 'required|integer|exists:video_annotations,id'
        ]);

        $annotation = VideoAnnotation::findOrFail($request->annotation_id);
        
        if ($annotation->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $annotation->video_id = $request->video_id;
        $annotation->annotation_text = $request->annotation;
        $annotation->save();
        
        return response()->json(['message' => 'Annotation updated successfully']);
    }
    public function deleteAnnotation(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:video_annotations,id'
        ]);

        $annotation = VideoAnnotation::findOrFail($request->id);
        
        if ($annotation->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $annotation->delete();
        return response()->json(['message' => 'Annotation deleted successfully']);
    }
}
