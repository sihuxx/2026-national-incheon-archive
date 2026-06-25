<?php
$user = ss();
$page = $_GET["page"] ?? 1;
$keyword = $_GET["keyword"] ?? "";
$sort = $_GET["sort"] ?? "";

$limit = 10;
$start = ($page - 1) * $limit;
$total = db::fetch("select count(*) cnt from debates")->cnt;
$maxPage = ceil($total / $limit);
$where = "where 1";
$order = "idx desc";
if ($keyword) {
    $where .= " and title like '%$keyword%'";
}
if ($sort == "date-asc") $order = "idx asc";
if ($sort == "opinions-desc") $order = "opinions_count desc";
if ($sort == "opinions-asc") $order = "opinions_count asc";

$debates = db::fetchAll("select d.*, count(o.idx) from debates d left join opinions o on d.idx = o.debate_idx $where group by d.idx order by $order limit $start, $limit");
?>

<main class="page">

    <!-- 페이지 배너 -->
    <section class="page-banner">
        <div class="container">
            <h1>토론 게시판</h1>
            <p>인천 시민들이 작성한 전체 토론</p>
        </div>
    </section>

    <section class="board">
        <div class="container">
            <div class="board__data">

                <!-- 툴바: 결과 수 + 정렬 셀렉트 -->
                <button class="post-add-btn" onclick="<?= $user ? "document.querySelector('.popup').style.display = 'flex'" : "alert('로그인한 회원만 이용 가능합니다')" ?>">등록</button>
                <div class="board__toolbar">
                    <p class="board__count">총 <b><?= $total ?></b>개의 토론</p>
                    <div class="search-box">
                        <input type="text" value="<?= $keyword ?>" class="search-input" placeholder="검색어를 입력해주세요">
                        <button class="search-btn">검색</button>
                    </div>
                    <div class="sortbox">
                        <select name="sort" class="sort-select">
                            <option <?= $sort == "date-asc" ? "selected" : "" ?> value="date-asc">등록일 오름차순</option>
                            <option <?= $sort == "date-desc" ? "selected" : "" ?> value="date-desc">등록일 내림차순</option>
                            <option <?= $sort == "opinions-asc" ? "selected" : "" ?> value="opinions-asc">의견 수 오름차순</option>
                            <option <?= $sort == "opinions-desc" ? "selected" : "" ?> value="opinions-desc">의견 수 내림차순</option>
                        </select>
                    </div>
                </div>

                <!-- 리스트 헤더 -->
                <div class="board__head">
                    <span style="text-align:center;">번호</span>
                    <span>제목</span>
                    <span>등록일</span>
                    <span style="text-align:center;">의견수</span>
                    <?= $user->admin == 'admin' ? "<span>관리</span>" : "" ?>
                </div>

                <!-- 게시글 목록 (10개씩 p1~p5) -->
                <div class="board__list">
                    <?php foreach ($debates as $debate) {
                    ?>
                        <div class="post"><span class="post__rank"><?= $debate->idx ?></span><a href="/debate/<?= $debate->idx ?>" class="post__title"><?= $debate->title ?></a><span class="post__date"><?= $debate->date ?></span><span class="post__like">0개</span>
                            <form action="/deleteDebate" method="POST" class="admin-box">
                                <input type="hidden" name="idx" value="<?= $debate->idx ?>">
                                <button>삭제</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>

                <div class="pager">
                    <a href="?page=<?= $page - 1 ?>" class="prevBtn <?= $page <= 1 ? 'disabled' : '' ?>">이전</a>
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <a href="?page=<?= $i ?>" class="<?= $i == $page ? "active" : "" ?> <?= $i > $maxPage ? "disabled" : "" ?>"><?= $i ?></a>
                    <?php } ?>
                    <a href="?page=<?= $page + 1 ?>" class="nextBtn <?= $page >= $maxPage ? 'disabled' : '' ?>">다음</a>
                </div>

            </div>
        </div>
    </section>
    <div class="popup">
        <form action="/addDebate" method="post" class="default-form">
            <div class="form-header">
                <h3>토론 등록</h3>
                <button type="button" class="close-btn"
                    onclick="document.querySelector('.popup').style.display='none'">
                    ✕
                </button>
            </div>
            <input type="text" name="title" placeholder="제목" required>
            <button class="submit-btn">등록</button>
        </form>
    </div>
</main>