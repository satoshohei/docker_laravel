<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Question_Choice;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::latest()->paginate(5);
        return view('questions.index', compact('questions'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show e form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //エラーチェック
        $request->validate([
            'question' => 'required',
            'point' => 'required',
        ]);

        Question::create([
            'question' => $request->question,
            'point' => $request->point,
        ]);

        //成功のメッセージを出しつつ戻る。
        return redirect()->route('questions.index')
            ->with('success', '新規登録完了しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //回答を取得
        //$question_choices = Question_Choice::all();

        $question_choices = Question_Choice::where('question_id',  $question->id)->get();

        //sqlを確認
        /*
        $sql = Question_Choice::where('question_id',  $question->id)->toSql();
    
        return var_dump($sql);
        */

        //質問と回答を戻す
        return view('questions.show', compact('question','question_choices'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
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
        Question::where('id', $id)->update($update);

        return redirect()->route('questions.index')
            ->with('success', 'Question updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $Question)
    {
        $Question->delete();

        return redirect()->route('questions.index')
            ->with('success', 'Question deleted successfully');
    }
}
