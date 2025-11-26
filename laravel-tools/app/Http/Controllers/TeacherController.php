<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeacherService;

class TeacherController extends Controller
{
    protected $teacherService;

    // Laravel automatically resolves this dependency from Service Container
    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        $teachers = $this->teacherService->getAllTeachers();
        return response()->json($teachers);
    }

    public function show($id)
    {
        $teacher = $this->teacherService->getTeacherById($id);
        return response()->json($teacher);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'experience_years' => 'integer|min:0',
        ]);

        $teacher = $this->teacherService->createTeacher($validated);
        return response()->json(['message' => 'Teacher created successfully', 'data' => $teacher], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'subject' => 'sometimes|required|string|max:255',
            'experience_years' => 'sometimes|integer|min:0',
        ]);

        $teacher = $this->teacherService->updateTeacher($id, $validated);
        return response()->json(['message' => 'Teacher updated successfully', 'data' => $teacher]);
    }

    public function destroy($id)
    {
        $this->teacherService->deleteTeacher($id);
        return response()->json(['message' => 'Teacher deleted successfully']);
    }
}
