@extends('layouts.app')
@section('title','关于')
@section('content')
    @if(!empty($siteConfigs['about']))
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 offset-lg-1 offset-md-1">
                <div class="card ">
                    <div class="card-body">
                        <div class="post-body markdown-body mt-4 mb-4">
                            {!! parsedown($siteConfigs['about']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <h1>关于页</h1>
    @endif
@stop
