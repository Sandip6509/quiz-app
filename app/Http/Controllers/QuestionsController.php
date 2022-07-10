<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Section;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Section $section)
    {
        return view('admin.create_question',compact('section'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Section $section, Request $request)
    {
        $data = $request->validate([
            'question' => ['required', Rule::unique('questions')],
            'explanation' => 'required',
            'is_active' => 'required',
            'answers.*.answer' => 'required',
            'answers.*.is_checked' => 'present'
        ]);

        $question = Question::create([
            'question' => $request->question,
            'explanation' => $request->explanation,
            'is_active' => $request->is_active,
            'user_id' => Auth::id(),
            'section_id' => $section->id,
        ]);

        $question->answers()->createMany($data['answers'])->push();
        return redirect()->route('sections.show', $section->id)
            ->withSuccess('Question created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $answers = $question->answers()->paginate(10);

        return view('admins.detail_question', compact('question', 'answers'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('sections.show', $question->section->id)->withSuccess('Question with id: ' . $question->id . ' deleted successfully');
    }
}
