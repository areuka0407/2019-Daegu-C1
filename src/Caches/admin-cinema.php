<!-- 상영 등록 영역 -->
<div id="admin-cinema">
        <div class="container padding">
            <div class="section-title">
                <span class="behind">M</span>
                <h1>CINEMA <span>MANAGE</span></h1>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="sub-title">
                        <h1>LIST</h1>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>영화관 명</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cinemas as $item): ?>
                            <tr>
                                <td><?= $item->name ?></td>
                                <td>
                                    <button class="btn btn-primary seat-btn" data-map="<?= $item->seat_map ?>">좌석 보기</button>
                                    <a href="/admin/cinema-remove/<?= $item->id ?>" class="btn btn-danger text-white">삭제<a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="sub-title">
                        <h1>FORM</h1>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="cinema_name">영화관 명</label>
                            <input type="text" id="cinema_name" name="cinema_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="seat_file">좌석 파일</label>
                            <div class="custom-file">
                                <label for="seat_file" class="custom-file-label"></label>
                                <input type="file" id="seat_file" name="seat_file" class="custom-file-input">
                            </div>
                        </div>
                        <button class="btn btn-dark px-5 py-2 mt-4">추가하기</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function(){
            const form = document.querySelector("#admin-cinema form");

            const inputs = [
                $("#cinema_name"),
                $("#seat_file")
            ];

            const errors = {
                cinema_name: "영화관 명을 입력하세요.",
                seat_file: "좌석 파일을 첨부하세요."
            };

            const v = new Validator({form, inputs, errors});
            v.start();

            document.querySelectorAll(".seat-btn").forEach(btn => {
                btn.addEventListener("click", () => {
                    let map = btn.dataset.map.split("\n").map(x => x.trim().split(""));
                    console.log(map);
                    let length = map[0].length;
                    let contents = `<div class="contents"><div id="seat-id" style="grid-template-columns: repeat(100% / ${length})">`;
                    

                    contents += "</div></div>"
                });
            });
        };
    </script>