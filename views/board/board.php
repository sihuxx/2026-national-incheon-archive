<?php
$user = ss();
$page = $_GET["page"] ?? 1;
$limit = 10;
$start = ($page - 1) * $limit;
$posts = db::fetchAll("select * from posts order by idx desc limit $start, $limit");
$total = db::fetch("select count(*) cnt from posts")->cnt;
$maxPage = ceil($total / $limit);
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
                        <input type="text" placeholder="검색어를 입력해주세요">
                        <button>검색</button>
                    </div>
                    <div class="sortbox">
                        <select name="category" class="category-select">
                            <option value="전체">전체</option>
                            <option value="공지사항">공지사항</option>
                            <option value="여행">여행</option>
                            <option value="정보">정보</option>
                            <option value="스포츠">스포츠</option>
                            <option value="공부">공부</option>
                            <option value="먹거리">먹거리</option>
                            <option value="자유">자유</option>
                        </select>
                        <div class="sortbox__group">
                            <label class="sortbox__label" for="sort-desc">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 5h10M11 9h7M11 13h4M3 17l3 3 3-3M6 18V4" />
                                </svg>
                                좋아요 많은순
                            </label>
                            <label class="sortbox__label" for="sort-asc">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 5h4M11 9h7M11 13h10M3 7l3-3 3 3M6 6v14" />
                                </svg>
                                좋아요 적은순
                            </label>
                        </div>
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
                        <div class="post p5"><span class="post__rank"><?= $post->idx ?></span><a href="/boardDetail/<?= $post->idx ?>" class="post__title"><?= $post->title ?></a><span class="post__date"><?= $post->date ?></span><span class="post__like"><svg viewBox="0 0 24 24">
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
        <form action="/addPost" method="post" enctype="multipart/form-data" class="default-form">
            <div class="form-header">
                <h3 class="title">게시글 등록</h3>
                <span class="btn" onclick="document.querySelector('.popup').style.display = 'none'">닫기</span>
            </div>
            <label>제목<input type="text" name="title" required placeholder="게시글 제목"></label>
            <label>내용<textarea name="detail" required placeholder="게시글 내용"></textarea></label>
            <label>카테고리<select name="category" id="" required>
                    <option value="여행">여행</option>
                    <option value="정보">정보</option>
                    <option value="스포츠">스포츠</option>
                    <option value="공부">공부</option>
                    <option value="먹거리">먹거리</option>
                    <option value="자유">자유</option>
                </select></label>
            <label>사진 첨부파일<input type="file" name="file" id=""></label>
            <button>등록</button>
        </form>
    </div>
</main>