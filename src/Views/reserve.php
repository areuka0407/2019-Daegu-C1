<div id="visual" class="sub">
        <div>
            <h5>
                <span class="home">BIFF 2020</span>
                <i class="right-icon white"></i>
                Reserve Screen
            </h5>
            <h3>상영작 예매</h3>
        </div>
    </div>
<!-- 상영관 예약 영역 -->
 <div id="reserve">
        <div class="container">
            <div class="padding">     
                <div class="section-title">
                    <span class="behind">R</span>
                    <h1>RESERVE <span class="accent">SCREEN</span></h1>
                </div>
                <div id="seat-map">
                    <div class="seat super-premium">1A</div>
                    <div class="seat super-premium reserved">2A</div>
                    <div class="seat super-premium reserved">3A</div>
                    <div class="seat super-premium">4A</div>
                    <div class="seat super-premium">5A</div>
                    <div class="seat super-premium reserved">6A</div>
                    <div class="seat super-premium">7A</div>
                    <div class="seat super-premium">8A</div>
                    <div class="seat premium">B1</div>
                    <div class="seat premium">B2</div>
                    <div class="seat premium">B3</div>
                    <div class="seat premium">B4</div>
                    <div class="seat premium">B5</div>
                    <div class="seat premium">B6</div>
                    <div class="seat premium">B7</div>
                    <div class="seat premium">B8</div>
                    <div class="seat">C1</div>
                    <div class="seat">C2</div>
                    <div class="seat">C3</div>
                    <div class="seat">C4</div>
                    <div class="seat">C5</div>
                    <div class="seat">C6</div>
                    <div class="seat">C7</div>
                    <div class="seat">C8</div>
                </div>
                <form id="reserve-form" method="post">
                    <input type="hidden" id="seat_id" name="seat_id">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="movie_id">영화</label>
                            <select name="movie_id" id="movie_id" class="form-control mt-2">
                                <option value="">영화를 선택하세요</option>
                                <option value="1">슈퍼맨</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cinema_id">영화관</label>
                            <select name="cinema_id" id="cinema_id" class="form-control mt-2">
                                <option value="">영화관를 선택하세요</option>
                                <option value="1">동네 CGV</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="user_name">이름</label>
                            <input type="text" id="user_name" name="user_name" class="form-control mt-2">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">비밀번호</label>
                            <input type="password" id="password" name="password" class="form-control mt-2">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="user_phone">전화 번호</label>
                            <input type="text" id="user_phone" name="user_phone" class="form-control mt-2">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="passconf">비밀번호 재확인</label>
                            <input type="password" id="passconf" name="passconf" class="form-control mt-2">
                        </div>
                    </div>

                    <button class="btn btn-dark mt-5 px-5 py-2">상영 요청</button>
                </form>

            </div>
        </div>
    </div>
    <script defer>
        window.onload = function(){
            const form = $("#reserve-form");
            const $seat_id = $("#seat_id");
            document.querySelectorAll("#seat-map .seat").forEach(seat => {
                /**
                 * 좌석 선택
                 */ 
                seat.addEventListener("click", e => {
                    if(seat.classList.contains("reserved")) return;

                    const seat_id = seat.innerText;

                    // class toggle
                    let selected = $("#seat-map .seat.selected");
                    selected && selected.classList.remove("selected");
                    seat.classList.add("selected");

                    // change value
                    $seat_id.value = seat_id;

                    // 좌석에 따라서 메세지 알림
                    let message;
                    if(seat.classList.contains("super-premium"))  message = `슈퍼 프리미엄 좌석(${seat_id})을 선택하셨습니다.`;
                    else if(seat.classList.contains("premium")) message = `프리미엄 좌석(${seat_id})을 선택하셨습니다.`;
                    else message = `일반 좌석(${seat_id})을 선택하셨습니다.`;
                    toast(message, "bg-dark");
                });
            });

            /**
             * Validator
             */

            const inputs = [
                $("#movie_id"),
                $("#cinema_id"),
                $("#user_name"),
                $("#user_phone"),
                $("#password"),
                $("#passconf")
            ];

            const rules = {
                user_phone: "phone",
            }

            const errors = {
                movie_id: "영화를 선택해 주세요.",
                cinema_id: "영화관을 선택해 주세요.",
                user_name: "이름을 입력해 주세요.",
                user_phone: "올바른 형태의 휴대폰 번호가 아닙니다.",
                password: "비밀번호를 입력해 주세요.",
                passconf: "비밀번호 확인을 입력해 주세요."
            };


            const final = () => {
                if($seat_id.value === "") toast("좌석을 선택해 주세요");
                return $seat_id.value === "";
            };


            const v = new Validator({form, inputs, rules, errors, final});
            v.start();



            /*
            Validator 사용 없이 하는 것

            $form.addEventListener("submit", e => {
                e.preventDefault();

                let result = true;
                
                // 영화
                result &= $movie_id.value.trim() !== "" ? error($movie_id, "") : error($movie_id, "영화를 선택해 주십시오.");
                // 영화관
                result &= $cinema_id.value.trim() !== "" ? error($cinema_id, "") : error($cinema_id, "영화를 선택해 주십시오.");
                // 이름
                result &= $user_name.value.trim() !== "" ? error($user_name, "") : error($user_name, "이름을 기재해 주십시오.");
                // 전화번호
                result &= /^[0-9]{3}-[0-9]{4}-[0-9]{4}$/.test($user_phone) ? error($user_phone, "") : error($user_phone, "올바른 형태의 휴대폰 번호가 아닙니다.");
                // 비밀번호
                result &= $password.value.trim() !== "" ? error($password, "") : error($password, "비밀번호를 기재해 주십시오.");
                // 비밀번호 재확인
                result &= $passconf.value.trim() !== "" ? error($passconf, "") : error($passconf, "비밀번호를 재확인해 주십시오.");


                // 좌석 선택
                result &= $seat_id.value.trim() === "" ? error() : error(null, "좌석을 선택해 주세요.");

                if(result) $form.submit();
            });
            */
        }
    </script>