<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        @section('style')
        @show

        <script src="/js/jquery-3.0.0.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        @section('script')
        @show
    </head>
    <body>
        {{--头部--}}
        <div class="jumbotron">
            <div class="container">
                <h1>轻松学会Laravel</h1>
                <p> - 玩转Laravel表单</p>
            </div>
        </div>
        {{--中间--}}
        <div class="container">
            <div class="row">
                {{--左边--}}
                <div class="col-sm-3">
                    <div class="list-group">
                        <a href="{{url('student/index')}}" class="list-group-item
                        {{\Illuminate\Support\Facades\URL::current() != url('student/create') ? 'active' : ''}}
                        ">学生列表</a>
                        <a href="{{url('student/create')}}" class="list-group-item
                        {{\Illuminate\Support\Facades\URL::current() == url('student/create') ? 'active' : ''}}
                        ">新增学生</a>
                    </div>
                </div>
                {{--右边--}}
                <div class="col-sm-9">
                    @section('content')
                    @show
                </div>
            </div>
        </div>
        {{--尾部--}}
        <div class="jumbotron" style="margin: 30px 0 0 0; /*position: absolute; bottom: 0; right: 0; left: 0;*/">
            <div class="container">
                <p> @2019 Laravel</p>
            </div>
        </div>
    </body>
</html>