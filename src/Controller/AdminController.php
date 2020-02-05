<?php
namespace Areuka\Controller;

use Areuka\App\DB;
use Areuka\App\Validator;

class AdminController extends MasterController {
    /**
     * 스폰서 관리
     */
    function sponsorPage(){
        $sponsors = DB::fetchAll("SELECT * FROM sponsors ORDER BY donation DESC");

        $this->view("admin-sponsor", ["sponsors" => $sponsors]);
    }
    function addSponsor(){
        extract($_POST);

        $inputs = array_merge($_POST, $_FILES);

        $rules = [
            "sponsor_logo" => "image",
            "donation" => "number, donation_unit, donation_min"
        ];

        $errors = [
            "sponsor_name" => "스폰서 명을 입력하세요",
            "sponsor_logo" => "스폰서 로고를 첨부하세요.",
            "sponsor_logo.image" => "올바른 형태의 이미지 파일이 아닙니다.",
            "donation" => "후원할 금액을 입력하세요.",
            "donation.number" => "올바른 형태의 금액이 아닙니다.",
            "donation.donation_unit" => "후원은 만원 단위로만 가능합니다.",
            "donation.donation_min" => "후원은 100만원 이상 가능합니다.",
        ];

        $validator = new Validator($inputs, $rules, $errors);
        $validator->check()->execute();
        
        // 이미지 업로드
        
        $ext = strtolower( substr($image['name'], -3) );
        $basePath = IMAGE.DS."sponsors";
        do {
            $filename = random_varchar(50). "." .$ext;
        } while(is_file($basePath.DS.$filename));
        
        // 이미지 업로드가 성공한다면 삽입
        if(move_uploaded_file($image['tmp_name'], $basePath.DS.$filename)){
            DB::query("INSERT INTO sponsors(sponsor_name, logo_filename, donation) VALUES (?, ?, ?)", [$sponsor_name, $filename, $donation]);
            redirect("/admin/sponsor", "스폰서 등록이 완료되었습니다.", "bg-info");
        }
        else back("이미지 업로드에 실패했습니다.");
    }

    function removeSponsor($id){
        $find = DB::find("sponsors", $id);

        if($find && DB::query("DELETE FROM sponsors WHERE id = ?", [$id])) {
            json_response("데이터가 삭제되었습니다.", true);
        }
        else json_response("데이터를 삭제할 수 없었습니다...", false);
    }


    /**
     * 공식 상영작 관리
     */
    function officialPage(){
        $data['officials'] = DB::fetchAll("SELECT * FROM officials");
        $this->view("admin-official", $data);
    }

    function addOfficial(){
        extract($_POST);

        $inputs = array_merge($_POST, $_FILES);
        $rules = [
            "movie_poster" => "image",
            "running_time" => "number"
        ];
        $errors = [
            "movie_name" => "영화 제목을 입력하세요.",
            "movie_poster" => "영화 포스터를 첨부하세요.",
            "movie_poster.image" => "올바른 형태의 이미지 파일이 아닙니다.",
            "director" => "감독명을 입력하세요.",
            "running_time" => "러닝타임을 입력하세요.",
            "running_time.number" => "올바른 형태의 러닝타임이 아닙니다."
        ];

        $validator = new Validator($inputs, $rules, $errors);
        $validator->check()->execute();

        $poster = $_FILES['movie_poster'];
        $ext = substr($poster['name'], -3);
        $savePath = IMAGE.DS."posters";
        do {
            $saveName = random_varchar(50).".".$ext;
        } while(is_file($savePath.DS.$saveName));
        
        if(move_uploaded_file($poster['tmp_name'], $savePath.DS.$saveName)){
            $param = [$movie_name, $director, $running_time, $saveName];
            DB::query("INSERT INTO officials(movie_name, director_name, running_time, poster_filename) VALUES (?, ?, ?, ?)", $param);
            redirect("/admin/official", "공식 상영작 등록이 완료되었습니다.", "bg-success");
        }
        else back("이미지 업로드에 실패했습니다...");
    }

    function removeOfficial($id){
        $find = DB::find("officials", $id);
        if(!$find) return json_response("상영작을 찾을 수 없습니다.", false);
        DB::query("DELETE FROM officials WHERE id = ?", [$id]);
        return json_response("해당 상영작이 삭제되었습니다.", true);
    }


    /**
     * 요청작 관리
     */
    function requestPage(){
        $param['requests'] = DB::fetchAll("SELECT * FROM requests");
        $this->view("admin-request", $param);
    }

    // 승인
    function applyRequest($id){
        $find = DB::find("requests", $id);
        if(!$find) return back("해당 요청작을 찾을 수 없었습니다...", false);
        DB::query("UPDATE requests SET status = '승인'");

        return redirect("/admin/request", "해당 요청작의 상태가 '승인'(으)로 변경되었습니다.", "bg-primary");
    }   

    //반려
    function returnRequest($id){
        $find = DB::find("requests", $id);
        if(!$find) return back("해당 요청작을 찾을 수 없었습니다...", false);
        DB::query("UPDATE requests SET status = '반려'");

        return redirect("/admin/request", "해당 요청작의 상태가 '반려'(으)로 변경되었습니다.");
    }


    /**
     * 상영시간표
     */
    function timetablePage(){
        $data['officials'] = DB::fetchAll("SELECT * FROM officials WHERE start_time IS NULL");
        $data['requests'] = DB::fetchAll("SELECT * FROM requests WHERE start_time IS NULL AND status = '승인'");
        $this->view("admin-timetable", $data);
    }

    /**
     * 영화관 관리
     */

    function cinemaPage(){
        $this->view("admin-cinema");
    }

    function addCinema(){
        extract($_POST);
        
        $inputs = array_merge($_POST, $_FILES);
        $rules = [ "seat_file" => "seat_file" ];
        $errors = [
            "cinema_name" => "영화관 명을 입력하세요.",
            "seat_file" => "좌석 파일을 첨부하세요.",
            "seat_file.seat_file" => "잘못된 영화관 좌석 파일입니다."
        ];

        $validator = new Validator($inputs, $rules, $errors);
        $validator->check()->execute();
        
        $seatFile = $_FILES['seat_file'];
        $seatMap = file_get_contents($seatFile['tmp_name']);

        DB::query("INSERT INTO cinemas(name, seat_map) VALUES (?, ?)", [$cinema_name, $seatMap]);
        redirect("/admin/cinema", "영화관이 등록되었습니다.", "bg-success");
    }

    function removeCinema($id){
        
    }
}