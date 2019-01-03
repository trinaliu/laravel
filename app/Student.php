<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //与模型关联的数据表
    protected $table = 'student';

    //设置主键
    protected $primaryKey = 'id';

    //模型的日期字段的存储格式
    protected $dateFormat = 'U';

    //设置允许批量赋值字段
    protected $fillable = ['name', 'age'];
}
