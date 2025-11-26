<?php

namespace App\Services;

use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeacherService
{
    public function getAllTeachers()
    {
        $teachers = Teacher::with('user')->paginate(10);

        return $teachers;
    }

    public function getTeacherById($id) {}


    public function createTeacher($request, array $data)
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


        DB::transaction(function () use ($request) {


            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role_id'     => 2, // Teacher Role   
            ]);
            $extension = $request->file('national_id')->getClientOriginalExtension();
            $filename = $request->name . '_' . $user->id . '.' . $extension;
            $idImage = $request->file('national_id')->storeAs('id_images', $filename, 'public');

            $teacher = Teacher::create([
                'email' => $request->email,
                'national_id_image' => $idImage,
                'education' => $request->education,
                'last_qualification' => $request->last_qualification,
                'age' => $request->age,
                'phone_number' => $request->phone_number,
                'account_no' => $request->account_no,
                'password' => Hash::make($request->password),
                'user_id' => $user->id,
            ]);
        });
        // Upload image       
        return back()->with('success', 'Teacher Registered Successfully');
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);

        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email,' . $teacher->user_id,
            'national_id'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'education'         => 'required|in:SSC,HSC,Bachelors,Masters',
            'last_qualification' => 'required|string',
            'age'               => 'required|integer|min:18|max:80',
            'phone_number'      => 'required|string|max:20',
            'account_no'        => 'required|digits:5|unique:teachers,account_no,' . $teacher->id,
            'password'          => 'nullable|min:8',
        ]);

        DB::transaction(function () use ($request, $teacher) {

            // Update User Table


            // Handle image (if new uploaded)
            if ($request->hasFile('national_id')) {
                if ($teacher->national_id_image && Storage::disk('public')->exists($teacher->national_id_image)) {
                    Storage::disk('public')->delete($teacher->national_id_image);
                }

                // Get extension
                $extension = $request->file('national_id')->getClientOriginalExtension();

                // Filename: username_userid.extension
                $filename = $request->name . '_' . $teacher->user->id . '.' . $extension;
                $filename = str_replace(' ', '', $filename);
                // Store new image in public disk
                $idImage = $request->file('national_id')->storeAs('id_images', $filename, 'public');
            } else {
                $idImage = $teacher->national_id_image; // Keep existing image
            }
            // Update Teacher Table
            $teacher->update([
                'national_id_image' => $idImage,
                'education'         => $request->education,
                'last_qualification' => $request->last_qualification,
                'age'               => $request->age,
                'phone_number'      => $request->phone_number,
                'account_no'        => $request->account_no,
            ]);
        });

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully');
    }


    public function deleteTeacher($id) {}
    public function editTeacher($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        return $teacher;
    }
}
