<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuestionService;
use App\Models\Teacher;

class QuestionController extends Controller
{
    protected $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function index()
    {
        $questions = $this->questionService->getAllQuestions();
        return response()->json($questions);
    }

    public function show($id)
    {
        $question = $this->questionService->getQuestionById($id);
        return response()->json($question);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'question_text' => 'required|string',
            'type' => 'required|in:mcq,true_false,fill_blank',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|string',
        ]);

        // Encode options to JSON if provided
        if (isset($validated['options'])) {
            $validated['options'] = json_encode($validated['options']);
        }

        $question = $this->questionService->createQuestion($validated);
        return response()->json(['message' => 'Question created successfully', 'data' => $question], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'question_text' => 'sometimes|required|string',
            'type' => 'sometimes|required|in:mcq,true_false,fill_blank',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|string',
        ]);

        if (isset($validated['options'])) {
            $validated['options'] = json_encode($validated['options']);
        }

        $question = $this->questionService->updateQuestion($id, $validated);
        return response()->json(['message' => 'Question updated successfully', 'data' => $question]);
    }

    public function destroy($id)
    {
        $this->questionService->deleteQuestion($id);
        return response()->json(['message' => 'Question deleted successfully']);
    }
}
