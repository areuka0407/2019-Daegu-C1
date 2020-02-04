<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>부산국제영화제</title>
    <script src="/js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script src="/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/bootstrap-4.4.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="/fontawesome/css/all.css">
    <script src="/fontawesome/js/all.js" src="/text/javascript"></script>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/admin.css">
    <script src="/js/common.js" type="text/javascript" defer></script>
    <script src="/js/Validator.js" type="text/javascript"></script>
    @php 
    $message = session()->get("message");
    @endphp

    @if($message)
    <script>
        window.addEventListener("load", () => {
            toast("@echo($message[0])", "@echo($message[1])");
        });
    </script>
    @endif
</head>
<body>
    <!-- 헤더 영역 -->
    <header>
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/" id="logo">
                <img src="/images/logo.png" title="부산국제영화제" alt="부산국제영화제" height="80">
            </a>
            @php
                $segment = session()->get('segment')[1];
            @endphp
            <div class="nav">
                <div class="item @echo($segment === 'sponsor' ? 'active' : '')">
                    <a href="/admin/sponsor">스폰서 관리</a>
                </div>
                <div class="item @echo($segment === 'screen' || $segment === 'request' || $segment === 'timetable' ? 'active' : '')">
                    <a href="/admin/screen">상영작/요청작 관리</a>
                    <div class="under-box">
                        <a href="/admin/screen">공식 상영작 관리</a>
                        <a href="/admin/request">요청작 관리</a>
                        <a href="/admin/timetable">상영시간표</a>
                    </div>
                </div>
                <div class="item @echo($segment === 'cinema' ? 'active' : '')">
                    <a href="/admin/cinema">영화관 관리</a>
                </div>
            </div>
            <div class="sub-nav">
                <a href="/logout" class="item">로그아웃</a>
            </div>
        </div>
    </header>