<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//基础路由
//指定请求方式路由
Route::get('test', function() {
    return 'Hello Word';
});

//多请求路由
//注册多个路由match(请求方式, 路由名称, 闭包)， any(路由名称, 闭包)相应所有请求
Route::match(['get', 'post'], 'test-match', function() {
    return 'Multi Match';
});
Route::any('test-any', function() {
    return 'Multi Any';
});

//路由参数
Route::get('test-param/{id}', function($id) {
    return 'Test Param ID: ' . $id;
});
//可选参数
Route::get('test-optional/{name?}', function($name = 'Kitty') {
    return 'Test Optional Name: ' . $name;
});
//正则
Route::get('test-regular/{id}', function($id) {
    return 'Test Regular ID: ' . $id;
})->where('id', '[0-9]+');
//命名路由
Route::get('user/profile/{id}', function($id) {
    return 'Information' . $id;
})->name('profile');
Route::get('test/name', function() {
    return \route('profile', ['id' => 2]);
});
//重定向路由（redirect）
//视图路由（view(url, view name, array[])）
Route::view('/welcome', 'welcome');
//路由参数放在{}中，只能是字母，字母之间不能用-只能用_；按照顺序一次注入
//可选参数为参数后面用？标记，但是路由一定要有默认值
//参数是可以用正则约束的，链式调用where（name， rule），多个数组
//参数是还可以全局约束，在RouteServiceProvider的boot方法使用pattern
//命名路由，链式调用name
//为命名路由生成链接route('profile', ['id' => 1])
//检查当前路由named
//路由组route::group
Route::group(['prefix' => 'user'], function () {
    Route::get('create', function() {
        return "Create";
    });
    Route::get('delete', function() {
        return 'Delete';
    });
});
//中间件route::middleware
//命名空间route::namespace
//子域名路由route::domain
//路由前缀route::prefix
Route::prefix('customer')->group(function () {
    Route::get('create', function() {
        return "Create For Customer";
    });
    Route::get('delete', function() {
        return 'Delete For Customer';
    });
});
//访问当前路由, Route Facade 上的 current、currentRouteName 和 currentRouteAction 方法来访问处理传入请求的路由的信息

//控制器
Route::prefix('member')->group(function() {
    Route::get('info/{id}', 'MemberController@info')->where('id', '[0-9]+');
});

Route::prefix('student')->group(function() {
    Route::get('db', 'StudentController@db');
    Route::get('query-builder', 'StudentController@queryBuilder');
    Route::get('eloquent', 'StudentController@eloquent');
    Route::get('index', 'StudentController@index');
    Route::middleware('web')->group(function() {
        Route::get('view/{id}', 'StudentController@view');
        Route::get('session', 'StudentController@session');
    });
    Route::any('response', 'StudentController@response');
    Route::get('activity', 'StudentController@activity');
    Route::middleware('activity')->group(function () {
        Route::get('have-in-hand', 'StudentController@haveInHand');
        Route::get('have-in-hand2', 'StudentController@haveInHand2');
    });
});
