<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubmitQuizController extends Controller
{
    public function __invoke(Request $request, Quiz $quiz)
    {
        $validated = $this->validate($request, [
            'questions' => 'required|array',
            'questions.*.id' => 'required',
            'questions.*.answer' => 'required'
        ]);

        $response = $this->ApiPOST('quiz/' . $quiz['quiz_provider_id'] . '/submit', $validated);

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody()->getContents(), true);

            QuizResult::create([
                'quiz_id' => $quiz['id'],
                'user_id' => auth()->id(),
                'score' => $data['data']['score']
            ]);

            Session::flash('success', $data['data']['message']);
        } else {
            Session::flash('error', 'Something went wrong');
            return redirect()->back();
        }

        $quiz->load('classroom');

        return redirect()->route('classroom.show', $quiz['classroom']['id']);

    }
}
