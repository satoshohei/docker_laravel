@extends('posts.layout')

@section('content')
<div class="card mt-5">
    <div class="card-header">
        <h2>詳細確認画面</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-1 mr-1">
                <div class="float-right">
                    <a class="btn btn-primary" href="{{ route('posts.index') }}"> Back</a>
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
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Title:</strong>
                            {{ $post->title }}
                        </div>
                    </div>

                    @isset ($post->image_url)
                    <div>
                        <img src="{{asset('storage/' . $post->image_url) }}" width="600">
                    </div>
                    @endisset

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Description:</strong>
                            {{ $post->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection