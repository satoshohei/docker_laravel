@extends('questions.layout')

@section('content')
<div class="card mt-5">
    <div class="card-header">
        <h2>回答登録画面</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-1 mr-1">
                <div class="float-right">
                    <a class="btn btn-primary" href="{{ route('questions.index') }}"> 戻る</a>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>質問番号</strong>
                            {{ $question->id }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>質問内容</strong>
                            {{ $question->question }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>点数</strong>
                            {{ $question->point }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--明細-->
        <div class="row">
            <div class="col-lg-12 mt-1 mr-1">
                <div class="float-right">
                    <a class="btn btn-success" href="{{ route('question_choices.create',$question->id) }}"> 回答作成</a>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
            </div>
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <tr>
                        <th>回答</th>
                        <th>正解</th>
                        <th width="280px">操作</th>
                    </tr>
                    @foreach ($question_choices as $question_choice)
                    <tr>
                        <td>{{ $question_choice->choice }}</td>
                        <td>{{ \Str::limit($question_choice->is_true_choice, 50) }}</td>
                        <td>
                            <form action="{{ route('question_choices.destroy',$question_choice->id) }}" method="POST">

                                <a class="btn btn-primary" href="{{ route('question_choices.edit',$question_choice->id) }}">編集</a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </div>
</div>
@endsection