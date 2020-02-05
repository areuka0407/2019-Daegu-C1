<?php
namespace Areuka\Controller;

use Areuka\App\DB;
use Areuka\App\Validator;

class MainController extends MasterController {

    function indexPage(){
        $data = [];
        $data['sponsorList'] = DB::fetchAll("SELECT * FROM sponsors ORDER BY donation DESC");

        $this->view("index", $data);
    }

    function aboutPage(){
        $this->view("about");
    }

    /**
     * 상영작 요청 페이지
     */

    function requestPage(){
        $this->view("request");
    }
    
    function addRequest(){
        extract($_POST);

        $inputs = array_merge($_POST, $_FILES);

        $rules = [
            "business_id" => "business_id",
            "ceo_email" => "email",
            "ceo_phone" => "phone",
            "running_time" => "number",
            "movie_poster" => "image",
        ];

        $errors = [
            "business_id" => "사업자등록번호를 입력하세요.",
            "ceo_email" => "영화사 이메일을 입력하세요.",
            "ceo_phone" => "영화사 대표 전화번호를 입력하세요.",
            "running_time" => "러닝 타임을 입력하세요.",
            "movie_poster" => "영화 포스터를 첨부하세요.",
            "movie_name" => "영화명을 입력하세요.",
            "company_name" => "회사명을 입력하세요.",
            "director_name" => "감독명을 입력하세요.",
            "business_id.business_id" => "올바른 형태의 사업자등록번호가 아닙니다.",
            "ceo_email.email" => "올바른 형태의 이메일이 아닙니다.",
            "ceo_phone.phone" => "올바른 형태의 전화번호가 아닙니다.",
            "running_time.number" => "올바른 형태의 러닝타임이 아닙니다.",
            "movie_poster.image" => "올바른 형태의 이미지 파일이 아닙니다."
        ];
    
        $validator = new Validator($inputs, $rules, $errors);
        $validator->check()->execute();
        
        $poster = $_FILES['movie_poster'];
        $ext = substr($poster['name'], -3);
        $savePath = IMAGE.DS."posters";
        do {
            $saveName = random_varchar(50) .".". $ext;
        } while(is_file($savePath.DS.$saveName));

        if(move_uploaded_file($poster['tmp_name'], $savePath.DS.$saveName)){
            $param = [$movie_name, $company_name, $ceo_phone, $ceo_email, $business_id, $director_name, $running_time, $saveName];
            DB::query("INSERT INTO requests(movie_name, company_name, ceo_phone, ceo_email, business_id, director_name, running_time, poster_filename) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", $param);
            back("요청이 완료되었습니다.", "bg-success");
        }
        else back("파일 업로드에 실패했습니다.. ");
    }

    /**
     * 상영작 예매
     */

    function reservePage(){
        $data['cinemaList'] = DB::fetchAll("SELECT * FROM cinemas");
        $this->view("reserve", $data); 
    }

    function addReserve(){
        

        $rules = [
            "seat_id" => "seat",
            "user_phone" => "phone"
        ];

        $errors = [
            "seat_id" => "좌석을 선택해 주세요.",
            "seat_id.seat" => "좌석의 양식이 일치하지 않습니다.",
            "movie_id" => "영화를 선택해 주세요.",
            "cinema_id" => "영화관을 선택해 주세요.",
            "user_name" => "이름을 입력해 주세요.",
            "user_phone" => "전화 번호를 입력해 주세요.",
            "user_phone.phone" => "올바른 형태의 휴대폰 번호가 아닙니다.",
            "password" => "비밀번호를 입력해 주세요.",
            "passconf" => "비밀번호 확인을 입력해 주세요."
        ];

        $validator = new Validator($_POST, $rules, $errors);
        $validator->check();

        $message = [];
        extract($_POST);
        // dd($_POST);

        if($password !== $passconf) $mesage[] = "비밀번호와 비밀번호 확인이 일치하지 않습니다.";
        $validator->execute(...$message);

        DB::query("INSERT INTO seats(movie_id, seat_name, user_name, password, user_phone) VALUES (?, ?, ?, ?, ?)", [$movie_id, $seat_id, $user_name, $password, $user_phone]);

        redirect("/reserve", "예약이 완료되었습니다.", "bg-success");
    }

    function getReserveList(){
        $id = isset($_POST['movie_id']) ? $_POST['movie_id'] : "";
        $list = DB::fetchAll("SELECT * FROM seats WHERE movie_id = ?", [$id]);
        header("Content-Type: application/json");
        echo json_encode($list, JSON_UNESCAPED_UNICODE);
    }

    function getMovieListByCinema($cinema_id){
        $officials = DB::fetchAll(  "SELECT concat('officials.', C.id) id, movie_name, start_time, end_time, C.name cinema_name
                                    FROM officials O
                                    LEFT JOIN cinemas C ON C.id = O.cinema_id
                                    WHERE start_time IS NOT NULL AND end_time IS NOT NULL AND C.name IS NOT NULL AND cinema_id = ?", [$cinema_id]);
                                    
        $requests = DB::fetchAll(  "SELECT concat('requests', C.id) id, movie_name, start_time, end_time, C.name cinema_name
                                    FROM requests O
                                    LEFT JOIN cinemas C ON C.id = O.cinema_id
                                    WHERE start_time IS NOT NULL AND end_time IS NOT NULL AND C.name IS NOT NULL AND cinema_id = ?", [$cinema_id]);
        header("Content-type: application/json");
        echo json_encode(array_merge($officials, $requests));
    }


    /**
     * 로그인 관리
     */
    function loginPage(){
        if(isLogin()) redirect("/admin/sponsor");
        else $this->view("login");
    }
    function login(){
        extract($_POST);
        $ADMIN = (object)[
            "user_id" => "admin",
            "password" => "1234"
        ];
        
        
        // 값 검사
        $errors = [
            "user_id" => "아이디를 입력해주세요",
            "password" => "비밀번호를 입력해주세요"
        ];

        $validator = new Validator($_POST, [], $errors);
        $validator->check();
        $user_id === "" && $password === "" ? $validator->execute("아이디 및 비밀번호를 입력해주세요.") : $validator->execute();
        
        
        // 아이디 인증
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
