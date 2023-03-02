<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\attendance;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;

class attendanceController extends Controller
{
    //Take an attendance
    public function takeAttendance(Request $request)
    {
        $attendance = new attendance;
        $status = $request->input('status');
        $section_id = $request->input('section_id');
        $student_id = $request->input('student_id');
        $date = $request->input('date');
        
        $student = Student::find($student_id);
        if (!$student) {
            return response()->json([
                'message' => 'No student found to take attendance',
            ], 404);
        }

        $section = Section::find($section_id);
        if (!$section) {
            return response()->json([
                'message' => 'No section found to take attendance',
            ], 404);
        }

        $attendance->section()->associate($section);
        $attendance->student()->associate($student);
        $attendance->status = $status;
        $attendance->date = $date;
        $attendance->save();

        return response()->json([
            'message' => 'Attendance taked!',

        ]);
    }

    // Get all attendances
    public function getAll(Request $req)
    {
        $attendance = attendance::get();
        return response()->json([
            "message" => $attendance
        ]);
    }

    //  Get an attendance by student id
    public function getAttendanceByStudentId(Request $req, $student_id)
    {
        $attendance = attendance::where("student_id", $student_id)->get();
        // Check if the attendance not exists
        if (!$attendance) {
            return response()->json([
                'message' => 'attendance not found!',
            ]);
        }

        return response()->json([
            "message" => $attendance
        ]);
    }


    // Get an attendance by section id
    public function getAttendanceBySectionId(Request $req, $section_id)
    {
        $attendance = attendance::where("section_id", $section_id)->get();

        if (!$attendance) {
            return response()->json([
                'message' => 'attendance not found!',
            ]);
        }

        return response()->json([
            "message" => $attendance
        ]);
    }

    // Edit an existing attendance
    public function editAttendance(Request $request, $id)
    {
        $attendance = attendance::find($id);

        // Check if the attendance not exists
        if (!$attendance) {
            return response()->json([
                'message' => 'attendance not found!',
            ]);
        }

        $inputs = [
            'status' => $request->input('status')
        ];

        // Check if the attendance is already been
        if ($attendance->name == $request->input('status')) {
            return response()->json([
                'message' => 'The attendance is the same as the old one!'
            ]);
        }

        $attendance->update($inputs);

        return response()->json([
            'message' => 'attendance edited successfully!',
            'attendance' => $attendance,
        ]);
    }

    // Delete an existing attendance
    public function deleteAttendance(Request $request, $id)
    {
        $attendance = attendance::find($id);
        if (!$attendance) {
            return response()->json([
                'message' => 'attendance not found!',
            ]);
        }
        $attendance->delete();
        return response()->json([
            'message' => 'attendance deleted Successfully!',

        ]);
    }
}
