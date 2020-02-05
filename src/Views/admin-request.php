<!-- 상영 등록 영역 -->
<div id="admin-request">

<div class="container padding">
    <div class="section-title">
        <span class="behind">M</span>
        <h1>REQEUST <span>MANAGE</span></h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="sub-title">
                <h1>LIST</h1>
            </div>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>영화 제목</th>
                        <th>감독</th>
                        <th>러닝타임</th>
                        <th>상태</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $item)
                    <tr>
                        <td class="movie-title">{{$item->movie_name}}</td>
                        <td>{{$item->director_name}}</td>
                        <td>{{$item->running_time}}</td>
                        <td>{{$item->status}}</td>
                        <td>
                            @if($item->status === "대기") 
                                <a href="/admin/request-apply/{{$item->id}}" class="btn btn-primary text-white btn-apply">승인</a>
                                <a href="/admin/request-return/{{$item->id}}" class="btn btn-danger text-white btn-return">반려</a>
                            @elseif($item->status === "승인" && is_null($item->start_time))
                                <a href="/admin/request-return/{{$item->id}}" class="btn btn-danger text-white btn-return">반려로 변경</a>
                            @elseif($item->status === "반려")
                                <a href="/admin/request-apply/{{$item->id}}" class="btn btn-primary text-white btn-apply">승인으로 변경</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<script defer>
window.onload = () => {
    document.querySelectorAll(".movie-title").forEach(x => {
        x.addEventListener("click", e => {
            let exist = document.querySelector(".modal-wrap");
            if(exist){
                jQuery(exist).fadeOut('fast', () => exist.remove());
            }

            const company_name = "완전 멋있는 영화사";
            const business_id = "123-12-12345";
            const ceo_phone = "010-1234-1234";
            const ceo_email = "example@gmail.com";

            let modal = getModal({company_name, business_id, ceo_phone, ceo_email});
            document.body.append(modal);
            jQuery(modal).hide();
            jQuery(modal).fadeIn();
        });
    });


    function getModal({company_name, business_id, ceo_phone, ceo_email}){
        let wrap = document.createElement("div");
        wrap.classList.add("modal-wrap");
        wrap.innerHTML = ` <div class="contents">
                                <button class="btn-close">&times;</button>
                                <dl>
                                    <dt>영화사명</dt>
                                    <dd>${company_name}</dd>
                                    <dt>사업자등록번호</dt>
                                    <dd>${business_id}</dd>
                                    <dt>영화사 대표 이메일</dt>
                                    <dd>${ceo_email}</dd>
                                    <dt>영화사 대표 전화번호</dt>
                                    <dd>${ceo_phone}</dd>
                                </dl>
                            </div>`;            

        wrap.querySelector(".btn-close").addEventListener("click", () => {
            jQuery(wrap).fadeOut('fast', () => wrap.remove());
        });
        return wrap;
    }
};
</script>