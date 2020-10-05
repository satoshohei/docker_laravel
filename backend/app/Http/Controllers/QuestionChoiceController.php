<?php

namespace App\Http\Controllers;

use App\Models\Question_Choice;
use Illuminate\Http\Request;

class QuestionChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question_choices = Question_Choice::latest()->paginate(5);
        return view('question_choices.index', compact('question_choices'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show e form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($question_id)
    {

        return view('question_choices.create', compact('question_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$question_id)
    {
        //エラーチェック
        $request->validate([
            'choice' => 'required',
            'is_true_choice' => 'required',
        ]);

        //Question_Choice::create($request->all());

        Question_Choice::create([
            'question_id' => $question_id,
            'choice' => $request->choice,
            'is_true_choice' => $request->is_true_choice,
        ]);

        //成功のメッセージを出しつつ戻る。
        return redirect()->route('questions.show',$question_id)
            ->with('success', '新規登録完了しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question_Choice $question)
    {


        return view('question_choices.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question_Choice $question)
    {
        return view('question_choices.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'question' => 'required',
            'point' => 'required',
        ]);

        $update = [
            'question' => $request->question,
            'point' => $request->point,
        ];

        //updateを実行
        Question_Choice::where('id', $id)->update($update);

        return redirect()->route('question_choices.index')
            ->with('success', 'QuestionChoice updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question_Choice $QuestionChoice)
    {
        $QuestionChoice->delete();

        return redirect()->route('question_choices.index')
            ->with('success', 'QuestionChoice deleted successfully');
    }
}
