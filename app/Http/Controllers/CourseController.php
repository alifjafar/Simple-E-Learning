<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function store(Request $request)
    {
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

        return back()->with(['success' => 'Berhasil Menambahkan Materi']);
    }
}
