<?php
$user = ss();
$post = db::fetch("select p.*, u.profile, u.id as user_id from posts p inner join users u on p.user_idx = u.idx where p.idx = '$idx'");
$likeCount = db::fetch("select count(*) cnt from likes where post_idx = '$idx'")->cnt;
$comments = db::fetchAll("select c.*, u.id, u.profile from comments c inner join users u on c.user_idx = u.idx where c.post_idx = '$idx' and c.user_idx = '$user->idx'");
$photos = explode(",", $post->photo);
?>

<main class="page">
  <section class="detail">
    <div class="container detail__wrap">

      <!-- 게시글 영역 (드래그 선택 방지: .article 에 user-select:none) -->
      <article class="article">
        <!-- 작성자: 프로필 사진 + 아이디 + 등록일 -->
        <div class="article__head">
          <img class="article__avatar" src="<?= $post->profile ?>"
            alt="작성자 프로필 사진" title="incheon_flyer">
          <div class="article__meta">
            <div class="id"><?= $post->user_id ?></div>
            <div class="date"><?= $post->date ?></div>
          </div>
        </div>

        <!-- 제목 -->
        <h1 class="article__title"><?= $post->title ?></h1>

        <!-- 내용 -->
        <div class="article__body">
          <?php if (isset($photos)) {
            foreach ($photos as $p) { ?>
              <img src="<?= $p ?>">
          <?php }
          } ?>
          <?= $post->detail ?>
        </div>

        <!-- 좋아요 수 + 좋아요 버튼 -->
        <div class="article__like">
          <button data-idx="<?= $post->idx ?>" class="like-btn" type="button">
            <svg viewBox="0 0 24 24">
              <path d="M12 21s-7.5-4.6-10-9.2C.3 8.5 1.9 5 5.2 5c2 0 3.3 1.1 4 2.2C9.8 6.1 11.2 5 13.1 5c3.3 0 4.9 3.5 3.2 6.8C19.5 16.4 12 21 12 21z" />
            </svg>
            좋아요 <strong class="like-count"><?= $likeCount ?></strong>
          </button>
        </div>
      </article>

      <!-- =========================================================
             게시글 댓글 영역
             - 프로필 사진 + 아이디 + 댓글 내용 + 등록일
             - 등록일 기준 내림차순 정렬
             - 댓글 입력 폼 + 등록 버튼
             ========================================================= -->
      <section class="comments">
        <h2 class="comments__title">댓글 <b><?= count($comments) ?></b></h2>

        <!-- 댓글 입력 폼 + 등록 버튼 -->
        <form method="post" action="/comment" class="comment-form">
          <input type="hidden" name="post_idx" value="<?= $idx ?>">
          <input type="text" name="content" placeholder="따뜻한 댓글을 남겨주세요 :)" aria-label="댓글 입력">
          <button>등록</button>
        </form>

        <!-- 댓글 목록 (등록일 내림차순) -->
        <?php foreach ($comments as $comment) { ?>
          <div class="comment">
            <img class="comment__avatar" src="<?= $comment->profile ?>"
              alt="송도주민 프로필 사진" title="송도주민">
            <div>
              <div class="comment__head">
                <span class="comment__id"><?= $comment->id ?></span>
                <span class="comment__date"><?= $comment->date ?></span>
              </div>
              <p class="comment__text"><?= $comment->content ?></p>
            </div>
          </div>
        <?php } ?>
      </section>

      <!-- 목록으로 -->
      <div style="text-align:center; margin-top:44px;">
        <a href="/board" class="btn btn--ghost">목록으로 돌아가기</a>
      </div>

    </div>
  </section>
</main>

<script src="/js/lib.js"></script>
<script>
  $(".like-btn").onclick = async e => {
    const idx = e.target.dataset.idx;

    const res = await fetch("/like", {
      method: "POST",
      body: new URLSearchParams({
        idx
      })
    })
    const data = await res.json();
    $(".like-count").textContent = data.count;
  }
</script>