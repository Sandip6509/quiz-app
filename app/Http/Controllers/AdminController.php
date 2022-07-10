<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuizHeader;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $sectionCount = Section::count();
        $questionCount= Question::count();
        $quizCount  = QuizHeader::count();
        $userCount  = User::count();
        $latestUsers = User::latest()->take(5)->get();
        return view('admin.adminhome', compact('latestUsers','userCount','quizCount','questionCount','sectionCount'));
    }
}
