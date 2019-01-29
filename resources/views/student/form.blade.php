<form class="form-horizontal" role="form" method="post" action="">
    {{ csrf_field() }}
    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
        <label class="control-label col-sm-2">姓名</label>
        <div class="col-sm-5">
            <input type="text" name="name" value="{{ old('name') ? old('name') : $student->name }}" class="form-control">
        </div>
        <span class="help-block col-sm-5">{{ $errors->first('name') }}</span>
    </div>
    <div class="form-group {{ $errors->has('age') ? 'has-error' : '' }}">
        <label class="control-label col-sm-2">年龄</label>
        <div class="col-sm-5">
            <input type="number" name="age" value="{{ old('age') ? old('age') : $student->age }}" class="form-control">
        </div>
        <span class="help-block col-sm-5">{{ $errors->first('age') }}</span>
    </div>
    <div class="form-group {{ $errors->has('sex') ? 'has-error' : '' }}">
        <label class="control-label col-sm-2">性别</label>
        <div class="col-sm-5">
            @foreach($student->handleSex() as $index => $value)
                <label class="radio-inline">
                    <input type="radio" name="sex" value="{{$index}}"
                            {{ old('sex') == $index || (!old('sex') && !isset($student->sex) && $index == \App\Student::UNKNOWN || (!old('sex') && isset($student->sex) && $student->sex == $index)) ? 'checked' : ''}}
                    > {{$value}}
                </label>
            @endforeach
        </div>
        <span class="help-block col-sm-5">{{ $errors->first('sex') }}</span>
    </div>
    <div class="form-group">
        <di class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">提交</button>
        </di>
    </div>
</form>