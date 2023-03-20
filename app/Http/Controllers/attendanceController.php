<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\attendance;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;
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
        $attendance_date = $request->input('attendance_date');
        $student = Student::find($student_id);
        if (!$student) {
            return response()->json([
                'message' => 'No student found to take attendance',
            ], 404);
        }
        $section = Section::find($section_id);
        if (!$student) {
            return response()->json([
                'message' => 'No section found to take attendance',
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:present,absent',
            'section_id' => 'required|exists:sections,id',
            'student_id' => 'required|exists:students,id',
            'attendance_date' => 'required|date',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $attendance->section()->associate($section);
        $attendance->student()->associate($student);
        $attendance->status = $status;
        $attendance->attendance_date = $attendance_date;
        $attendance->save();

        return response()->json([
            'message' => 'Attendance taken!',
        ]);
    }


     //Take an attendanceforAll
     public function takeAttendanceforAll(Request $request){
    $attendances = $request->input('attendances');

    $validator = Validator::make($request->all(), [
        'attendances' => 'required|array',
        'attendances.*.status' => 'required|in:present,absent,late',
        'attendances.*.section_id' => 'required|exists:sections,id',
        'attendances.*.student_id' => 'required|exists:students,id',
        'attendances.*.attendance_date' => 'required|date',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);
    }

    foreach ($attendances as $attendanceData) {
        $student = Student::find($attendanceData['student_id']);
        if (!$student) {
            return response()->json([
                'message' => 'No student found to take attendance',
            ], 404);
        }

        $section = Section::find($attendanceData['section_id']);
        if (!$section) {
            return response()->json([
                'message' => 'No section found to take attendance',
            ], 404);
        }

        $attendance = new Attendance();
        $attendance->section()->associate($section);
        $attendance->student()->associate($student);
        $attendance->status = $attendanceData['status'];
        $attendance->attendance_date = $attendanceData['attendance_date'];
        $attendance->save();
    }

    return response()->json([
        'message' => 'Attendance taken!',
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
    // get attendance by date 
    public function getAttendanceByDate(Request $request, $date)
    {

        $attendances = Attendance::whereDate('attendance_date', $date)->get();

        return response()->json(['attendances' => $attendances]);
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

//  Get an attendance by section id and date
 public function getAttendanceBySectionIdAndDate(Request $request, $section_id)
 { 
    $attendance_date = $request->input('attendance_date');
    echo $attendance_date;
    $attendance = Attendance::whereDate('attendance_date', $attendance_date)
        ->get();
    if ($attendance->isEmpty()) {
        return response()->json([
            'message' => 'Attendance not found for this date!',
        ]);
    }
    return response()->json([
        'attendance' => $attendance,
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
