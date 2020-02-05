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
                </div>
                <form id="reserve-form" method="post">
                    <input type="hidden" id="seat_id" name="seat_id">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="cinema_id">영화관</label>
                            <select name="cinema_id" id="cinema_id" class="form-control mt-2" form="reserve-form">
                                <option value>영화관를 선택하세요</option>
                                @foreach($cinemaList as $cinema)
                                    <option value="{{$cinema->id}}" data-map="{{$cinema->seat_map}}">{{$cinema->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="movie_id">영화</label>
                            <select name="movie_id" id="movie_id" class="form-control mt-2" form="reserve-form">
                                <option value="">영화관을 먼저 선택하세요</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="user_name">이름</label>
                            <input type="text" id="user_name" name="user_name" class="form-control mt-2" form="reserve-form">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">비밀번호</label>
                            <input type="password" id="password" name="password" class="form-control mt-2" form="reserve-form">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="user_phone">전화 번호</label>
                            <input type="text" id="user_phone" name="user_phone" class="form-control mt-2" form="reserve-form">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="passconf">비밀번호 재확인</label>
                            <input type="password" id="passconf" name="passconf" class="form-control mt-2" form="reserve-form">
                        </div>
                    </div>

                    <button class="btn btn-dark mt-5 px-5 py-2" type="submit" form="reserve-form">상영 요청</button>
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
                seat.addEventListener("click", e => selectSeat(seat));
            });

            function selectSeat(seat){
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
                toast(message, "bg-info");
            }

            /**
             * Validator
             */

            const inputs = [
                $("#cinema_id"),
                $("#movie_id"),
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
                return $seat_id.value !== "";
            };


            // const v = new Validator({form, inputs, rules, errors, final});
            // v.start();

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


            /**
             * C과제
             */
            let [$cinema_id, $movie_id] = inputs;

            $cinema_id.addEventListener("change", function(){
                if(!this.value) {
                    $movie_id.innerHTML = "<option value>영화관을 먼저 선택하세요</option>";
                    return;
                };

                jQuery.post("/movie-list/by-cinema/"+this.value, function(res){
                    let contents = "<option value>영화를 선택하세요.</option>";
                    contents += res.reduce((p, c) => {
                        let $option = document.createElement("option")
                        $option.value = c.id;
                        $option.innerText = c.movie_name;
                        return p + $option.outerHTML;
                    }, "");
                    if(res.length === 0) contents = "<option value>영화관에 등록된 영화가 없습니다</option>"
                    $movie_id.innerHTML = contents;
                });
            });

            $movie_id.addEventListener("change", function(){
                if(this.value)
                    drawSeatmap(this.value, $cinema_id.selectedOptions[0].dataset.map);
            });
            
            
            function drawSeatmap(movie_id, map){
                jQuery.post("/reserve/list", {movie_id}, function(res){
                    const reserved = res.map(x => x.seat_name);
                    const str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    const $map = document.querySelector("#seat-map");
                    $map.innerHTML = "";

                    map = map.split("\n");
                    $map.style.gridTemplateColumns = "repeat("+map[0].length+", 1fr)";

                    let height = map.length;
                    map = map.map(x => x.split(""));

                    for(let y = 0; y < height; y++){
                        let row = map[y];
                        for(let x = 0; x < row.length; x++){
                            let item = row[x];
                            let $seat = document.createElement("div");
                            let seatName = (x+1) + (str[y]) + "";;
                            $seat.classList.add("seat");
                            $seat.innerText = seatName;
                            $seat.addEventListener("click", e => selectSeat($seat));
                            
                            if(item == 3) $seat.classList.add("super-premium")
                            if(item == 2) $seat.classList.add("premium");
                            if(reserved.includes(seatName)) $seat.classList.add("reserved");
                            if(item == 0) $seat = document.createElement("div");
                            $map.append($seat);
                        }
                    }
                });
            }
        }
    </script>