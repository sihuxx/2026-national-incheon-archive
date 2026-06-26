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
$is_banned = db::fetch("select * from bans where user_idx = '$user->idx'");
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
                <button class="post-add-btn" onclick="<?php
                if(!$user) {
                    echo "alert('로그인한 회원만 이용 가능합니다')";
                } else if ($is_banned) {
                    echo "alert('해당 서비스는 이용금지 상태입니다. $is_banned->date 부터 활동 가능합니다.')";
                } else {
                     echo "document.querySelector('.popup').style.display = 'flex'";
                }
                ?>">등록</button>
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
                <div class="board__head ">
                    <span style="text-align:center;">번호</span>
                    <span>제목</span>
                    <span>등록일</span>
                    <span style="text-align:center;">좋아요</span>
                    <?= $user->type == 'admin' ? "<span>관리</span>" : "" ?>
                </div>

                <!-- 게시글 목록 (10개씩 p1~p5) -->
                <div class="board__list">
                    <?php foreach ($posts as $post) {
                        $likeCount = db::fetch("select count(*) cnt from likes where post_idx = '$post->idx'")->cnt;
                    ?>
                        <div class="post"><span class="post__rank"><?= $post->idx ?></span><a href="/board/<?= $post->idx ?>" class="post__title"><?= $post->title ?></a><span class="post__date"><?= $post->date ?></span><span class="post__like"><svg viewBox="0 0 24 24" width="24" height="24">
                                    <path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z" />
                                </svg><?= $likeCount ?></span>
                            <form action="/deletePost" method="POST" class="admin-box">
                                <input type="hidden" name="idx" value="<?= $post->idx ?>">
                                <button>삭제</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>

                <!-- 페이지 번호 버튼 (이전/다음 없음, 번호 클릭만) -->
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
        <form action="/addPost" method="post" enctype="multipart/form-data" class="default-form">
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