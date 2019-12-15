<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StudentTakeQuizController extends Controller
{

    public function __invoke(Request $request, Quiz $quiz)
    {
        abort_unless(\auth()->user()['role'] === 'mahasiswa', 403);

        $this->validate($request, [
            'password' => 'required'
        ]);


        if ($quiz['password'] != $request['password']) {
            return response()->json([
                'message' => 'Password Quiz yang anda masukan salah!'
            ]);
        }

        Session::put('quiz_password', $request['password']);

        return response()->json([
            'url' => route('quiz.show', $quiz)
        ]);
    }
}
