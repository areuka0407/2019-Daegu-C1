 <!-- 비쥬얼 영역 -->
 <div id="visual" class="sub">
        <div>
            <h5>
                <span class="home">BIFF 2020</span>
                <i class="right-icon white"></i>
                Admin Login
            </h5>
            <h3>관리자 로그인</h3>
        </div>
    </div>
    <!-- 로그인 영역 -->
    <div id="login">
        <div class="container padding">
            <div class="section-title">
                <div class="behind">L</div>
                <h1>Admin <span>LOGIN</span></h1>
            </div>
            <div class="col-md-5 col-sm-12 mx-auto">
                <form method="post">
                    <div class="form-group">
                        <label for="user_id">아이디</label>
                        <input type="text" id="user_id" name="user_id" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">비밀번호</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <button class="btn btn-dark px-5 py-2">로그인</button>
                        <div>
                            <label for="remember" class="d-inline mb-0">아이디 저장</label>
                            <input type="checkbox" id="remember" name="remember" hidden>
                            <label for="remember" class="check-box ml-3"></label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- SCRIPT -->
    <script defer>
        window.addEventListener("load", function(){
            let form = document.querySelector("#login form");
            let message = form.querySelector(".help-message");

            const $user_id = $("#user_id")
            const $password = $("#password");

            const inputs = [
                $user_id,
                $password,
            ];

            const errors = {
                user_id: "아이디를 입력해주세요",
                password: "비밀번호를 입력해주세요."
            };

            const final = () => {
                let result = $user_id.value.trim() === "" && $password.value.trim() === "";
                if(result) toast("아이디 및 비밀번호를 입력주세요.");
                return !result;
            };

            const v = new Validator({form, inputs, errors, final});
            v.start();
        });
    </script>