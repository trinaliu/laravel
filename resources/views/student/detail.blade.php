@extends('layouts.layout')

@section('title', '学生详情')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">学生详情</h3>
        </div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <td>{{ $student->id }}</td>
            </tr>
            <tr>
                <th>姓名</th>
                <td>{{ $student->name }}</td>
            </tr>
            <tr>
                <th>年龄</th>
                <td>{{ $student->age }}</td>
            </tr>
            <tr>
                <th>性别</th>
                <td>{{ $student->handleSex($student->sex) }}</td>
            </tr>
            <tr>
                <th>添加日期</th>
                <td>{{ $student->created_at }}</td>
            </tr>
            <tr>
                <th>最后修改</th>
                <td>{{ $student->updated_at }}</td>
            </tr>
        </table>
    </div>
@endsection