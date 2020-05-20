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
                            编辑文章
                        @else
                            新建文章
                        @endif
                    </h2>

                    <hr>

                    @if($post->id)
                    <form action="{{ route('posts.update', $post->id) }}" method="POST" accept-charset="UTF-8" ref="form">
                        <input type="hidden" name="_method" value="PUT">
                    @else
                    <form action="{{ route('posts.store') }}" method="POST" accept-charset="UTF-8" ref="form">
                    @endif
                        @include('shared._errors')
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <input class="form-control" type="text" name="title"
                                   value="{{ old('title', $post->title ) }}" placeholder="请填写标题" required/>
                        </div>
                        <div class="form-group">
                            <input type="text" name="slug" class="form-control" aria-label="Text input with checkbox"
                                   placeholder="请填写文章的Slug" value="{{ old('slug', $post->slug) }}"
                                   title="用于SEO优化，建议使用英文，例如：My example title。留空则根据标题自动翻译。"
                            />
                        </div>

                        <div class="form-group">
                            <single-select-component
                                field-name = "category_id"
                                :options = "categories"
                                @if(old('category_id', $post->category_id))
                                :id = "{{ old('category_id', $post->category_id) }}"
                                @endif
                            >
                            </single-select-component>
                        </div>
                        <div class="form-group">
                            <simplemde-component
                                :content="postBody"
                            ></simplemde-component>
                        </div>
                        <div class="form-group">
                            <div id="accordion">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <div @click="collapse=!collapse" class="collapsed" :style="[collapse ? { color:'rgba(0,0,0,.4)' } : { color:'rgba(0,0,0,.87)' }]" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                <svg class="icon" aria-hidden="true">
                                                    <use :xlink:href="[collapse ? '#iconright' : '#icondown']"></use>
                                                </svg>
                                                <span>高级设置</span>
                                            </div>
                                        </h5>
                                    </div>

                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="form-group" title="文章标签">
                                                <multi-select-component
                                                    field-name = "tag_ids"
                                                    :tags = "tags"
                                                    @if(old('tag_ids', $post->tag_ids))
                                                    :tag-ids="{{ old('tag_ids', $post->tag_ids) }}"
                                                    @endif
                                                ></multi-select-component>
                                            </div>
                                            <div class="form-group" title="文章专题">
                                                <single-select-component
                                                    field-name = "topic_id"
                                                    :options = "topics"
                                                    :is-taggable = "true"
                                                    @if(old('topic_id', $post->topic_id))
                                                    :id = "{{ old('topic_id', $post->topic_id) }}"
                                                    @endif
                                                    :place-holder-and-labels="placeHolderAndLabelsForTopic"
                                                >
                                                </single-select-component>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroup-sizing-default" style="color: #adadad; background: transparent">专题文章排序</span>
                                                    </div>
                                                    <input type="number" class="form-control" min="1" name="sort" value="{{ old('sort', $post->sort) }}" aria-label="Sizing example input"
                                                           aria-describedby="inputGroup-sizing-default" placeholder="仅在指定文章专题时有效">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="well well-sm">
                            <input type="hidden" name="is_show" :value="isShow">
                            <button class="btn btn-success" @click.prevent="submitForm(1)">
                                <i class="far fa-send mr-2" aria-hidden="true"></i>
                                发布文章
                            </button>
                            &nbsp;&nbsp;or&nbsp;&nbsp;
                            <button class="btn btn-secondary" @click.prevent="submitForm(2)">
                                <i class="far fa-save mr-2" aria-hidden="true"></i>
                                保存草稿
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
                postBody: {!! json_encode(old('body', $post->body)) !!} || '',
                tags: {!! json_encode($tags) !!},
                categories: {!! json_encode($categories) !!},
                topics: {!! json_encode($topics) !!},
                collapse: true,
                placeHolderAndLabelsForTopic: {
                    placeholder: "请选择文章专题（选填，可选择，可直接输入）",
                    selectLabel: "按 Enter 选择",
                    tagPlaceholder: "按 Enter 创建"
                },
                isShow: {{ $post->is_show ?? 0 }},
            },
            methods: {
                submitForm(type) {
                    // 发布文章
                    if(type == 1) {
                        this.isShow = 1;
                        // 保存草稿（文章不显示）
                    } else {
                        this.isShow = 0;
                    }
                    this.$nextTick(() => {
                        this.$refs.form.submit();
                    })
                }
            }
        })
    </script>
@endsection

