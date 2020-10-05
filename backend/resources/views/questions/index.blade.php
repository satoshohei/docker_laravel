@extends('questions.layout')
 
@section('content')
    <div class="card mt-5">
        <div class="card-header">
            <h2>クイズ管理</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 mt-1 mr-1">
                    <div class="float-right">
                        <a class="btn btn-success" href="{{ route('questions.create') }}"> 新規質問</a>
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
                            <th>No</th>
                            <th>質問</th>
                            <th>点数</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($questions as $question)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ \Str::limit($question->question, 50) }}</td>
                            <td>{{ $question->point }}</td>
                            <td>
                                <form action="{{ route('questions.destroy',$question->id) }}" method="POST">
                   
                                    <a class="btn btn-info" href="{{ route('questions.show',$question->id) }}">回答登録</a>
                    
                                    <a class="btn btn-primary" href="{{ route('questions.edit',$question->id) }}">質問編集</a>
                   
                                    @csrf
                                    @method('DELETE')
                      
                                    <button type="submit" class="btn btn-danger">削除</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {!! $questions->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection