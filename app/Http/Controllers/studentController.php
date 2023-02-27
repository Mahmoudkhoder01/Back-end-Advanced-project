<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\students;
use App\Models\sections;
use App\Models\attendance;



class studentController extends Controller
{


    public function GetStudents(Request $request){
        $students = students::with('sections')->get();

        return response()->json([
            'message'=>$students

        ]);

}

public function GetStudentsById(Request $request,$id){
    $students = students::where('id',$id)->with('sections')->get();

    return response()->json([
        'message'=>$students

    ]);





}

    public function store(Request $request){
        $student = new students;
        $First_name = $request -> input('first_name');
        $Last_name = $request -> input('last_name');
        $email = $request -> input('email');
        $birth_day = $request -> input('birth_date');
        $phone = $request -> input('phone_number');
        $enroll = $request -> input('enrollment_date');
        $headshot= $request -> input('headshot');
        $attendance = $request -> input('attendance');
        $attendance = attendence::find($attendance);
        $section_id = $request -> input('section_id');
        $section = sections::find($section_id);
        $student->first_name = $First_name;
        $student->last_name = $Last_name;
        $student->email = $email;
        $student->birth_date = $birth_day;
        $student->phone_number = $phone;
        $student->enrollment_date = $enroll;
        $student->headshot = $headshot;
        // $student->attendance = $attendance;
        $student->attendance()->associate($attendance);
        $student->sections()->associate($section);
        $student->save();
        
        return response()->json([
        'success' => true,
        'message' => 'Student was successfully',
        
        ]);
    }
        
        public function deletestudents(Request $request, $id){
         
            $students = students::find($id);
            $students->delete();
            return response()->json([
                'message' => 'students deleted Successfully!',
            ]);
        }
    
    
        public function editstudents(Request $request, $id){s
           
            $students =  students::find($id);
            $inputs= $request->except('_method');
            $students->update($inputs);
            return response()->json([
                'message' => 'students edited successfully!',
                'students' => $students,     
            ]);
       }
        
        
        }


       