<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Grade;
use Illuminate\Support\Facades\Validator;

class sectioncontroller extends Controller
{
    public function addSection(Request $request)
    {
        $section = new Section;
        $section_description = $request->input('section_description');
        $capacity = $request->input('capacity');
        $grade_id = $request->input('grade');
        $grade = Grade::find($grade_id);
        $section->section_description = $section_description;
        $section->capacity = $capacity;
        $section->grade()->associate($grade);
        $section->save();
        return response()->json([
            'message' => 'section created succesfully',
        ]);
    }
    public function getSections(Request $request)
    {
        $sections = Section::all();
        return response()->json([
            'message' => $sections,
        ]);
    }
    public function getSection(Request $request, $id)
    {
        $section = Section::find($id);
        return response()->json([
            'message' => $section,
        ]);
    }

    public function deleteSection(Request $request, $id)
    {

        $section =  Section::find($id);
        if (!$section) {
            return response()->json([
                'message' => 'section not found!',
            ]);
        }
        $section->delete();
        return response()->json([
            'message' => 'grade deleted Successfully!',

        ]);
    }

    public function editSection(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'section_description' => 'required',
            'capacity' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $section = Section::find($id);
        if (!$section) {
            return response()->json([
                'message' => 'section not found!',
            ]);
        }
        $inputs = [
            'section_description' => $request->input('section_description'),
            'capacity' => $request->input('capacity')
        ];
        $section->update($inputs);;

        return response()->json([
            'message' => 'section edited successfully!',
            'section' => $section,
        ]);
    }
}
