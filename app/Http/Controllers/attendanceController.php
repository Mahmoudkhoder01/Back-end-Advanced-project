<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\attendance;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;

class attendanceController extends Controller
{
    public function takeAttendance(Request $request)
    {
        $attendance = new attendance;
        $status = $request->input('status');

        $section_id = $request->input('section_id');
        $student_id = $request->input('student_id');
        $student = Student::find($student_id);
        $section = Section::find($section_id);
        $attendance->section()->associate($section);
        $attendance->student()->associate($student);
        $attendance->status = $status;
        $attendance->save();
        return response()->json([
            'message' => 'Attendance taked!',

        ]);
    }

    public function getAll(Request $req){
        $attendance = attendance::get();
        return response()->json([
            "message" => $attendance
         ]);
    }

    public function getAttendanceByStudentId(Request $req, $student_id){
        $attendance = attendance::where("student_id", $student_id)->get();
        return response()->json([
           "message" => $attendance
        ]);
    }
    public function getAttendanceBySectionId(Request $req, $section_id){
        $attendance = attendance::where("section_id", $section_id)->get();
        return response()->json([
           "message" => $attendance
        ]);
    }
    public function editAttendance(Request $request, $id){
        $attendance = attendance::find($id);
        if (!$attendance){
            return response()->json([
                'message' => 'attendance not found!',
            ]);
        }
        $inputs = [
            'status' => $request->input('status')
        ];
        $attendance->update($inputs);
        return response()->json([
            'message' => 'attendance edited successfully!',
            'attendance' => $attendance,
        ]);
    }
    public function deleteAttendance(Request $request, $id){
        $attendance = attendance::find($id);
        if (!$attendance){
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

