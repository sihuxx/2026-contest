<?php
    $user = ss();
    if(empty($user)) {
        back("로그인 후 이용 가능합니다");
    } 

    $books = db::fetchAll("select b.*, r.rental_date, r.return_date from books b inner join rentals r on b.idx = r.book_idx where r.user_idx = '$user->idx'");
    $seats = db::fetchAll("select * from seats where timestamp(date, end_time) > now() and user_idx = '$user->idx'");
?>

<main class="myPage-content">
    <div class="inner-content">
        <div class="title-box">
            <p>마이페이지</p>
            <h3>My Page</h3>
        </div>
        <div class="my-content">
            <div class="book-grid">
               <?php foreach($books as $book) { 
                $rentalDay = new DateTime($book->rental_date);
                $returnDay = new DateTime($book->return_date);
                $diff = $rentalDay->diff($returnDay)->format("%r%a");
                ?>
                 <div class="book">
                    <img src="<?=$book->img?>">
                    <div class="book-info">
                        <h3><?=$book->title?></h3>
                        <p><?=$book->author?></p>
                        <p>대출 일자: <?=$book->rental_date?></p>
                        <p>반납일: <?=$book->return_date?></p>
                        <p>남은 기간: <?=$diff?>일</p>
                        <form action="/return" method="post">
                            <input type="hidden" name="idx" value="<?=$book->idx?>">
                            <button class="gb">반납</button>
                        </form>
                    </div>
                </div>
               <?php } ?>
            </div>
            <table class="grn-table">
                <thead class="gb">
                    <th>좌석번호</th>
                    <th>예약일</th>
                    <th>시작시간</th>
                    <th>종료시간</th>
                    <th>예약자 아이디</th>
                </thead>
                <tbody>
                    <?php foreach ($seats as $seat) { ?>
                        <tr>
                            <td><?=$seat->seat_idx?></td>
                            <td><?=$seat->date?></td>
                            <td><?=$seat->start_time?></td>
                            <td><?=$seat->end_time?></td>
                            <td><?=$user->id?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>