<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>스킬스북도서관</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./asset/fontawesome/css/all.css">
</head>

<?php
$user = ss();
?>

<body>
    <input type="radio" name="reg" id="regOpen">
    <input type="radio" name="reg" id="regClose">

    <input type="radio" name="login" id="loginOpen">
    <input type="radio" name="login" id="loginClose">
    <div class="sign-modal-backdrop login-modal-backdrop">
        <div class="sign-modal">
            <div class="sign-header">
                <h3>로그인</h3>
                <label for="loginClose">×</label>
            </div>
            <form action="/login" method="post">
                <input type="text" name="id" placeholder="아이디를 입력해주세요" required>
                <input type="password" name="pw" placeholder="비밀번호를 입력해주세요" required>
                <button>로그인</button>
            </form>
        </div>
    </div>
    <div class="sign-modal-backdrop reg-modal-backdrop">
        <div class="sign-modal">
            <div class="sign-header">
                <h3>회원가입</h3>
                <label for="regClose">×</label>
            </div>
            <form action="/reg" method="post">
                <input type="text" name="id" placeholder="아이디를 입력해주세요" required>
                <input type="password" name="pw" placeholder="비밀번호를 입력해주세요" required>
                <input type="text" name="name" placeholder="이름을 입력해주세요" required>
                <button>회원가입</button>
            </form>
        </div>
    </div>
    <header>
        <div class="header-content">
            <a href="/" class="logo">
                <img src="./asset/gimp/logo.png" alt="로고" title="로고">
            </a>
            <nav class="nav1 gb">
                <ul>
                    <li class="has-sub">
                        <input class="focus-trap">
                        <label class="menu-label">도서관소개</label>
                        <ul class="sub gb">
                            <li><a href="/sub">도서관소개</a></li>
                            <li><a href="/status">도서관현황</a></li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <input class="focus-trap">
                        <label class="menu-label">도서자료실</label>
                        <ul class="sub gb">
                            <li><a href="/data">자료실</a></li>
                            <li><a href="/seats">열람실예약</a></li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <input class="focus-trap">
                        <label class="menu-label">회원서비스</label>
                        <ul class="sub gb">
                            <?php if(!empty($user)) { ?>
                                <li><a onclick="alert('이미 가입된 회원입니다.'); location.href='/';">회원가입</a></li>
                                <?php } else {?>
                                <li><label  for="regOpen">회원가입</label></li>
                                <?php } ?>
                            <li><a href="/myPage">마이페이지</a></li>
                        </ul>
                    </li>
                    <li>
                        <label>도서검색</label>
                    </li>
                    <?php if(!empty($user) && $user->is_admin == 1) { ?>
                        <li>
                        <a class="manage-tag" href="/manage">도서관리자</a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
            <nav class="nav2 yb">
                <ul>
                   <?php
                   if(empty($user)) { ?>
                     <li><label for="loginOpen">로그인</label></li>
                    <li><label for="regOpen">회원가입</label></li>
                   <?php } else { ?>
                       <li><label><?=$user->name?>(<?=$user->id?>)</label></li>
                      <li><a href="/logout">로그아웃</a></li>
                   <?php }
                   ?>
                </ul>
            </nav>
        </div>
    </header>