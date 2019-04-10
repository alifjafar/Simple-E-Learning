<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function store(Request $request)
    {
        Session::flash('showModel', 'Show Modal');
        $validated = $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required|string',
            'classroom_id' => 'required|exists:classrooms,id',
            'file' => 'required|mimes:pdf,docx,doc,pptx,ppt,xls,xlsx'
        ]);

        $upload = new FileController();
        $file = $upload->store($request);

        $course = Course::create($validated);

        $course->files()->attach($file);

        Session::forget('showModel');
        return back()->with(['success' => 'Berhasil Menambahkan Materi']);
    }

    public function destroy(Course $course)
    {

        $classroom = $course['classroom_id'];
        $files = $course->files()->get();

        foreach ($files as $file) {
            Storage::delete($file['path'] . $file['filename']);
        }

        $course->delete();

        Session::flash('success', 'Berhasil Menghapus Materi');

        return route('classroom.show', $classroom);
    }
}
