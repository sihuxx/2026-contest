<!-- 도서관 현황 영역 -->

<main>
    <div class="inner-content">
        <div class="title-box">
            <p>도서관 현황</p>
            <h3>Library Status</h3>
        </div>
        <div class="status-content">
            <div class="map-container"></div>
            <div class="status-controller">
                <input type="text" class="search-input" placeholder="도서관명을 입력해주세요">
                <select class="sortSelect">
                    <option value="">시도명 오름차순</option>
                    <option value="desc">자료수(도서) 내림차순</option>
                    <option value="asc">자료수(도서) 오름차순</option>
                </select>
            </div>
            <table class="grn-table status-table">
                <thead class="gb">
                    <th>시도명</th>
                    <th>도서관명</th>
                    <th>시군구명</th>
                    <th>도서관유형</th>
                    <th>휴관일</th>
                    <th>평일운영시작시간</th>
                    <th>평일운영종료시간</th>
                    <th>열람좌석수</th>
                    <th>자료수(도서)</th>
                    <th>대출가능권수</th>
                    <th>대출가능일수</th>
                    <th>소재지도로주소명</th>
                </thead>
                <tbody class="tbody"></tbody>
            </table>
        </div>
    </div>
    <div class="tooltip"></div>
</main>

<script src="/js/lib.js"></script>
<script type="module" src="/js/script.js"></script>
<script>
</script>