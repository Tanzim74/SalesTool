<?php

namespace App\Services;

use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class TeacherService
{
    public function getAllTeachers()
    {
        
    }

    public function getTeacherById($id)
    {
        
    }
    

    public function createTeacher( $request, array $data)
    {
         $request->validate([
        'name'            => 'required|string|max:255',
        'email'           => 'required|email|unique:users,email',
        'national_id'     => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'education'       => 'required|in:SSC,HSC,Bachelors,Masters',
        'last_qualification' => 'required|string',
        'age'             => 'required|integer|min:18|max:80',
        'phone_number'    => 'required|string|max:20',
        'account_no'      => 'required|digits:5|unique:teachers,account_no',
        'password'        => 'required|min:8',
    ]);
       $idImage = $request->file('national_id')->store('id_images');

    DB::transaction(function () use ($request, $idImage) {

        // ➤ Insert Teacher First
        $teacher = Teacher::create([
            'email' => $request->email,
            'national_id_image' => $idImage,
            'education' => $request->education,
            'last_qualification' => $request->last_qualification,
            'age' => $request->age,
            'phone_number' => $request->phone_number,
            'account_no' => $request->account_no,
            'password' => Hash::make($request->password),
        ]);

        
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'     => 2, // Teacher Role   
        ]);

    });
        // Upload image       
        return back()->with('success', 'Teacher Registered Successfully');
    }

    public function updateTeacher($id, array $data)
    {
        
    }

    public function deleteTeacher($id)
    {
        
    }
}
