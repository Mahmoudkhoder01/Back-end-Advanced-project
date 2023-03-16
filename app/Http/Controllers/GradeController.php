<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;


class GradeController extends Controller
{
    // Add a new grade
    public function addGrade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:grades',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }


        $grade = new Grade;
        $name = $request->input('name');
        $grade->name = $name;
        $grade->save();
        return response()->json([
            'message' => "grade created successfully!",
        ]);
    }

    // Get all grades
    public function getGrades(Request $request)
    {
        $grades = Grade::with('section')->paginate(10);
        return response()->json([
            'message' => $grades,
        ]);
    }

    // Get a grade by id
    public function getGrade(Request $request, $id)
    {
        $grade = Grade::find($id);
        // Check if the grade not exists
        if (!$grade) {
            return response()->json([
                'message' => 'Grade not found!',
            ]);
        }
        return response()->json([
            'message' => $grade,
        ]);
    }


    // Delete an existing grade
    public function deleteGrade(Request $request, $id)
    {

        $grade =  Grade::find($id);
        // Check if the grade not exists
        if (!$grade) {
            return response()->json([
                'message' => 'grade not found!',
            ]);
        }

        $grade->delete();

        return response()->json([
            'message' => 'grade deleted Successfully!',

        ]);
    }

    // Edit an existing grade
    public function editGrade(Request $request, $id)
    {
        $grade = Grade::find($id);
        // Check if the grade not exists
        if (!$grade) {
            return response()->json([
                'message' => 'grade not found!',
            ]);
        }

        $inputs = [
            'name' => $request->input('name')
        ];

        //Check if the grade has already been
        if ($grade->name == $request->input('name')) {
            return response()->json([
                'message' => 'The grade name is the same as the old one!'
            ]);
        }

        $grade->update($inputs);

        return response()->json([
            'message' => 'grade edited successfully!',
            'grade' => $grade,
        ]);
    }
}
