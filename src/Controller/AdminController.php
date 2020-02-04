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
        $result = ["success" => false, "message" => "데이터를 삭제할 수 없었습니다..."];

        if($find && DB::query("DELETE FROM sponsors WHERE id = ?", [$id])) {
            $result['success'] = true;
            $result['message'] = "데이터가 삭제되었습니다.";
        }

        return json_response($result);
    }


    /**
     * 공식 상영작 관리
     */
    function officialPage(){
        $this->view("official");
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
            // DB::query("INSERT INTO");
        }
    }
}