<?php
$user = ss();
$inquire = db::fetch("select i.*, u.id, u.profile from inquires i inner join users u on i.user_idx = u.idx where i.idx = '$idx'");
$comments = db::fetchAll("select i.*, u.id, u.profile, u.is_admin from inquire_comments i inner join users u on i.user_idx = u.idx where i.inquire_idx = '$idx' order by u.is_admin desc, i.date desc");
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
          <?php if ($user->is_admin == 1 && $inquire->answer == null) { ?>
            <form action="/addAnswer" method="post" class="admin-answer">
              <input type="hidden" name="idx" value="<?= $inquire->idx ?>">
              <textarea name="answer" placeholder="답변을 남겨주세요"></textarea>
              <button>답변 등록</button>
            </form>
          <?php } else { ?>
            <div class="answer-content">
              <h3>관리자의 답변</h3>
              <div class="content"><?= $inquire->answer ?></div>
            </div>
          <?php } ?>
        </div>
      </article>

      <section class="comments">
        <!-- 댓글 입력 폼 + 등록 버튼 -->
        <form method="post" action="/addInquireComment" class="comment-form">
          <input type="hidden" name="inquire_idx" value="<?= $idx ?>">
          <input type="text" name="content" class="comment-input" placeholder="따뜻한 댓글을 남겨주세요 :)" aria-label="댓글 입력">
          <button <?= $inquire->public == 0 ? "disabled" : "" ?>>등록</button>
        </form>
        <div class="inquire-comment-list">
          <?php foreach ($comments as $comment) {
            ?>
            <div class="comment">
              <img class="comment__avatar" src="<?= $comment->profile ?>"
                alt="송도주민 프로필 사진" title="송도주민">
              <div>
                <div class="comment__head">
                  <span class="comment__id"><?= $comment->is_admin == 1 ? "<span class='admin-tag'>관리자</span>" : "" ?><?= $comment->id ?></span>
                  <span class="comment__date"><?= $comment->date ?></span>
                </div>
                <div class="comment-content">
                  <p class="comment__text"><?= $comment->content ?></p>
                </div>
              </div>
            </div>
            <?php } ?>
            </div>
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
  $(".comment-input").onkeydown = e => {
    if (e.key === "Enter") e.preventDefault();
  }
</script>