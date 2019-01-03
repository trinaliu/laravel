<?php
/**
 * Created by PhpStorm.
 * user: trina
 * Date: 18-12-28
 * Time: 下午4:01
 */
namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * 原生语句，DB facade
     * user: trina
     */
    public function db()
    {
        //插入语句,返回boolean
        $bool = DB::insert(
            'insert into student (name, age, sex, created_at, updated_at) values (?, ?, ?, ?, ?)',
            ['Kitty', 20, 30, time(), time()]
        );
        var_dump($bool);
        //更新语句，返回的是影响行数
        $numbers = DB::update('update student set age = ? where id = ?', [33, 1]);
        var_dump($numbers);
        //查询语句
        $students = DB::select('select * from student where id = ?', [1]);
        var_dump($students);
        //删除语句，返回的是影响行数
        $numbers = DB::delete('delete from student where id = ?', [5]);
        var_dump($numbers);
    }

    /**
     * 查询构造器
     * user: trina
     */
    public function queryBuilder()
    {
        //插入语句， 返回boolean[插入多条]
        $bool = DB::table('student')->insert([
            ['name' => 'Joe', 'age' => 5, 'sex' => 20, 'created_at' => time(), 'updated_at' => time()],
            ['name' => 'Grace', 'age' => 3, 'sex' => 30, 'created_at' => time(), 'updated_at' => time()]
        ]);
        var_dump($bool);
        //插入语句， 插入返回自增id[插入一条]
        $id = DB::table('student')->insertGetId(['name' => 'Lida', 'age' => 15, 'sex' => 30, 'created_at' => time(), 'updated_at' => time()]);
        var_dump($id);

        //更新语句,返回的是影响行数；记住一定要先写where，再设置更新数据，否则会更新所有数据
        $numbers = DB::table('student')->where('id', 8)->update(['age' => 18]);
        var_dump($numbers);
        //自增 & 自减（increment/decrement），返回影响行数
        $numbers = DB::table('student')->increment('age');//全部加1
        var_dump($numbers);
        $numbers = DB::table('student')->decrement('age', 2);//指定全部减2
        var_dump($numbers);
        $numbers = DB::table('student')->where('age', 15)->increment('age', 1, ['sex' => 20]);//在操作过程中指定要更新的字段
        var_dump($numbers);

        //删除数据，返回影响行数
        $number = DB::table('student')->where('id', 8)->delete();
        var_dump($number);
        $number = DB::table('student')->where('id', '>',  5)->delete();
        var_dump($number);
        //清空表，不返回任何东西
        DB::table('student')->truncate();//相当于DB::table('student')->delete()，但是delete会返回影响行数

        //查询语句
        //get()，返回所有数据
        $student = DB::table('student')->get();
        var_dump($student);
        //first(),返回数据表的第一条数据
        $student = DB::table('student')->first();
        var_dump($student);

        //WHERE语句
        //where()
        $student = DB::table('student')->where([
            ['age', '>', 10],
            ['sex', '=', 20]
        ])->get();
        var_dump($student);
        //orWhere()
        $student = DB::table('student')->where('age', '>=', 20)->orWhere('name', 'Joe')->get();
        var_dump($student);
        $student = DB::table('student')->where('name', 'like', '%e')->get();//%:任意，_:单个
        var_dump($student);
        //[whereBetween/whereNotBetween],[whereIn / whereNotIn],[whereNull / whereNotNull]
        $student = DB::table('student')->whereIn('age', [3, 5])->get();
        var_dump($student);
        //[whereDate / whereMonth / whereDay / whereYear / whereTime]
        $student = DB::table('student')->whereDate('created_at', '2018-12-29')->get();
        var_dump($student);
        //whereColumn:用于两个字段值的比较
        $student = DB::table('student')->whereColumn('created_at', 'updated_at')->get();
        var_dump($student);
        //参数分组，例如:select * from users where name = 'Joe' or (sex = 20 and age <= 5)
        $students = DB::table('student')->where('name', 'Joe')->orWhere(function($query) {
            $query->where([
                ['sex', '=', 30],
                ['age', '<=', 5],
            ]);
        })->get();
        //Where Exists 语句/JSON where 语句
        var_dump($students);

        //pluck,获取一列值, 也可以在返回的集合中指定字段的自定义键值
        $name = DB::table('student')->pluck('name', 'id');
        var_dump($name);
        //select()
        //chunk, 结果分块
        DB::table('student')->orderBy('id')->chunk(2, function ($student) {
            var_dump($student);
        });
        //聚合,count、 max、 min、 avg 和 sum
        $students = DB::table('student')->count();
        var_dump($students);
        //join
        //Ordering, Grouping, Limit, & Offset
        $student = DB::table('student')->select('sex')->groupBy('sex')->get();
        var_dump($student);
    }

    /**
     * Eloquent 常用
     * user: trina
     */
    public function eloquent()
    {
        //检举多个模型all()/get()
        $students = Student::all();
        //检举单个模型find()[只能用来主键查询]/first()
        $student = Student::find(1);
        $student = Student::where('name', 'Joe')->first();
        //「找不到」异常findOrFail[只能用来主键查询]/firstOrFail
        //$student = Student::findOrFail(12);
        $student = Student::where('name', 'Harry')->firstOrFail();

        //插入 & 更新模型，save()
        /*$student = new Student();
        $student->name = 'Tina';
        $student->age = 27;
        $student->sex = 30;
        $student->save();

        $model = Student::find($student->id);
        $model->age = 28;
        $model->save();*/

        /*//批量赋值，需要在模型中设置fillable[允许批量字段] 或 guarded[禁止批量字段] 的属性, 当guarded为[]空数组时，表示所有字段都可批量赋值
        $student = Student::create(['name' => 'Moli', 'age' => 20]);
        $student = (new Student())->fill(['name' => 'Moli', 'age' => 20]);*/

        /*//firstOrCreate(首先查找，没有则创建，有则返回数据)/ firstOrNew（首先查找，没有则实例化，创建则需要调用save（），有则返回数据）
        $student = Student::firstOrCreate(['name' => 'Channel'], ['age' => 20]);
        $student = Student::firstOrNew(['name' => 'HaiLi'], ['age' => 24]);
        $student->save();*/

        /*//updateOrCreate（条件， 更新字段）(首先查找，没有则创建，有则更新数据返回数据)
        $student = Student::updateOrCreate(
            ['name' => 'XiaoLie'],
            ['age' => 32]
        );*/

        /*//批量更新数据
        $numbers = Student::where('age', '<', '10')->update(['age' => 15]);

        dd($numbers);*/
    }

    /**
     * 布局测试
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * user: trina
     */
    public function index()
    {
        return view('student.index');
    }

    /**
     * 请求和session
     * @param Request $request
     * @param $id
     * user: trina
     */
    public function view(Request $request, $id)
    {
        //input()第一个参数是名字，第二个是默认值，input 方法可以从整个请求中获取输入数据（包括查询字符串），而 query 方法可以只从查询字符串中获取输入数据
        $name = $request->input('name');
        $sex = $request->input('sex', 'boy');

        //has()判断是否存在/filled()判断是否存在且不为空
        $param = '无参';
        if ($request->has('sex')) {
            $param = $request->input('sex');
        }

        //all()获取所有参数数据
        $data = $request->all();

        //method()获取请求方法/isMethod()判断请求类型和指定的是否一致/ajax()判断是否为ajax请求
        $method = $request->method();
        $bool = $request->isMethod('POST');

        //path()获取请求的路径信息/is()判断请求路径和指定的是否一致
        $path = $request->path();
        $bool = $request->is('student/*');

        //获取请求url：url 方法返回不带有查询字符串的 URL，而 fullUrl 方法的返回值包含查询字符串;查询字符串就是路径后面带的参数
        $url = $request->url();
        $fullUrl = $request->fullUrl();

        //session
        //通过Request设置session，put()赋值/get()获取值
        $request->session()->put(['key' => 'test session', 'key1' => 'test session1']);

        //全局辅助函数 Session
        //session(['key' => 'test session', 'key1' => 'test session1']);

    }

    /**
     * session
     * @param Request $request
     * user: trina
     */
    public function session(Request $request)
    {
        //$key = $request->session()->get('key');
        //$key = session('key', 'default');
        //$key = $request->session()->all();
        //has()表示必须有值，而exists()为null也可以

        //只用一次，用完就删除


        $request->session()->flush();

        $key = $request->session()->all();
        var_dump($key);
    }

    /**
     * 响应
     * @return \Illuminate\Http\RedirectResponse
     * user: trina
     */
    public function response()
    {
        //响应json
        //response()->json(['status' => true, 'message' => 'success', 'data' => ['name' => 'Kitty']]);

        //基础重定向
        //redirect('student/index');
        //重定向到之前的位置back()，请确保调用 back 函数的路由使用 web 中间件组或所有 Session 中间件;例如：提交表单验证不通过时，返回之前位置
        //back()->withInput();
        //重定向至命名路由route()第二个参数来传递路由参数
        //redirect()->route('profile', ['id' => 1]);
        //通过 Eloquent 模型填充参数?
        //重定向至控制器行为action()第二个参数来传递路由参数
        //return redirect()->action('StudentController@index');
        //重定向并使用闪存的 Session 数据with()
        return redirect('student/index')->with(['status' => 'success']);
    }

    /**
     * 中间件
     * @return string
     * user: trina
     */
    //活动的宣传页面
    public function activity()
    {
        return '活动快要开始了， 敬请期待';
    }

    public function haveInHand()
    {
        return '活动进行中，谢谢你的参与';
    }

    public function haveInHand2()
    {
        return '活动进行中，谢谢你的参与2';
    }
}