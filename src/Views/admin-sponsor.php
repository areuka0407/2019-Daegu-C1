 <!-- 스폰서 관리 영역 -->
 <div id="admin-sponsor">
        <div class="container padding">
            <div class="section-title">
                <span class="behind">M</span>
                <h1>SPONSOR <span>MANAGE</span></h1>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h1>LIST</h1>
                    </div>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>이름</th>
                                <th>후원금</th>
                                <th>등록일</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sponsors as $sponsor)
                            <tr>
                                <td onclick="openModal(event)" data-image="{{ $sponsor->logo_filename }}">{{ $sponsor->sponsor_name }}</td>
                                <td>￦ {{number_format($sponsor->donation)}}</td>
                                <td>{{date("Y-m-d H:i:s", strtotime($sponsor->created_at))}}</td>
                                <td class="delete" onclick="removeSponsor(event)" data-id="{{$sponsor->id}}">×</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h1>FORM</h1>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="sponsor_nam e">스폰서 명</label>
                            <input type="text" id="sponsor_name" name="sponsor_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="sponsor_logo">스폰서 로고</label>
                            <div class="custom-file">
                                <label for="sponsor_logo" class="custom-file-label"></label>
                                <input type="file" id="sponsor_logo" name="sponsor_logo" class="custom-file-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="donation">후원한 금액</label>
                            <input type="text" id="donation" name="donation" class="form-control">
                        </div>
                        <button class="btn btn-dark px-5 py-2 mt-4">추가하기</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script defer>
        window.onload = function(){
            const form = document.querySelector("#admin-sponsor form");
            
            const inputs = [
                $("#sponsor_name"),
                $("#sponsor_logo"),
                $("#donation")
            ];

            const rules = {
                sponsor_logo: "image",
                sponsor_donation: "number"
            };

            const errors = {
                sponsor_name: "스폰서 명을 입력해주십시오",
                sponsor_logo: "올바른 형태의 이미지 파일이 아닙니다.",
            };

            const final = function(){
                const $donation = $("#donation");
                const val = parseInt($donation.value);
                
                let message = [];
                // 금액이 숫자인지 검사
                if(!/^[0-9]+$/.test(val)) message.push("올바른 형태의 금액이 아닙니다.");

                // 금액이 만원 단위인지 검사
                if(val%10000 !== 0) message.push("후원은 만원 단위로만 가능합니다.");

                // 금액이 100만원 이상인지 검사
                if(!val || val < 1000000) message.push("후원은 100만원 이상 가능합니다.");

                return error($donation, message);
            };

            const v = new Validator({form, inputs, rules, errors, final});
            v.start();
        };

        // 스폰서 삭제
        function removeSponsor(event){
            let id = event.target.dataset.id;
            jQuery.post("/admin/sponsor-remove/" + id, res => {
                
                if(res.success){
                    toast(res.message, "bg-success");
                    event.target.parentElement.remove();
                }
                else toast(res.message);
            });
        }


        // 로고 팝업 띄우기
        function openModal(event){
            let exist = document.querySelector(".modal-wrap");
            if(exist){
                jQuery(exist).fadeOut('fast', () => exist.remove());
            }

            const imagePath = "/images/sponsors/" + event.target.dataset.image;

            let modal = getModal(imagePath);
            document.body.append(modal);
            jQuery(modal).hide();
            jQuery(modal).fadeIn();
        }

        function getModal(imagePath){
            let wrap = document.createElement("div");
            wrap.classList.add("modal-wrap");
            wrap.innerHTML = ` <div class="contents p-0 w-auto">
                                    <img src="${imagePath}" alt="로고 이미지" title="로고이미지">
                                    <button class="btn-close">&times;</button>
                                </div>`;            

            wrap.querySelector(".btn-close").addEventListener("click", () => {
                jQuery(wrap).fadeOut('fast', () => wrap.remove());
            });
            return wrap;
        }
    </script>