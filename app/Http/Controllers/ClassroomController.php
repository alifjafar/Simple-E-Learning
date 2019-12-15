<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassStudent;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClassroomController extends Controller
{
    public function index()
    {
        $user = User::whereId(Auth::user()->id)->first();
        if ($user['role'] == 'admin') {
            $classrooms = Classroom::with('students')->orderBy('id')->paginate(12);
        } elseif ($user['role'] == 'dosen') {
            $classrooms = Classroom::with('students')->where('user_id', Auth::user()->id)
                ->orderBy('id')->paginate(12);
        } else {
            $classrooms = Classroom::whereHas('students', function ($q) use ($user) {
                $q->where('user_id', $user['id']);
            })->paginate(12);

        }
        return view('dashboard.classroom.index', compact('classrooms'));
    }

    public function create()
    {
        return view('dashboard.classroom.create');
    }

    public function edit(Classroom $classroom)
    {
        return view('dashboard.classroom.edit', compact('classroom'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string|max:191',
            'description' => 'required'
        ]);

        $validated['id'] = Str::orderedUuid()->getHex();
        $validated['user_id'] = Auth::user()->id;
        Classroom::create($validated);

        return redirect()->route('classroom.index')->with(['success' => 'Berhasil Membuat Kelas']);
    }

    public function show(Classroom $classroom)
    {
        $classroom->load('course.files');
        $classroom->load(['students','quizzes']);
        return view('dashboard.classroom.show', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string|max:191',
            'description' => 'required'
        ]);

        $classroom->update($validated);

        return redirect()->route('classroom.show', $classroom)->with(['success' => 'Berhasil Memperbaharui Kelas']);
    }

    public function showStudents(Classroom $classroom)
    {
        $classroom->load('students');
        return view('dashboard.classroom.student', compact('classroom'));
    }

    public function invite(Request $request)
    {
        $validated = $this->validate($request, [
            'classroom_id' => 'required|exists:classrooms,id',
            'students.*' => 'required|exists:users,id'
        ]);

        try {
            $classroom = Classroom::whereId($validated['classroom_id'])->first();

            $classroom->students()->attach($validated['students']);
        } catch (QueryException $e) {
            return back()->with(['error' => 'Siswa sudah diinvite']);
        }

        return back()->with(['success' => 'Berhasil Mengundang Siswa']);


    }

    public function deleteStudent($classroomId, $studentId)
    {
        $classroom = Classroom::whereId($classroomId)->first();
        $classroom->students()->detach($studentId);

        Session::flash('success', 'Berhasil Menghapus Mahasiswa dari Kelas');

        return url()->previous();
    }

    public function destroy(Classroom $classroom)
    {

        $courses = $classroom->course;
        if ($courses) {
            foreach ($courses as $course) {
                $files = $course->files()->get();

                foreach ($files as $file) {
                    Storage::delete($file['path'] . $file['filename']);
                }
            }
        }

        $classroom->delete();

        Session::flash('success', 'Berhasil Menghapus Kelas');

        return route('classroom.index');
    }

}
