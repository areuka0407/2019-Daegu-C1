<!-- 상영 등록 영역 -->
<div id="admin-timetable">
        <div class="container padding">
            <div class="section-title">
                <span class="behind">T</span>
                <h1>TIME <span>TABLE</span></h1>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="sub-title">
                        <h1>SCHEDULE</h1>
                        <h5>공식 상영작</h5>
                    </div>
                    <table id="officials" class="table text-center">
                        <thead>
                            <tr>
                                <th>영화 제목</th>
                                <th>감독</th>
                                <th>러닝타임</th>
                                <th>등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($officials as $item)
                            <tr data-id="{{$item->id}}">
                                <td>{{$item->movie_name}}</td>
                                <td>{{$item->director_name}}</td>
                                <td>{{time_format($item->running_time)}}</td>
                                <td>{{$item->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="sub-title">
                        <h1>WAIT REQUEST</h1>
                        <h5>상영 요청작</h5>
                    </div>
                    <table id="requests" class="table text-center">
                        <thead>
                            <tr>
                                <th>영화 제목</th>
                                <th>감독</th>
                                <th>러닝타임</th>
                                <th>상태</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $item)
                            <tr data-id="{{$item->id}}">
                                <td>{{$item->movie_name}}</td>
                                <td>{{$item->director_name}}</td>
                                <td>{{time_format($item->running_time)}}</td>
                                <td>{{$item->status}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="my-5">
            <div>
                <div class="sub-title">
                    <h1>TIME TABLE</h1>
                </div>
                <img id="timetable" src="/images/timetable.png" title="영화 시간표" alt="영화 시간표" class="w-100">
            </div>
        </div>
    </div>
    <script src="/js/TimeTable.js" src="text/javascript"></script>
    <script>
        window.addEventListener("load", () => {
            let timetable = new TimeTable("#timetable");
            timetable.update();

            document.querySelectorAll("table tbody td:first-child").forEach(title => {
                title.addEventListener("click", () => {
                    let table = jQuery(title).closest("table")[0].id;

                    jQuery.post("/admin/cinema-list").then(list => {
                        let id = title.parentElement.dataset.id;
                        let contents = `<div class="contents">
                                            <form action="/admin/timetable/${table}/${id}" method="post">
                                                <div class="form-group">
                                                    <label>영화관</label>
                                                    <select class="form-control" name="cid">`;
                        list.forEach(item => {
                            contents +=                 `<option value="${item.id}">${item.name}</option>`;
                        });
                        contents +=                `</select>
                                                </div>
                                                <div class="form-group">
                                                    <label>영화 시작 시간</label>
                                                    <input type="text" class="form-control" name="start_time">
                                                </div>
                                                <button class="btn btn-info" onclick="return confirm('정말로 시간표를 확정하시겠습니까?')">시간표 확정</button>
                                            </form>
                                        </div>`;
                        let $modal = createModal(contents);
                        showModal($modal);
                    });

                });
            });
        });
    </script>