<?php
namespace Areuka\Controller;

use Areuka\App\DB;

class AdminController extends MasterController {
    /**
     * 스폰서 관리
     */
    function sponsorPage(){
        $sponsors = DB::fetchAll("SELECT * FROM sponsors ORDER BY donation DESC");

        $this->view("admin-sponsor", ["sponsors" => $sponsors]);
    }
    function addSponsor(){
        checkUp();
        extract($_POST);

        // 데이터 검사
        if($donation % 10000 !== 0) back("후원은 만원 단위로만 가능합니다.");
        if($donation < 1000000) back("후원은 100만원 이상 가능합니다.");
        

        // 이미지 검사
        $image = $_FILES['sponsor_logo'];

        if(!$image) back("로고 파일을 첨부해 주세요.");
        
        $ext = strtolower( substr($image['name'], -3) );
        if(strncmp($image['type'], "image", 5)) back("올바른 형태의 이미지 파일이 아닙니다..");

        // 이미지 업로드
        
        $basePath = IMAGE.DS."sponsors";
        $filename = random_varchar(50). "." .$ext;
        while(is_file($basePath.DS.$filename)) $filename = random_varchar(50). "." .$ext;
        
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