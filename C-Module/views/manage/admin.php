<?php
$user = ss();
if(empty($user) || $user->is_admin == 0) {
    back("관리자만 접속할 수 있는 페이지입니다");
}
$books = db::fetchAll("select b.*, r.rental_date, r.return_date, r.user_idx from books b inner join rentals r on b.idx = r.book_idx");
$seats = db::fetchAll("select * from seats where timestamp(date, end_time) > now()");
$popups = db::fetchAll("select * from popups");
?>

<!-- 관리자 영역 -->
<main class="admin-content">
    <!-- 신규 도서 등록 섹션 -->
    <div class="inner-content">
        <div class="title-box">
            <p>신규도서등록</p>
            <h3>New Book Add</h3>
        </div>
        <form action="/addBook" method="post" class="form-con" enctype="multipart/form-data">
            <label>도서사진<input class="bookFile" type="file" name="file" required placeholder=""></label>
            <label>도서명<input type="text" name="title" required placeholder="도서명을 입력해주세요"></label>
            <label>저자명<input type="text" name="author" required placeholder="저자명을 입력해주세요"></label>
            <label>출판사<input type="text" name="publish" required placeholder="출판사를 입력해주세요"></label>
            <label>발행년<input type="number" name="year" required placeholder="발행년을 입력해주세요"></label>
            <label>가격<input type="number" name="price" required placeholder="가격을 입력해주세요"></label>
            <button class="gb">등록</button>
        </form>
    </div>
    <!-- 대출/열람실 업무조회 섹션 -->
    <div class="inner-content">
        <div class="title-box">
            <p>대출/열람실 업무조회</p>
            <h3>Work Manage</h3>
        </div>
        <table class="grn-table">
            <thead class="yb">
                <th>도서명</th>
                <th>저자명</th>
                <th>출판사</th>
                <th>대출일자</th>
                <th>반납일</th>
                <th>남은기간</th>
                <th>대출자 아이디</th>
                <th>관리</th>
            </thead>
            <tbody>
                <?php foreach ($books as $book) {
                    $rentalDay = new DateTime($book->rental_date);
                    $returnDay = new DateTime($book->return_date);
                    $diff = $rentalDay->diff($returnDay)->format("%r%a");
                    $book_user = db::fetch("select * from users where idx = '$book->user_idx'");
                    ?>
                    <tr>
                        <td><?= $book->title ?></td>
                        <td><?= $book->author ?></td>
                        <td><?= $book->publish ?></td>
                        <td><?= $book->rental_date ?></td>
                        <td><?= $book->return_date ?></td>
                        <td><?= $diff ?>일</td>
                        <td><?= $book_user->id ?></td>
                        <td>
                            <form action="/return" method="post">
                                <input type="hidden" name="idx" value="<?=$book->idx?>">
                                <button class="yb">반납</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <table class="grn-table">
            <thead class="gb">
                <th>좌석번호</th>
                <th>예약일</th>
                <th>시작시간</th>
                <th>종료시간</th>
                <th>예약자 아이디</th>
                <th>관리</th>
            </thead>
            <tbody>
                <?php foreach ($seats as $seat) {
                    $seat_user = db::fetch("select * from users where idx = '$seat->user_idx'");
                    ?>
                    <tr>
                        <td><?=$seat->seat_idx?></td>
                        <td><?=$seat->date?></td>
                        <td><?=$seat->start_time?></td>
                        <td><?=$seat->end_time?></td>
                        <td><?=$seat_user->id?></td>
                        <td>
                            <form action="/cancel" method="post">
                                <input type="hidden" name="idx" value="<?=$seat->idx?>">
                                <button class="gb">취소</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- 팝업 관리 섹션 -->
    <div class="inner-content">
        <div class="title-box">
            <p>팝업관리</p>
            <h3>Popup Admin</h3>
        </div>
        <form action="/popupAdd" class="form-con" enctype="multipart/form-data" method="post">
            <label>이미지<input type="file" name="file" placeholder="이미지를 입력해주세요" required></label>
            <label>제목<input type="text" name="title" placeholder="제목을 입력해주세요" required></label>
            <label>내용<input type="text" name="des" placeholder="내용을 입력해주세요" required></label>
            <label>팝업 시작일<input type="date" name="start_date" placeholder="팝업 시작일을 입력해주세요" required></label>
            <label>팝업 종료일<input type="date" name="end_date" placeholder="팝업 종료일을 입력해주세요" required></label>
            <button class="gb">등록</button>
        </form>
        <div class="popup-grid">
            <?php foreach($popups as $popup) { ?>
                <div class="popup">
                <img src="<?=$popup->img?>">
                <div class="popup-info">
                    <h3><?=$popup->title?></h3>
                    <p><?=$popup->des?></p>
                    <p>팝업 시작일:<?=$popup->start_date?></p>
                    <p>팝업 종료일:<?=$popup->end_date?></p>
                    <form class="btns" method="post">
                        <input type="hidden" name="idx" value="<?=$popup->idx?>">
                        <button formaction="/popupEdit" class="gb">수정</button>
                        <button formaction="/popupDelete" class="yb">삭제</button>
                    </form>
                </div>
            </div>
            <?php  } ?>
        </div>
    </div>
</main>

<script src="/js/lib.js"></script>
<script>
    $(".bookFile").addEventListener("change", (e) => {
        const file = e.target.files[0];
        const ext = file.name?.split(".").pop().toLowerCase();
        if(!["jpg", "png", "jpeg"].includes(ext)) {
            alert("jpg, png, jpeg 파일만 업로드 할 수 있습니다");
            e.target.value = "";
        }
    })
</script>