<?php
$user = ss();
$debate = db::fetch("select d.*, u.id user_id, u.profile from debates d inner join users u on d.user_idx = u.idx where d.idx = '$idx'");
$is_compelted = db::fetch("select * from opinions where user_idx = '$user->idx' and debate_idx = '$idx'");
$opinions = db::fetchAll("select o.*, u.id, u.profile from debate_opinions o inner join users u on o.user_idx = u.idx where debate_idx = '$idx'");
?>

<main class="page">
  <section class="detail">
    <div class="container detail__wrap">

      <!-- 토론 영역 (드래그 선택 방지) -->
      <article class="article">
        <div class="article__head">
          <img class="article__avatar" src="<?= $debate->profile ?>"
            alt="토론 개설자 프로필 사진" title="incheon_voice">
          <div class="article__meta">
            <div class="id"><?= $debate->user_id ?></div>
            <div class="date"><?= $debate->date ?></div>
          </div>
        </div>

        <h1 class="article__title"><?= $debate->title ?></h1>

        <div class="article__body">
        </div>
      </article>

      <!-- 토론 의견 영역 (댓글 = 등록일 내림차순 + 입력폼/등록버튼) -->
      <section class="comments">
        <h2 class="comments__title">의견 <b><?= count($opinions) ?></b></h2>

        <form method="post" action="/addOpinion" class="comment-form">
          <input type="hidden" name="debate_idx" value="<?= $idx ?>">
          <input type="text" class="opinion-input" name="content" placeholder="토론에 대한 의견을 남겨주세요" aria-label="의견 입력">
          <button class="opinion-add-btn">등록</button>
        </form>

        <div class="opinions-list">
        </div>
      </section>

      <div style="text-align:center; margin-top:44px;">
        <a href="/debate" class="btn btn--ghost">토론 목록으로 돌아가기</a>
      </div>

    </div>
  </section>
</main>

<div class="popup <?= $is_compelted ? 'hidden' : "" ?>">
  <div class="popup-content">
    <h1 class="title"><?= $debate->title ?></h1>
    <div class="opinions-box">
      <button data-route="/agree" data-idx="<?= $debate->idx ?>" class="agree opinion-vote">찬성</button>
      <button data-route="/oppose" data-idx="<?= $debate->idx ?>" class="oppose opinion-vote">반대</button>
    </div>
  </div>
</div>

<script src="/js/lib.js"></script>
<script>
  const opinionList = $(".opinions-list");
  $(".popup").style.display = 'flex';
  $$(".opinions-box .opinion-vote").forEach(btn => btn.onclick = async e => {
    const idx = e.target.dataset.idx;
    const route = e.target.dataset.route;

    const res = await fetch(`${route}`, {
      method: "POST",
      body: new URLSearchParams({
        idx
      })
    });
    const data = await res.json();
    $(".popup").style.display = data.completed ? "none" : 'flex';
  })

  $(".opinion-add-btn").onclick = () => {
    if ($(".opinion-input").value == "") return alert("아무것도 입력되지 않았습니다");
  }


  const render = async () => {
    const idx = <?= json_decode($idx) ?>;
    const data = await fetch(`/api/opinions/${idx}`).then(res => res.json());
    const user_idx = <?= $user->idx ?>;

      opinionList.innerHTML = data.map((item) => {
        return ` <div class="comment opinion ${item.user_idx == user_idx ? "my-opinion" : ""}">
          <img class="comment__avatar" src="${item.profile}">
          <div>
            <div class="comment__head">
              <span class="vote-tag agree-tag">${item.type ? "찬성" : '반대'}</span>
              <span class="comment__id">${item.id}</span>
              <span class="comment__date">${item.date}</span>
            </div>
            <div class="comment-content">
              <p class="comment__text">${item.content}</p>
            </div>
          </div>
        </div>`;
    }).join('');

  }

  render();


  setInterval(render, 500);
</script>
