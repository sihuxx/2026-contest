<!-- 열람실 예약 영역 -->

<main class="seat-content">
    <div class="inner-content">
        <div class="title-box">
            <p>열람실 예약</p>
            <h3>Library Seats Reserve</h3>
        </div>
        <div class="seat-container"></div>
        <div class="seat-controller">
            <p>선택된 좌석: <span class="selectedSeats"></span></p>
            <form action="/reserve" method="post" class="reserveForm">
                <input type="hidden" name="seats" class="seatsInput">
                <label>예약일: <input type="date" name="date" min="<?= date("Y-m-d") ?>" required></label>
                <label>시작 시간: <input type="time" name="start_time" required></label>
                <label>종료 시간: <input type="time" name="end_time" required></label>
                <button class="reserve-btn gb">예약하기</button>
            </form>
        </div>
    </div>
</main>

<?php
$seatList = db::fetchAll("select * from seats where timestamp(date, end_time) > now() order by start_time asc");
$seatData = [];
foreach ($seatList as $seat) {
    $seatData[$seat->seat_idx][] = "$seat->date ($seat->start_time ~ $seat->end_time)";
    }
    ?>

<script src="/js/lib.js"></script>
<script>
    const MAX = 4;
    const selected = new Set();
    const info = <?= json_encode($seatData) ?>;
    const container = $(".seat-container");
    

    for (let i = 1; i <= 75; i++) {
        const seat = newEl("div", { textContent: i, className: "seat" });
        seat.title = info[i] ? "최근 예약\n" + info[i].join("\n") : "예약 없음";
        container.append(seat);
    }

    let isDragging = false;
    const seats = $$(".seat");

    container.addEventListener("mousedown", (e) => {
        if (e.target.classList.contains("seat")) {
            seatToggle(e.target);
            isDragging = true;
        }
    })
    container.addEventListener("mouseleave", () => isDragging = false)
    container.addEventListener("mouseup", () => isDragging = false)
    container.addEventListener("mouseover", (e) => {
        if (isDragging && e.target.classList.contains("seat")) {
            seatToggle(e.target);
        }
    })
    function seatToggle(el) {
        const id = Number(el.textContent);
        if (selected.has(id)) {
            selected.delete(id);
        } else {
            if (selected.size < MAX) selected.add(id);
        }
        render();
    }
    function render() {
        $(".reserveForm").classList.toggle("hidden", selected.size === 0);
        const arr = [...selected].sort((a, b) => a - b);
        seats.forEach(s => s.classList.toggle("selected", selected.has(Number(s.textContent))));
        $(".seatsInput").value = arr.join(",");
        $(".selectedSeats").textContent = arr.length ? arr.join("번, ") + "번": "없음";
        $(".reserve-btn").disabled = arr.length === 0;
    }
    render();
</script>