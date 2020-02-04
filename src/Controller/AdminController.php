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
}