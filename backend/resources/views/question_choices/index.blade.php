@extends('question_choices.layout')

@section('content')
<div class="card mt-5">
    <div class="card-header">
        <h2>回答管理</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-1 mr-1">
                <div class="float-right">
                    <a class="btn btn-success" href="{{ route('questions.index') }}"> Create New Post</a>
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
                        <th>回答</th>
                        <th>正解</th>
                        <th width="280px">操作</th>
                    </tr>
                    @foreach ($question_choices as $question_choice)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $question_choice->title }}</td>
                        <td>{{ \Str::limit($question_choice->description, 50) }}</td>
                        <td>
                            <form action="{{ route('question_choices.destroy',$question_choice->id) }}" method="POST">

                                <a class="btn btn-info" href="{{ route('question_choices.show',$question_choice->id) }}">Show</a>

                                <a class="btn btn-primary" href="{{ route('question_choices.edit',$question_choice->id) }}">Edit</a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
                {!! $question_choices->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection