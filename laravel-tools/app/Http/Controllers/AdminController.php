<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeacherService;

class AdminController extends Controller
{
    protected $adminRepo;
    protected $teacher;

    public function  __construct(TeacherService $teacher)
    {
       $this->teacher = $teacher;
        
    }
    public function index(){
        return view('dashboards.admin');
    }
    public function getAllTeachers(){
       $teachers =  $this->teacher->getAllTeachers();
         return view('teachers.index' , compact('teachers'));
    }
    public function registrationPage(){
        
       return view('teachers.register');
    }
    public function registerTeacher(){
        $this->teacher->createTeacher(request() , request()->all());

        return redirect()->back()->with('success', 'Teacher registered successfully!');
    }
    public function deleteTeacher(){

    }
    public function update($id) {
        $this->teacher->updateTeacher(request(), $id);
        return redirect()->back()->with('success', 'Teacher updated successfully!');
    }

    public function show(){
        dd(2);
    }

    
    public function edit($id)
    {
        $teacher = $this->teacher->editTeacher($id);
        return view('teachers.edit', compact('teacher'));
    }

    

    // Show all admins
   
    // Show single admin
    

    // Create admin
    
}
