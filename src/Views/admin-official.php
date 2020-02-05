<!-- 상영 등록 영역 -->
<div id="admin-screen">
        <div class="container padding">
            <div class="section-title">
                <span class="behind">M</span>
                <h1>SCREEN <span>MANAGE</span></h1>
            </div>
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="sub-title">
                        <h1>LIST</h1>
                    </div>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>영화 제목</th>
                                <th>감독</th>
                                <th>러닝타임</th>
                                <th>등록일</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($officials as $item)
                            <tr>
                                <td data-poster="{{$item->poster_filename}}">{{$item->movie_name}}</td>
                                <td>{{$item->director_name}}</td>
                                <td>{{ time_format($item->running_time) }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td class="delete" data-id="{{$item->id}}">×</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="sub-title">
                        <h1>FORM</h1>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="movie_name">영화 제목</label>
                            <input type="text" id="movie_name" name="movie_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="movie_poster">영화 포스터</label>
                            <div class="custom-file">
                                <label for="movie_poster" class="custom-file-label"></label>
                                <input type="file" id="movie_poster" name="movie_poster" class="custom-file-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="director">감독명</label>
                            <input type="text" id="director" name="director" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="running_time">러닝타임</label>
                            <input type="text" id="running_time" name="running_time" class="form-control">
                        </div>
                        <button class="btn btn-dark px-5 py-2 mt-4">추가하기</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script defer>
        window.addEventListener("load", () => {
            let form = document.querySelector("#admin-screen form");

            let inputs = [
                $("#movie_name"),
                $("#movie_poster"),
                $("#director"),
                $("#running_time")
            ];

            let rules = {
                movie_poster: "image",
                running_time: "number"
            };  

            let errors = {
                movie_name: "영화 제목을 입력하세요.",
                movie_poster: "올바른 형태의 이미지 파일이 아닙니다.",
                director: "감독명을 입력하세요.",
                running_time: "올바른 형태의 러닝타임이 아닙니다.",
            }

            let v = new Validator({form, inputs, rules, errors});
            v.start();



            // 제목 클릭시 포스터 팝업 띄우기
            document.querySelectorAll("table tbody td:first-child").forEach(title => {
                title.addEventListener("click", e => {
                    let image_src = title.dataset.poster;
                    let content = `<div class="contents p-0 w-auto"><img src="/images/posters/${image_src}" alt="${title.innerText}" title="${title.innerText}" height="500"></div>`;
                    let modal = createModal(content);
                    showModal(modal);
                });
            });


            // 삭제버튼시 삭제하기
            document.querySelectorAll("table tbody .delete").forEach(button => {
                button.addEventListener("click", e => {
                    let id = e.target.dataset.id;
                    jQuery.post("/admin/official-remove/"+id, function({message, success}){
                        if(success) {
                            toast(message, "bg-success");
                            jQuery(button).closest("tr").remove();
                        }
                        else toast(message);
                    });
                });
            });
        });
    </script>