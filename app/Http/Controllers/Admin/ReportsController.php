<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answer;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Report;
use App\Models\User;

class ReportsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $reports = Report::reports();

        return view('admin.reports.index', compact('reports'));
    }

    public function show($id)
    {
        $report = Report::findOrFail($id);

        return view('admin.reports.show', compact('report'));
    }

    public function edit($id)
    {
        $report = Report::findOrFail($id);

        if ($report->type == 'question') {
            return redirect()->route('questions.edit', $report->question_id);
        } elseif ($report->type == 'answer') {
            return redirect()->route('answers.edit', $report->answer_id);
        }
    }

    public function delete($id, $block_user = false)
    {
        $report = Report::findOrFail($id);

        if ($report->type == 'question') {
            $question = Question::find($report->question_id);
            if ($block_user) {
                $user = User::find($question->user->id);
                $user->status = false;
                $user->save();
            }
            $question->delete();
        } elseif ($report->type == 'answer') {
            $answer = Answer::find($report->answer_id);
            if ($block_user) {
                $user = User::find($answer->user->id);
                $user->status = false;
                $user->save();
            }
            $answer->delete();
        }

        $report->delete();

        return redirect()->route('reports.index');
    }

    public function deleteReport($id)
    {
        $report = Report::findOrFail($id);

        if ($report->type == 'question') {
            $reports = Report::where('question_id', $report->question_id)->get();
            foreach ($reports as $report)
                $report->delete();
        } elseif ($report->type == 'answer') {
            $reports = Report::where('answer_id', $report->question_id)->get();
            foreach ($reports as $report)
                $report->delete();
        }

        return redirect()->route('reports.index');
    }
}
