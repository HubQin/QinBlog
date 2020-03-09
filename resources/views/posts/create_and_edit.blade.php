@extends('layouts.app')

@section('styles')

@endsection
@section('content')

    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        <i class="far fa-edit"></i>
                        @if($post->id)
                            编辑话题
                        @else
                            新建话题
                        @endif
                    </h2>

                    <hr>

                    @if($post->id)
                    <form action="{{ route('posts.update', $post->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                    @else
                    <form action="{{ route('posts.store') }}" method="POST" accept-charset="UTF-8">
                    @endif
                        @include('shared._errors')
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <input class="form-control" type="text" name="title"
                                   value="{{ old('title', $post->title ) }}" placeholder="请填写标题" required/>
                        </div>

                        <div class="form-group">
                            <select class="form-control" name="category_id" required>
                                <option value="" hidden disabled selected>请选择分类</option>
                                @foreach ($categories as $value)
                                    <option value="{{ $value->id }}" {{ $post->category_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <simplemde
                            content="{{ old('body', $post->body) }}"
                        ></simplemde>
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary">
                                <i class="far fa-save mr-2" aria-hidden="true"></i>
                                保存
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

@endsection

