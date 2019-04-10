<?php

namespace App\Http\Controllers;

use App\Models\ClassStudent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class StudentController extends Controller
{

    public function ajaxSearch(Request $request)
    {
        $id = $request->get('classroom_id');
        $keyword = $request->get('q');


        $students = User::with('studentClass')
            ->where('name', 'like', "%$keyword%")
            ->where('role', '=', 'mahasiswa')->get();

        $newStudent = new Collection();
        foreach ($students as $student) {
            if (count($student->studentClass)) {
                if (!$student->studentClass->contains($id)) {
                    $newStudent->add($student);
                }
            } else {
                $newStudent->add($student);
            }
        }

        return response()->json([
            'data' => $newStudent,
            'message' => 'success'
        ], 200);
    }
}
