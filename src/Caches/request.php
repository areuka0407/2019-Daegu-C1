<!-- 비쥬얼 영역 -->
<div id="visual" class="sub">
    <div>
        <h5>
            <span class="home">BIFF 2020</span>
            <i class="right-icon white"></i>
            Request Screen
        </h5>
        <h3>상영 요청</h3>
    </div>
</div>
<!-- 상영 등록 영역 -->
<div id="request-screen">
    <div class="container">
        <div class="padding">     
            <div class="section-title">
                <span class="behind">R</span>
                <h1>Request <span class="accent">FORM</span></h1>
            </div>
            <form id="request-screen-form" class="row" method="post" enctype="multipart/form-data">
                <div class="col-md-6 col-ms-12">
                    <div class="form-group">
                        <label for="movie_name">영화명</label>
                        <input type="text" id="movie_name" name="movie_name" class="form-control mt-1">
                    </div>
                    <div class="form-group">
                        <label for="ceo_phone">영화사 대표 전화번호</label>
                        <input type="text" id="ceo_phone" name="ceo_phone" class="form-control mt-1">
                    </div>
                    <div class="form-group">
                        <label for="director_name">감독명</label>
                        <input type="text" id="director_name" name="director_name" class="form-control mt-1">
                    </div>
                    <div class="form-group">
                        <label for="running_time">러닝 타임</label>
                        <input type="text" id="running_time" name="running_time" class="form-control mt-1">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="company_name">영화사명</label>
                        <input type="text" id="company_name" name="company_name" class="form-control mt-1">
                    </div>
                    <div class="form-group">
                        <label for="business_id">사업자 등록 번호</label>
                        <input type="text" id="business_id" name="business_id" class="form-control mt-1">
                    </div>
                    <div class="form-group">
                        <label for="ceo_email">영화사 대표 이메일</label>
                        <input type="text" id="ceo_email" name="ceo_email" class="form-control mt-1">
                    </div>
                    <div class="form-group">
                        <label for="movie_poster">영화 포스터</label>
                        <div class="custom-file mt-1">
                            <label for="movie_poster" class="custom-file-label"></label>
                            <input type="file" id="movie_poster" name="movie_poster" class="custom-file-input" accept="image/*">
                        </div>
                    </div>
                </div>
                <button class="btn btn-dark mt-5 px-5 py-2">상영 요청</button>
            </form>

        </div>
    </div>
</div>
<script defer>
    
    window.onload = function(){
        const form = $("#request-screen-form");

        const inputs = [
            $("#business_id"),
            $("#ceo_email"),
            $("#ceo_phone"),
            $("#running_time"),
            $("#movie_poster"),
            $("#movie_name"),
            $("#company_name"),
            $("#director_name")
        ];

        const rules =  {
            business_id: "business",
            ceo_email: "email",
            ceo_phone: "phone",
            running_time: "number",
            movie_poster: "image"
        };

        const errors = {
            business_id: "올바른 형태의 사업자등록번호가 아닙니다.",
            ceo_email: "올바른 형태의 이메일이 아닙니다.",
            ceo_phone: "올바른 형태의 전화번호가 아닙니다.",
            running_time: "올바른 형태의 러닝타임이 아닙니다.",
            movie_poster: "올바른 형태의 이미지 파일이 아닙니다.",
            movie_name: "영화 명을 입력해 주십시오.",
            company_name: "영화사 명을 입력해 주십시오.",
            director_name: "감독 명을 입력해 주십시오."
        };

        let v = new Validator({form, inputs, rules, errors});
        v.start();
    };
</script>