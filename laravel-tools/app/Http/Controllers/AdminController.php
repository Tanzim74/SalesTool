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
    public function updateTeacher() {

    }
    public function show(){
        dd(2);
    }
    

    // Show all admins
   
    // Show single admin
    

    // Create admin
    
}
