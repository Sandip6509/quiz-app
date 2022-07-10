<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::withCount('questions')->paginate(10);

        return view('admin.list_sections', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_section');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'section.*' => 'required',
        ]);

        auth()->user()->sections()->createMany($data);

        return redirect()->route('sections.index')->with('success', 'Section created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        $questions = $section->questions()->paginate(10);
        return view('admin.detail_sections', compact('questions', 'section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        return view('admin.edit_section',compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        $data = $request->validate([
            'name' => 'required|min:5|max:255',
            'description' => 'required|min:5|max:255',
            'is_active' => 'required',
            'details' =>    'required|min:10|max:1024',
        ]);

        $section->update($data);

        session()->flash('success', 'Section saved successfully!');
        return redirect()->route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->back()->withSuccess('Section with id: ' . $section->id . ' deleted successfully');
    }
}
