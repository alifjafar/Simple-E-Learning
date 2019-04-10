<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $classroom->load('students');
        return view('dashboard.classroom.show', compact('classroom'));
    }

    public function invite(Request $request)
    {
        $validated = $this->validate($request, [
            'classroom_id' => 'required|exists:classrooms,id',
            'students.*' => 'required|exists:users,id'
        ]);

        $classroom = Classroom::whereId($validated['classroom_id'])->first();

        $classroom->students()->attach($validated['students']);

        return back()->with(['success' => 'Berhasil Mengundang Siswa']);


    }

}
