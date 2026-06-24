<?php
$user = ss();
$inquire = db::fetch("select i.*, u.id, u.profile from inquires i inner join users u on i.user_idx = u.idx where i.idx = '$idx' and i.public = 1 order by date desc");
?>

<main class="page">
  <section class="detail">
    <div class="container detail__wrap">

      <!-- 게시글 영역 (드래그 선택 방지: .article 에 user-select:none) -->
      <article class="article">
        <!-- 작성자: 프로필 사진 + 아이디 + 등록일 -->
        <div class="article__head">
          <img class="article__avatar" src="<?= $inquire->profile ?>"
            alt="작성자 프로필 사진" title="incheon_flyer">
          <div class="article__meta">
            <div class="id"><?= $inquire->id ?></div>
            <div class="date"><?= $inquire->date ?></div>
          </div>
        </div>

        <!-- 제목 -->
        <h1 class="article__title"><?= $inquire->title ?></h1>

        <!-- 내용 -->
        <div class="article__body">
          <img oncontextmenu="return false" alt="<?= $inquire->img ?>" src="<?= $inquire->img ?>">
          <?= $inquire->content ?>
        </div>
      </article>

      <section class="comments">
        <!-- 댓글 입력 폼 + 등록 버튼 -->
        <form method="post" action="/comment" class="comment-form">
          <input type="hidden" name="post_idx" value="<?= $idx ?>">
          <input type="text" name="content" placeholder="문의사항 답변을 남겨주세여" aria-label="댓글 입력">
          <button>등록</button>
        </form>
            <?php foreach ($comments as $comment) {
          $commentLikeCount = db::fetch("select count(*) cnt from comments_likes where comment_idx = '$comment->idx'")->cnt;
        ?>
          <div class="comment">
            <img class="comment__avatar" src="<?= $comment->profile ?>"
              alt="송도주민 프로필 사진" title="송도주민">
            <div>
              <div class="comment__head">
                <span class="comment__id"><?= $comment->id ?></span>
                <span class="comment__date"><?= $comment->date ?></span>
              </div>
              <div class="comment-content">
                <p class="comment__text"><?= $comment->content ?></p>
                <div class="like-btn comment-like-btn <?= db::fetch("select * from comments_likes where comment_idx = '$comment->idx' and user_idx = '$user->idx'") ? 'active' : "" ?>" data-idx="<?= $comment->idx ?>">
                  <svg viewBox="0 0 24 24" width="24" height="24">
                    <path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z" />
                  </svg>
                  <span class="comment-like-count"><?= $commentLikeCount ?></span>
                </div>
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