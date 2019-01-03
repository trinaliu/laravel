@extends('layouts.app')

@section('title', 'Student')

@section('sidebar')
    @parent
    <p>侧边栏</p>
@endsection

@section('content')
    @component('alert', ['value' => 'Test'])
        @slot('title')
            @if(session('status'))
                {{session('status')}}
            @else
                Forbidden
            @endif
        @endslot

        你没有权限访问这个资源！
    @endcomponent
    <p>这是主体内容。</p>

@endsection