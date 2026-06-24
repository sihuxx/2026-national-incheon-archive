<?php
$user = ss();
$page = $_GET["page"] ?? 1;
$limit = 10;
$start = ($page - 1) * $limit;
$total = db::fetch("select count(*) cnt from inquires")->cnt;
$maxPage = ceil($total / $limit);

$inquires = db::fetchAll("select * from inquires")
?>

<main class="page">

    <!-- 페이지 배너 -->
    <section class="page-banner">
        <div class="container">
            <h1>문의사항</h1>
            <p>궁금한 점이나 건의 사항을 남겨주세요</p>
        </div>
    </section>

    <section class="board">
        <div class="container">
            <div class="board__data">
                <!-- 툴바: 결과 수 + 정렬 셀렉트 -->
                <button class="post-add-btn" onclick="<?= $user ? "document.querySelector('.popup').style.display = 'flex'" : "alert('로그인한 회원만 이용 가능합니다')" ?>">등록</button>

                <!-- 리스트 헤더 -->
                <div class="board__head inquire__head">
                    <span style="text-align:center;">번호</span>
                    <span>제목</span>
                    <span>등록일</span>
                </div>

                <!-- 게시글 목록 (10개씩 p1~p5) -->
                <div class="board__list">
                    <?php foreach ($inquires as $inquire) {
                        $likeCount = db::fetch("select count(*) cnt from likes where post_idx = '$inquire->idx'")->cnt;
                    ?>
                        <div class="post inquire"><span class="post__rank"><?= $inquire->idx ?></span><a href="/inquire/<?= $inquire->idx ?>" class="post__title"><?= $inquire->title ?></a><span class="post__date"><?= $inquire->date ?></span>
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
        <form action="/addInquire" method="post" enctype="multipart/form-data" class="default-form">
            <div class="form-header">
                <h3>문의사항 등록</h3>
                <button type="button" class="close-btn"
                    onclick="document.querySelector('.popup').style.display='none'">
                    ✕
                </button>
            </div>

            <input type="text" name="title" placeholder="제목" required>

            <textarea name="content" placeholder="내용" required></textarea>

            <input type="file" name="file">

            <select name="public">
                <option value="1">공개</option>
                <option value="0">비공개</option>
            </select>

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