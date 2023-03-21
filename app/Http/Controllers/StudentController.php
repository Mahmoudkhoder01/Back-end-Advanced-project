<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    // Add a new student
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:students',
            'phone_number' => ['required', 'regex:/(^70|^71|^76|^78|^79|^81|^06|^03)[0-9]{6}$/'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }
        $student = new Student;

        $First_name = $request->input('first_name');
        $Last_name = $request->input('last_name');
        $email = $request->input('email');
        $birth_date = $request->input('birth_date');
        $phone = $request->input('phone_number');
        $enroll = $request->input('enrollment_date');
        //$headshot = $request->input('headshot');
        $image_path = $request->file('image')->store('images', 'public');
        $section_id = $request->input('section_id');
        $request->validate([
            'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'
        ]);
        $section = Section::find($section_id);
        // Check if we don't have a section
        if (!$section) {
            return response()->json([
                'message' => 'No section found to add a new student',
            ], 404);
        }

        // Check if the section reach the max of students
        $studentCount = $section->student()->count();
        if ($studentCount >= $section->capacity) {
            return response()->json([
                'message' => 'The section has reached its capacity',
            ], 400);
        }

        $student->first_name = $First_name;
        $student->last_name = $Last_name;
        $student->email = $email;
        $student->birth_date = $birth_date;
        $student->phone_number = $phone;
        $student->enrollment_date = $enroll;
        // $student->headshot = $headshot;
        $student->headshot = $image_path;
        $student->Section()->associate($section);
        $student->save();


        return  response()->json([
            'success' => true,
            'message' => 'Student was successfully added',
        ]);
    }

    // get All Students By Pagination
    public function getStudentsByPagination(Request $request)
    {
        $students = Student::orderBy('first_name', 'asc')
            ->paginate(8);
        return response()->json([
            'message' => $students,
        ]);
    }

    // get All Students
    public function getStudents(Request $request)
    {
        $students = Student::get();
        return response()->json([
            'message' => $students,
        ]);
    }

    // Get a student by section id
    public function getStudentBySectionId(Request $req, $section_id)
    {
        $student = Student::where("section_id", $section_id)->get();

        if (!$student) {
            return response()->json([
                'message' =>[],
            ]);
        }

        return response()->json([
            "message" => $student
        ]);
    }

    // Get a student by section id by pagination
    public function getStudentBySectionIdByPagination(Request $req, $section_id)
    {
        $student = Student::where("section_id", $section_id)->paginate(15);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found!',
            ]);
        }

        return response()->json([
            "message" => $student
        ]);
    }

    // Get a student by id
    public function getStudent(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'message' => 'student not found!',
            ]);
        }
        return response()->json([
            'message' => $student,
        ]);
    }


    // Delete a student
    public function deleteStudent(Request $request, $id)
    {
        $student = Student::find($id);

        // Check if the attendance not exists
        if (!$student) {
            return response()->json([
                'message' => 'attendance not found!',
            ]);
        }

        $student->delete();
        return response()->json([
            'message' => 'student deleted Successfully!',
        ]);
    }


    // Edit a student
    public function editStudent(Request $request, $id)
    {
        $student =  Student::find($id);
        $inputs = $request->except('_method');
        $student->update($inputs);
        return response()->json([
            'message' => 'student edited successfully!',
            'students' => $student,
        ]);
    }
}
