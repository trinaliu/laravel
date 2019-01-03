<?php
/**
 * Created by PhpStorm.
 * user: trina
 * Date: 18-12-28
 * Time: 下午2:34
 */
namespace App\Http\Controllers;

class MemberController
{
    public function info($id)
    {
        return view('member/info', ['id' => $id]);
    }
}