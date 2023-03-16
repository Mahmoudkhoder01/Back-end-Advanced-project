<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Grade;
use App\Models\Student;

class sectioncontroller extends Controller
{
    // Add a new section
    public function addSection(Request $request)
    {
        $section = new Section;
        $section_description = $request->input('section_description');
        $capacity = $request->input('capacity');
        $grade_id = $request->input('grade');
        $grade = Grade::find($grade_id);

        //Check if there is no grade to add a section
        if (!$grade) {
            return response()->json([
                'message' => 'No grade found to add a new section',
            ], 404);
        }

        // Check if section already exists for the same grade
        $existingSection = Section::where([
            ['section_description', $section_description],
            ['grade_id', $grade_id],
        ])->first();

        if ($existingSection) {
            return response()->json([
                'message' => 'A section with the same description already exists for the selected grade',
            ], 409);
        }

        $section->section_description = $section_description;
        $section->capacity = $capacity;
        $section->grade()->associate($grade);
        $section->save();
        return response()->json([
            'message' => 'section created succesfully',
        ]);
    }

    // Get all sections
    public function getSections(Request $request)
    {
        $sections = Section::with('student')->get();
        return response()->json([
            'message' => $sections,
        ]);
    }

    // Get a section by id
    public function getSection(Request $request, $id)
    {
        $section = Section::find($id);
        // Check if the section not exists
        if (!$section) {
            return response()->json([
                'message' => 'Section not found!',
            ]);
        }
        return response()->json([
            'message' => $section,
        ]);
    }

    //Get sections by grade id 
    public function getSectionByGradeId(Request $request, $grade_id){
        $sections = Section::where('grade_id', $grade_id)->get();
        if (!$sections) {
            return response()->json([
                'message' => 'Section not found!',
            ]);
        }
        return response()->json([
            'message' => $sections,
        ]);
    }

    // Delete a section
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

    // Edit a section
    public function editSection(Request $request, $id)
    {

        $section = Section::find($id);

        if (!$section) {
            return response()->json([
                'message' => 'section not found!',
            ]);
        }

        $inputs = [
            'section_description' => $request->input('section_description'),
            'capacity' => $request->input('capacity'),
        ];

        if ($section->section_description == $request->input('section_description')) {
            return response()->json([
                'message' => 'The section description is the same as the old one!'
            ]);
        }

        if ($section->capacity == $request->input('capacity')) {
            return response()->json([
                'message' => 'The section capacity is the same as the old one!'
            ]);
        }

        $section->update($inputs);;

        return response()->json([
            'message' => 'section edited successfully!',
            'section' => $section,
        ]);
    }
}
