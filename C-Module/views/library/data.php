<?php
$books = db::fetchAll("select b.*, r.rental_date, r.return_date from books b left join rentals r on b.idx = r.book_idx");
?>

<!-- 도서 자료실 영역 -->

<main class="data-content">
    <div class="inner-content">
        <div class="title-box">
            <p>도서자료실</p>
            <h3>Library Data</h3>
        </div>
        <div class="book-grid">
            <?php foreach($books as $book) { ?>
                <div class="book">
                <img src="<?=$book->img?>">
                <div class="book-info">
                    <h3><?=$book->title?></h3>
                    <p><?=$book->author?></p>
                    <p>발행년: <?=$book->year?>년</p>
                    <p>가격: <?=number_format($book->price)?>원</p>
                    <?php if($book->rental_date) { ?>
                        <div class="book-status gb">대출중</div>
                        <p>대출 기간: <?=$book->rental_date?> ~ <?=$book->return_date?></p>
                    <?php } else { ?>
                        <div class="book-status yb">대출가능</div>
                    <?php } ?>
                    <form action="/rental" method="post">
                        <input type="hidden" name="idx" value="<?=$book->idx?>">
                        <button <?= $book->rental_date ? "disabled" : "" ?> class="gb">대출하기</button>
                    </form>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</main>

<script>