<?php
$user = ss();
$page = $_GET["page"] ?? 1;
$keyword = $_GET["keyword"] ?? "";
$category = $_GET["category"] ?? "";
$sort = $_GET["sort"] ?? "";

$limit = 10;
$start = ($page - 1) * $limit;
$total = db::fetch("select count(*) cnt from posts")->cnt;
$maxPage = ceil($total / $limit);

$where = "where 1";
$order = "idx desc";
if ($category && $category != "전체") {
    $where .= " and category = '$category'";
}
if ($keyword) {
    $where .= " and title like '%$keyword%'";
}
if ($sort == "date-asc") $order = "idx asc";
if ($sort == "like-desc") $order = "like_count desc";
if ($sort == "like-asc") $order = "like_count asc";

$posts = db::fetchAll("select p.*, count(l.idx) as like_count from posts p left join likes l on p.idx = l.post_idx $where group by p.idx order by $order limit $start, $limit");
?>

<main class="page">

    <!-- 페이지 배너 -->
    <section class="page-banner">
        <div class="container">
            <h1>전체 게시판</h1>
            <p>인천 시민들이 작성한 전체 게시글</p>
        </div>
    </section>

    <section class="board">
        <div class="container">
            <div class="board__data">

                <!-- 툴바: 결과 수 + 정렬 셀렉트 -->
                <button class="post-add-btn" onclick="<?= $user ? "document.querySelector('.popup').style.display = 'flex'" : "alert('로그인한 회원만 이용 가능합니다')" ?>">등록</button>
                <div class="board__toolbar">
                    <p class="board__count">총 <b><?= $total ?></b>개의 게시글</p>
                    <div class="search-box">
                        <input type="text" value="<?= $keyword ?>" class="search-input" placeholder="검색어를 입력해주세요">
                        <button class="search-btn">검색</button>
                    </div>
                    <div class="sortbox">
                        <select name="category" class="category-select">
                            <option <?= $category == "전체" ? "selected" : "" ?> value="전체">전체</option>
                            <option <?= $category == "공지사항" ? "selected" : "" ?> value="공지사항">공지사항</option>
                            <option <?= $category == "여행" ? "selected" : "" ?> value="여행">여행</option>
                            <option <?= $category == "정보" ? "selected" : "" ?> value="정보">정보</option>
                            <option <?= $category == "스포츠" ? "selected" : "" ?> value="스포츠">스포츠</option>
                            <option <?= $category == "공부" ? "selected" : "" ?> value="공부">공부</option>
                            <option <?= $category == "먹거리" ? "selected" : "" ?> value="먹거리">먹거리</option>
                            <option <?= $category == "자유" ? "selected" : "" ?> value="자유">자유</option>
                        </select>
                        <select name="sort" class="sort-select">
                            <option <?= $sort == "date-asc" ? "selected" : "" ?> value="date-asc">등록일 오름차순</option>
                            <option <?= $sort == "date-desc" ? "selected" : "" ?> value="date-desc">등록일 내림차순</option>
                            <option <?= $sort == "like-asc" ? "selected" : "" ?> value="like-asc">좋아요 오름차순</option>
                            <option <?= $sort == "like-desc" ? "selected" : "" ?> value="like-desc">좋아요 내림차순</option>
                        </select>
                    </div>
                </div>

                <!-- 리스트 헤더 -->
                <div class="board__head">
                    <span style="text-align:center;">번호</span>
                    <span>제목</span>
                    <span>등록일</span>
                    <span style="text-align:right;">좋아요</span>
                </div>

                <!-- 게시글 목록 (10개씩 p1~p5) -->
                <div class="board__list">
                    <?php foreach ($posts as $post) {
                        $likeCount = db::fetch("select count(*) cnt from likes where post_idx = '$post->idx'")->cnt;
                    ?>
                        <div class="post"><span class="post__rank"><?= $post->idx ?></span><a href="/boardDetail/<?= $post->idx ?>" class="post__title"><?= $post->title ?></a><span class="post__date"><?= $post->date ?></span><span class="post__like"><svg viewBox="0 0 24 24">
                                    <path d="M12 21s-7.5-4.6-10-9.2C.3 8.5 1.9 5 5.2 5c2 0 3.3 1.1 4 2.2C9.8 6.1 11.2 5 13.1 5c3.3 0 4.9 3.5 3.2 6.8C19.5 16.4 12 21 12 21z" />
                                </svg><?= $likeCount ?></span></div>
                    <?php } ?>
                </div>

                <!-- 페이지 번호 버튼 (이전/다음 없음, 번호 클릭만) -->
                <div class="pager">
                    <a href="?page=<?= $page - 1 ?>" class="prevBtn <?= $page <= 1 ? 'disabled' : '' ?>">이전</a>
                    <?php for ($i = 1; $i <= $maxPage; $i++) { ?>
                        <a href="?page=<?= $i ?>" class="<?= $i == $page ? "active" : "" ?>"><?= $i ?></a>
                    <?php } ?>
                    <a href="?page=<?= $page + 1 ?>" class="nextBtn <?= $page >= $maxPage ? 'disabled' : '' ?>">다음</a>
                </div>

            </div>
        </div>
    </section>
    <div class="popup">
        <form action="/addPost" method="post" enctype="multipart/form-data" class="defualt-form">
            <div class="form-header">
                <h3>게시글 등록</h3>
                <button type="button" class="close-btn"
                    onclick="document.querySelector('.popup').style.display='none'">
                    ✕
                </button>
            </div>

            <input type="text" name="title" placeholder="제목" required>

            <textarea name="detail" placeholder="내용" required></textarea>

            <select name="category" required>
                <option value="">카테고리 선택</option>
                <option value="여행">여행</option>
                <option value="정보">정보</option>
                <option value="스포츠">스포츠</option>
                <option value="공부">공부</option>
                <option value="먹거리">먹거리</option>
                <option value="자유">자유</option>
                <?= $user->isAdmin == 1 ? "<option value='자유'>자유</option>" : "" ?>
            </select>

            <input type="file" name="file[]" multiple accept="image/*">

            <button class="submit-btn">등록</button>
        </form>
    </div>
</main>

<script src="/js/lib.js"></script>
<script>
    const category = $(".category-select");
    const keyword = $(".search-input");
    const sort = $(".sort-select");

    function search() {
        location.href = `/board?category=${category.value}&keyword=${keyword.value}&sort=${sort.value}`;
    }

    category.onchange = () => search();
    $(".search-btn").onclick = () => search();
    sort.onchange = () => search();
</script>