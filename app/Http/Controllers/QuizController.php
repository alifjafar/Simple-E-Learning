<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Quiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{

    public function create(Classroom $classroom)
    {
        $categories = $this->ApiGET('categories')['data'];

        return view('dashboard.classroom.quiz.create', compact('categories', 'classroom'));
    }

    public function store(Request $request)
    {

        $validated = $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required',
            'classroom_id' => 'required|exists:classrooms,id',
            'password' => 'required',
            'questions' => 'required|array',
            'questions.*.content' => 'required|string',
            'questions.*.options.*.content' => 'required|string',
            'questions.*.options.*.answer' => 'sometimes|nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $validated['is_private'] = true;

        $response = $this->ApiPOST('quiz', $validated);


        if ($response->getStatusCode() == 201) {
            $quizProvider = json_decode($response->getBody()->getContents(), true);
            $validated['start_date'] = Carbon::parse($validated['start_date']);
            $validated['end_date'] = Carbon::parse($validated['end_date']);
            $validated['quiz_provider_id'] = $quizProvider['data']['quiz_id'];

            Quiz::create($validated);

            Session::flash('success', 'Quiz Berhasil dibuat');
        } else {
            Session::flash('error', 'Something went wrong');
        }

        return redirect()->route('classroom.show', $validated['classroom_id']);
    }

    public function show(Quiz $quiz)
    {
        abort_unless(auth()->user()['role'] === 'mahasiswa', 403);

        if (!Session::exists('quiz_password'))
            return redirect()->back();


        $response = $this->ApiGET('quiz/' . $quiz['quiz_provider_id'], [
            'password' => Session::get('quiz_password')
        ]);

        $quizProvider = $response['data'];

        return view('dashboard.classroom.quiz.show', compact('quiz', 'quizProvider'));
    }

    public function edit(Classroom $classroom, Quiz $quiz)
    {
        $quizProvider = $this->ApiGET('quiz/' . $quiz['quiz_provider_id'] . '/edit')['data'];
        $categories = $this->ApiGET('categories')['data'];


        return view('dashboard.classroom.quiz.edit', compact('quizProvider', 'quiz', 'categories', 'classroom'));
    }

    public function update(Request $request, Quiz $quiz)
    {

        $validated = $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required',
            'password' => 'required',
            'questions' => 'required|array',
            'questions.*.content' => 'required|string',
            'questions.*.options.*.content' => 'required|string',
            'questions.*.options.*.answer' => 'sometimes|nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $validated['is_private'] = true;

        $response = $this->ApiPUT('quiz/' . $quiz['quiz_provider_id'], $validated);


        if ($response->getStatusCode() == 200) {
            $quizProvider = json_decode($response->getBody()->getContents(), true);
            $validated['start_date'] = Carbon::parse($validated['start_date']);
            $validated['end_date'] = Carbon::parse($validated['end_date']);
            $validated['quiz_provider_id'] = $quizProvider['data']['quiz_id'];

            $quiz->update($validated);

            Session::flash('success', 'Quiz Berhasil diupdate');
        } else {
            Session::flash('error', 'Something went wrong');
        }

        return redirect()->route('classroom.show', $quiz['classroom_id']);
    }
}
