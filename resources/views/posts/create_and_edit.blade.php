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
                            <single-select-component
                                field-name = "category_id"
                                :options = "categories"
                                @if(old('category_id', $post->category_id))
                                :category-id = "{{ old('category_id', $post->category_id) }}"
                                @endif
                            >

                            </single-select-component>
                        </div>

                        <div class="form-group">
                            <multi-select-component
                                field-name = "tag_ids"
                                :tags = "tags"
                                @if(old('tag_ids', $post->tag_ids))
                                :tag-ids="{{ old('tag_ids', $post->tag_ids) }}"
                                @endif
                            ></multi-select-component>
                        </div>
                        <simplemde-component
                            content="{{ old('body', $post->body) }}"
                        ></simplemde-component>
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
    <script>
        const app = new Vue({
            el: "#app",
            data: {
                tags: {!! json_encode($tags) !!},
                categories: {!! json_encode($categories) !!},
            }
        })
    </script>
@endsection

