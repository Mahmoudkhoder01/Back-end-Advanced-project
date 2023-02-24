<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\attendance;
use Illuminate\Support\Facades\Storage;

class attendanceController extends Controller
{
    // public function takeAttendance(Request $request)
    // {
    //     $attendance = new attendance;
    //     $status = $request->input('status');
    //     $attendance->status = $status;
    //     $attendance->save();
    //     return response()->json([
    //         'message' => 'Attendance taked!',

    //     ]);
    // }
}