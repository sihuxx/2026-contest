<?php

// 링크

get("/", function () {
    views("main");
});
get("/sub", function () {
    views("sub");
});
get("/data", function () {
    views("library/data");
});
get("/status", function () {
    views("library/status");
});
get("/seats", function () {
    views("library/seats");
});
get("/myPage", function () {
    views("user/myPage");
});
get("/manage", function () {
    views("manage/admin");
});

// 회원가입 / 로그인 / 로그아웃
post("/reg", function () {
    extract($_POST);
    if (db::fetch("select * from users where id = '$id'")) {
        move("/", "이미 가입된 회원입니다.");
    } else {
        db::exec("insert into users(id, name, pw) values ('$id', '$name', '$pw')");
        move("/", "회원가입 성공");
    }
});
post("/login", function () {
    extract($_POST);
    $user = db::fetch("select * from users where id = '$id' and pw = '$pw'");
    if ($user) {
        $_SESSION["ss"] = $user;
        move("/", "로그인 성공");
    } else {
        back("아이디 또는 비밀번호가 일치하지 않습니다.");
    }
});
get("/logout", function () {
    session_destroy();
    move("/", "로그아웃 성공");
});
// 도서 대출 / 반납
post("/rental", function () {
    extract($_POST);
    $user = ss();
    if (empty($user)) {
        back("로그인 후 이용 가능합니다");
    } else {
        db::exec("insert into rentals (book_idx, user_idx, return_date, rental_date) values ('$idx', '$user->idx', curdate() + 9, curdate())");
        move('/data', "대여 성공");
    }
});
post("/return", function () {
    extract($_POST);
    db::exec("delete from rentals where book_idx = '$idx'");
    move("/data", "반납 성공");
});
// 열람실 예약 / 취소
post("/reserve", function () {
    extract($_POST);
    $user = ss();
    $seatArr = explode(",", $seats);
    $nowTime = Date("H:i");
    if (empty($user)) {
        back("로그인 후 이용 가능합니다");
    }
    if (strtotime($nowTime) > strtotime($start_time)) {
        back("현재 시간보다 이전은 예약이 불가능합니다");
        exit;
    } else if (strtotime($start_time) > strtotime($end_time)) {
        back("시작시간이 종료 시간보다 늦을 수 없습니다");
        exit;
    } else if (strtotime($end_time) - strtotime($start_time) == 0) {
        back("0분은 예약할 수 없습니다");
        exit;
    }

    foreach ($seatArr as $seat) {
        if (db::fetch("select * from seats where date = '$date' and seat_idx = '$seat' and start_time < '$end_time' and end_time > '$start_time'")) {
            back("이미 이용자가 존재하는 좌석입니다");
            exit;
        }
    }
    foreach ($seatArr as $seat) {
        db::exec("insert into seats (seat_idx, user_idx, date, start_time, end_time) values ('$seat', '$user->idx', '$date', '$start_time', '$end_time')");
        move("/seats", "예약 성공");
    }
});
post("/cancel", function () {
    extract($_POST);
    db::exec("delete from seats where idx = '$idx'");
    move("/manage", "예약 취소 성공");
});
// 도서 등록
post("/addBook", function () {
    extract($_POST);
    $file = $_FILES["file"];
    $path = "/asset/books/" . $file["name"];
    if (move_uploaded_file($file["tmp_name"], ".$path")) {
        db::exec("insert into books(title, author, publish, year, price, img) values ('$title', '$author', '$publish', '$year', '$price', '$path')");
        move("/manage", "도서 등록 성공");
    } else {
        back("도서 등록 실패");
    }
});
// 팝업 등록 / 수정 / 삭제
post("/popupEdit", function () {
    extract($_POST);
    views("/manage/edit", ["idx" => $idx]);
});
post("/popupUpdate", function () {
    extract($_POST);
    $file = $_FILES["file"];
    $path = "/asset/popups/" . $file["name"];
    if ($file["tmp_name"]) {
        if (move_uploaded_file($file["tmp_name"], ".$path")) {
            db::exec("update popups set title = '$title', des = '$des', start_date = '$start_date', end_date = '$end_date', img = '$path' where idx = '$idx'");
            move("/manage", "팝업 수정 성공");
        } else {
            back("팝업 수정 실패");
        }
    } else {
        db::exec("update popups set title = '$title', des = '$des', start_date = '$start_date', end_date = '$end_date' where idx = '$idx'");
        move("/manage", "팝업 수정 성공");
    }
});
post("/popupAdd", function () {
    extract($_POST);
    $file = $_FILES["file"];
    $path = "/asset/popups/" . $file["name"];
    if (move_uploaded_file($file["tmp_name"], ".$path")) {
        db::exec("insert into popups (title, des, start_date, end_date, img) values('$title','$des','$start_date','$end_date','$path')");
        move("/manage", "팝업 추가 성공");
    } else {
        back("팝업 추가 실패");
    }
});
post("/popupDelete", function () {
    extract($_POST);
    db::exec("delete from popups where idx = '$idx'");
    move("/manage", "팝업 삭제 성공");
});