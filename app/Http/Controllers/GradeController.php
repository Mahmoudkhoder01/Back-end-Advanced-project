<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Section;

class GradeController extends Controller
{
    public function addGrade(Request $request){
        $grade = new Grade;
        $name = $request -> input ('name');
        $grade->name = $name;
        $grade->save();
        return response()->json([
            'message'=> "grade created successfully!",
        ]);
    }
    public function getGrades(Request $request){
        $grades = Grade::all();
        return response()->json([
            'message'=>$grades,
        ]);
    }

    public function getGrade(Request $request,$id){
        $grade = Grade::find($id);
        return response()->json([
            'message'=>$grade,
        ]);
    }


   public function deleteGrade(Request $request, $id){
         
    $grade =  Grade::find($id);
    if (!$grade){
        return response()->json([
            'message' => 'grade not found!',
        ]);
    }
    $grade->delete();
    return response()->json([
        'message' => 'grade deleted Successfully!',
 
    ]);
}
public function editGrade(Request $request, $id){
    $grade = Grade::find($id);
    if (!$grade){
        return response()->json([
            'message' => 'grade not found!',
        ]);
    }
    $inputs = [
        'name' => $request->input('name')
    ];
    $grade->update($inputs);

    return response()->json([
        'message' => 'grade edited successfully!',
        'grade' => $grade,
    ]);
}

}
