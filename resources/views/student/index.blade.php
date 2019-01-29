@extends('layouts.layout')

@section('title', '学生列表')

@section('content')
    {{--成功提示--}}
    @if(session()->has('success'))
        @component('alert.success')
            @slot('title')
                成功！
            @endslot
            操作成功提示。
        @endcomponent
    @endif
    @if(session()->has('error'))
        @component('alert.danger')
            @slot('title')
                失败！
            @endslot
            操作失败。
        @endcomponent
    @endif
    {{--列表--}}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">学生列表</h3>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>姓名</th>
                <th>年龄</th>
                <th>性别</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->age }}</td>
                <td>{{ $student->handleSex($student->sex) }}</td>
                <td>
                    <a href="{{ url('student/detail', ['id' => $student->id]) }}">详情</a>
                    <a href="{{ url('student/update', ['id' => $student->id]) }}">修改</a>
                    <a href="{{ url('student/delete', ['id' => $student->id]) }}">删除</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{--分页--}}
    {{--<nav aria-label="Page navigation">
        <ul class="pager">
            <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> Older</a></li>
            <li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li>
        </ul>
    </nav>--}}
    <div class="pull-right">
        {{$students->links()}}
    </div>
@endsection