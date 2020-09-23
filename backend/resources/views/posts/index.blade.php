@extends('posts.layout')
 
@section('content')
    <div class="card mt-5">
        <div class="card-header">
            <h2>コラム管理</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 mt-1 mr-1">
                    <div class="float-right">
                        <a class="btn btn-success" href="{{ route('posts.create') }}"> Create New Post</a>
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
                            <th>Title</th>
                            <th>Description</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($posts as $post)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ \Str::limit($post->description, 50) }}</td>
                            <td>
                                <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                   
                                    <a class="btn btn-info" href="{{ route('posts.show',$post->id) }}">Show</a>
                    
                                    <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}">Edit</a>
                   
                                    @csrf
                                    @method('DELETE')
                      
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {!! $posts->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection