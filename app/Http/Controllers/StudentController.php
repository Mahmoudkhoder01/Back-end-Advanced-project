<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $students = Student::all();

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $student = new Student;
        $First_name = $request -> input('first_name');
        $Last_name = $request -> input('last_name');
        $email = $request -> input('email');
        $birth_day = $request -> input('birth_day');
        $phone = $request -> input('phone_number');
        $enroll = $request -> input('enrollment_date');
        $headshot= $request -> input('headshot');
        $attendance = $request -> input('attendance');
        $attendance = Attendence::find($attendance);
        $section_id = $request -> input('section_id');
        $section_id = Section::find($section_id);
        $student->first_name = $First_name;
        $student->last_name = $Last_name;
        $student->email = $email;
        $student->birth_day = $birth_day;
        $student->phone_number = $phone;
        $student->enrollment_date = $enroll;
        $student->headshot = $headshot;
        $student->Attendence()->associate($attendance);
        $student->Section()->associate($section);
        $student->save();


        return  response()->json([
            'success' => true,
            'message' => 'Student was successfully',


        ]);






    }

       
    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:students,email'
           'birth_date' => 'required|date',
           'phone_number' => 'required',
           'enrollment_date' => 'required|date',
           'headshot' => 'nullable|image|max:1024',
           'section_id' => 'required|exists:sections,id',
       ]);

       if ($request->hasFile('headshot')) {
           $path = $request->file('headshot')->store('public/images');
           $validatedData['headshot'] = $path;
       }

       $student->update($validatedData);

       return redirect()->route('students.show', $student);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index');
 
    }
}
