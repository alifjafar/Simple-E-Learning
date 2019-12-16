<?php

namespace App\Http\Controllers;

use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizHistoryController extends Controller
{
    public function __invoke()
    {
       $results = QuizResult::with('quiz.classroom')->where('user_id', auth()->id())->get();

       return view('dashboard.classroom.quiz.history', compact('results'));
    }
}
