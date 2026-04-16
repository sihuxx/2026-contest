<?php
    $popup = db::fetch("select * from popups where idx = '$idx'");
?>

<main class="admin-content">
     <div class="inner-content">
        <div class="title-box">
            <p>팝업관리</p>
            <h3>Popup Admin</h3>
        </div>
        <form action="/popupUpdate" class="form-con" enctype="multipart/form-data" method="post">
            <img src="<?=$popup->img?>">
            <input type="hidden" name="idx" value="<?=$popup->idx?>">
            <label>이미지<input type="file" name="file" placeholder="이미지를 입력해주세요"></label>
            <label>제목<input type="text" value="<?=$popup->title?>" name="title" placeholder="제목을 입력해주세요" required></label>
            <label>내용<input type="text" name="des" value="<?=$popup->des?>" placeholder="내용을 입력해주세요" required></label>
            <label>팝업 시작일<input type="date" name="start_date" value="<?=$popup->start_date?>" placeholder="팝업 시작일을 입력해주세요" required></label>
            <label>팝업 종료일<input type="date" name="end_date" value="<?=$popup->end_date?>" placeholder="팝업 종료일을 입력해주세요" required></label>
            <button class="gb">수정</button>
        </form>
    </div>
</main>