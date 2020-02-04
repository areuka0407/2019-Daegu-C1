    <!-- 비쥬얼 영역 -->
    <div id="visual" class="main">
        <div>
            <h1>BIFF <span>2020</span></h1>
            <p class="description">
                <span>세계적인 배우들</span>과 <span>세기의 명작</span>을 동시에 볼 수 있는 절호의 기회!<br>
                부산에서 아시아 최대 규모의 영화제를 접해 보세요.
            </p>
            <a href="sub_about.html">자세히 보기</a>
        </div>
    </div>
    <!-- 소개 영역 -->
    <div id="about">
        <div class="container padding">
            <div class="section-title">
                <span class="behind">A</span>
                <h1>About <span class="accent">BIFF</span></h1>
            </div>
            <p class="text-center mt-5">
                부산국제영화제는 1996년 제 1회를 시작으로 2020년 제 25회를 맞이하게 되었습니다.<br>
                오늘날에 이르러선 부산 지역을 넘어 한국 영화계의 최대 축제가 되었습니다.
            </p>
            <div class="list">
                <div class="item">
                    <b class="title">매 가을마다, 영화의 전당에서!</b>
                    <p class="contents mt-4">
                        부산국제영화제는 매년 가을 대한민국 부산광역시<br> 
                        영화의전당 일원에서 개최되는 국제영화제다. 
                    </p>
                </div>
                <div class="item">
                    <b class="title">아시아 최대 규모 영화제</b>
                    <p class="contents mt-4">
                        도쿄, 홍콩국제영화제와 더불어<br>
                        아시아 최대 규모의 영화제다.
                    </p>
                </div>
                <div class="item">
                    <b class="title">FIAPF가 공인한 비경쟁영화제</b>
                    <p class="contents mt-4">
                        부분경쟁을 도입한 비경쟁영화제로<br>
                        국제영화제작자연맹(FIAPF)의 공인을 받은 영화제이다
                    </p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div id="sponsor">
        <div class="container-fluid padding">
            <div class="sub-title">
                <h1>Sponsor of Festival</h1>
            </div>
            <div class="list">
                @foreach($sponsorList as $sponsor)
                    <div class="image">
                        <img src="images/sponsors/{{$sponsor->logo_filename}}" alt="{{$sponsor->sponsor_name}}" title="{{$sponsor->sponsor_name}}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>