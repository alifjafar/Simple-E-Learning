<?php

namespace App\Http\Controllers\Api;

use App\Models\QuizResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuizHistoryController extends Controller
{
    public function __invoke()
    {
        $results = QuizResult::with('quiz.classroom')->where('user_id', auth()->id())->get();

        return response()->json([
            'data' => $results
        ]);
    }
}
