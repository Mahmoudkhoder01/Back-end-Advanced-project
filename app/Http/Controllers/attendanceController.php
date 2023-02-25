<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\attendance;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

class attendanceController extends Controller
{
    public function takeAttendance(Request $request)
    {
        $attendance = new attendance;
        $status = $request->input('status');
        $student_id = $request->input('student_id');
        $section_id = $request->input('section_id');  
        $student = Student::find($student_id);
        $section = Section::find($section_id);
        $attendance->status = $status;
        $attendance->student()->associate($student);
        $attendance->section()->associate($section);
        $attendance->save();
        return response()->json([
            'message' => 'Attendance registered!',

        ]);
    }

    public function getStudentByNameInAttendanceSheet(Request $request, $student_first_name, $student_last_name)
    {
        $attendance = attendance::find($id)->with(['profile'])->get();
        
        return response()->json([
            'message' => $attendance->$status,

        ]);
    }
    public function getAuthor(Request $request, $id){
         
        $author =  Author::find($id)->with(['profile'])->get();
  
        return response()->json([
            'message' => $author,
     
        ]);
    }
    
}