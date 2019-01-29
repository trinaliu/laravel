<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Student extends Model
{
    //定义sex常量
    const UNKNOWN = 10;
    const MAN = 20;
    const WOMAN = 30;

    //与模型关联的数据表
    protected $table = 'student';

    //设置主键
    protected $primaryKey = 'id';

    //模型的日期字段的存储格式
    protected $dateFormat = 'U';

    //设置允许批量赋值字段
    //protected $fillable = ['name', 'age'];

    //设置禁止批量赋值字段
    protected $guarded = [];

    //规则
    public static function rules($request)
    {
        $id = $request->route('id');
        return [
            'name' => ['required', 'string', Rule::unique('student')->ignore($id), 'max:255'],
            'age' => 'required|integer',
            'sex' => ['required', Rule::in([Student::UNKNOWN, Student::MAN, Student::WOMAN])]
        ];
    }

    //错误消息
    public static function messages()
    {
        return [
            'required' => ':attribute不能为空',
            'integer' => ':attribute必须为整数',
            'string' => ':attribute必须为字符串',
            'unique' => '该:attribute已被使用',
            'max' => ':attribute的长度不能超过：max',
            'in' => ':attribute必须是以下值之一：:values'
        ];
    }

    //属性名称
    public static function attributes()
    {
        return [
            'name' => '姓名',
            'age' => '年龄',
            'sex' => '性别',
        ];
    }

    /**
     * 性别处理
     * @param null $index
     * @return array|mixed
     * user: trina
     */
    public function handleSex($index = null)
    {
        $data = [
            self::UNKNOWN => '未知',
            self::MAN => '男',
            self::WOMAN => '女',
        ];
        //获取指定的值
        if ($index) {
            $data = $data[$index];
        }

        return $data;
    }
}
