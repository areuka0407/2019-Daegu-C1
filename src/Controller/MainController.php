<?php
namespace Areuka\Controller;

use Areuka\App\DB;

class MainController extends MasterController {

    function indexPage(){
        $data = [];
        $data['sponsorList'] = DB::fetchAll("SELECT * FROM sponsors ORDER BY donation DESC");

        $this->view("index", $data);
    }

    /**
     * 로그인 관리
     */
    function loginPage(){
        if(isLogin()) redirect("/admin/sponsor");
        else $this->view("login");
    }
    function login(){
        $ADMIN = (object)[
            "user_id" => "admin",
            "password" => "1234"
        ];

        checkUp();
        extract($_POST);
        if($user_id !== $ADMIN->user_id) return back("일치하는 아이디를 찾을 수 없습니다.");
        if($password !== $ADMIN->password) return back("비밀번호가 일치하지 않습니다.");

        session()->set("login", true);
        return redirect("/", "로그인 되었습니다.", "bg-info");
    }

    function logout(){
        session()->unset("login");
        redirect("/", "로그아웃 되었습니다.", "bg-info");
    }
}
