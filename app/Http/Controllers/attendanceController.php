<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\attendance;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;

class attendanceController extends Controller
{
    public function takeAttendance(Request $request)
    {
        $attendance = new attendance;
        $status = $request->input('status');

        $section_id = $request->input('section_id');
        $student_id = $request->input('student_id');
        $section = Student::find($section_id);
        $student = Student::find($student_id);
        $attendance->section()->associate($section);
        $attendance->student()->associate($student);
        $attendance->status = $status;
        $attendance->save();
        return response()->json([
            'message' => 'Attendance taked!',

        ]);
    }
}

