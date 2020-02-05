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
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>영화 제목</th>
                                <th>감독</th>
                                <th>러닝타임</th>
                                <th>등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($officials as $item): ?>
                            <tr>
                                <td><?= $item->movie_name ?></td>
                                <td><?= $item->director_name ?></td>
                                <td><?= time_format($item->running_time) ?></td>
                                <td><?= $item->created_at ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="sub-title">
                        <h1>WAIT REQUEST</h1>
                        <h5>상영 요청작</h5>
                    </div>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>영화 제목</th>
                                <th>감독</th>
                                <th>러닝타임</th>
                                <th>상태</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $item): ?>
                            <tr>
                                <td><?= $item->movie_name ?></td>
                                <td><?= $item->director_name ?></td>
                                <td><?= time_format($item->running_time) ?></td>
                                <td><?= $item->status ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="my-5">
            <div>
                <div class="sub-title">
                    <h1>TIME TABLE</h1>
                </div>
                <img src="/images/timetable.png" title="영화 시간표" alt="영화 시간표" class="w-100">
            </div>
        </div>
    </div>