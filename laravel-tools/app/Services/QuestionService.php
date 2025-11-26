<?php

namespace App\Services;

use App\Models\Question;

class QuestionService
{
    public function getAllQuestions()
    {
        return Question::with('teacher')->get();
    }

    public function getQuestionById($id)
    {
        return Question::with('teacher')->findOrFail($id);
    }

    public function createQuestion(array $data)
    {
        return Question::create($data);
    }

    public function updateQuestion($id, array $data)
    {
        $question = Question::findOrFail($id);
        $question->update($data);
        return $question;
    }

    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        return $question->delete();
    }
}
