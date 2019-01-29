@extends('layouts.layout')

@section('title', '编辑学生')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">编辑学生</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                @include('student.form')
            </div>
        </div>
    </div>
@endsection