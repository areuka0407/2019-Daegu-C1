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
    <script src="/fontawesome/js/all.js" src="text/javascript"></script>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/admin.css">
    <script src="/js/common.js" type="text/javascript" defer></script>   
    <script src="/js/Validator.js" type="text/javascript" defer></script>   
    <?php 
    $message = session()->get("message");
    ?>

    <?php if ($message): ?>
        <?php
        $content = is_array($message[0]) ? $message[0] : [$message[0]];
        $type = $message[1];
        ?>
        <script>
            window.addEventListener("load", () => {
                toast(<?=  json_encode($content, JSON_UNESCAPED_UNICODE )  ?>, "<?=  $type  ?>");
            });
        </script>
    <?php endif; ?>
</head>
<body>
    <?php
        $segment = session()->get("segment", true)[0];
    ?>
     <!-- 헤더 영역 -->
     <header>
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/" id="logo">
                <img src="images/logo.png" title="부산국제영화제" alt="부산국제영화제" height="80">
            </a>
            <div class="nav">
                <div class="item @echo( $segment === 'home' ? 'active' : '' )">
                    <a href="/">부산국제영화제</a>
                </div>
                <div class="item @echo( $segment === 'about' ? 'active' : '' )">
                    <a href="/about">영화제 소개</a>
                </div>
                <div class="item @echo( $segment === 'request' ? 'active' : '' )">
                    <a href="/request">상영 요청</a>
                </div>
                <div class="item @echo( $segment === 'reserve' ? 'active' : '' )">
                    <a href="/reserve">상영작 예매</a>
                </div>
            </div>
            <div class="sub-nav">
                <a href="/login" class="item">관리자 접속</a>
            </div>
        </div>
    </header>