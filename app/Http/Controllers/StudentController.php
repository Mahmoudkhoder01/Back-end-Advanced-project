<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(): Response
    // {
    //     $students = Student::all();

    //     return view('students.index', compact('students'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    // public function create(): Response
    // {
    //     return view('students.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

    public function getStudents(Request $request)
    {
        $student = Student::all();
        return response()->json([
            'message' => $student,
        ]);
    }

    public function getStudentbySection(Request $request, $id)
    {
        $students = Student::where('section_id', $id)->get();
        return response()->json([
            'message' => $students,
        ]);
    }
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
    /**
     * Display the specified resource.
     */

    // public function show(string $id): Response
    // {
    //     return view('students.show', compact('student'));
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id): Response
    // {
    //     return view('students.edit', compact('student'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id): RedirectResponse
    // {
    //     $validatedData = $request->validate([
    //         'first_name' => 'required|max:255',
    //         'last_name' => 'required|max:255',
    //         'email' => 'required|email|unique:students,email'
    //        'birth_date' => 'date',
    //        'phone_number' => 'required',
    //        'enrollment_date' => 'required|date',
    //        'headshot' => 'nullable|image|max:1024',
    //        'section_id' => 'required|exists:sections,id',
    //    ]);

    //    if ($request->hasFile('headshot')) {
    //        $path = $request->file('headshot')->store('public/images');
    //        $validatedData['headshot'] = $path;
    //    }

    //    $student->update($validatedData);

    //    return redirect()->route('students.show', $student);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id): RedirectResponse
    // {
    //     $student->delete();

    //     return redirect()->route('students.index');

    // }
}
