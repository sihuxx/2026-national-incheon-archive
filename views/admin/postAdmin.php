<?php
if (ss()->type != 'post') back("게시판 관리자만 접근 할 수 있는 페이지입니다");
$users = db::fetchAll("select * from users where idx in (select user_idx from posts)");

?>
<main class="page" style="padding:100px 0;">

  <section class="admin">
    <div class="container">

      <!-- 페이지 헤드 -->
      <div class="admin-head">
        <span class="eyebrow">Board Manager</span>
        <h2>게시판 회원 관리</h2>
        <p>게시글을 작성한 회원을 모니터링하고 작성 권한을 관리하세요.</p>
      </div>

      <!-- 툴바 -->
      <div class="admin__toolbar">
        <div class="admin__count">
          게시글 작성 회원 <b id="userCount">42</b>명
        </div>
        <div class="search-box">
          <input type="text" placeholder="아이디 또는 이름으로 검색">
          <button type="button">검색</button>
        </div>
      </div>

      <!-- 회원 리스트 -->
      <ul class="user-list">

        <!-- 일반 상태 (data-banned="false") -->
        <?php foreach ($users as $user) { 
          $is_banned = db::fetch("select * from bans where user_idx = '$user->idx'");
          ?>
          <li class="user-item" data-banned="<?= $is_banned ? "true" : "false" ?>" data-idx="<?= $user->idx ?>">
            <a class="user-item__avatar-link">
              <img src="<?= $user->profile ?>" alt="프로필" class="user-item__avatar">
            </a>
            <div class="user-item__meta">
              <div class="user-item__name-row">
                <span class="user-item__name"><?= $user->name ?></span>
                <!-- 이용금지 상태 표식 (밴일 때만 표시) -->
                <span class="ban-badge">이용금지</span>
              </div>
              <a class="user-item__id">@<?= $user->id ?></a>
              <!-- 이용 가능 일자 (밴일 때만 표시) -->
              <span class="user-item__ban-until">~ <?= $is_banned->date ?> 까지 제한</span>
            </div>
            <form method="POST" class="user-item__actions">
              <input type="hidden" name="user_idx" value="<?= $user->idx ?>">
              <!-- 일반: 이용금지 버튼 / 밴: 취소 버튼 (CSS가 data-banned로 전환) -->
              <button type="button" onclick="document.querySelector('#banModal<?= $user->idx ?>').classList.add('ban-modal--show')" class="btn-ban" data-open-ban>이용금지</button>
              <button formaction="/banCancel" class="btn-unban">취소</button>
            </form>
          </li>

          <div class="ban-modal" id="banModal<?= $user->idx ?>">
            <div class="ban-modal__panel">

              <div class="ban-modal__head">
                <h3 class="ban-modal__title">게시글 작성 권한 제한</h3>
                <button type="button" class="ban-modal__close" id="closeBanModal" onclick="document.querySelector('#banModal<?= $user->idx ?>').classList.remove('ban-modal--show')">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                  </svg>
                </button>
              </div>

              <p class="ban-modal__desc">
                선택한 기간 동안 해당 회원의 게시글 작성 권한이 제한됩니다.
              </p>

              <form action="/ban" method="post">
                <div class="ban-modal__field">
                  <label for="banPeriod" class="ban-modal__label">정지 기간</label>
                  <input type="hidden" name="user_idx" value="<?= $user->idx ?>">
                  <select name="days" id="banPeriod" class="ban-modal__select">
                    <option value="1">1일</option>
                    <option value="2">2일</option>
                    <option value="3">3일</option>
                    <option value="4">4일</option>
                    <option value="5">5일</option>
                    <option value="6">6일</option>
                    <option value="7">7일</option>
                  </select>
                </div>

                <div class="ban-modal__actions">
                  <button type="button" class="btn-ghost" onclick="document.querySelector('#banModal<?= $user->idx ?>').classList.remove('ban-modal--show')" id="cancelBanModal">취소</button>
                  <button  class="btn-ban-confirm" id="submitBan">이용금지</button>
                </div>
              </form>

            </div>
          </div>
        <?php } ?>
      </ul>
    </div>
  </section>

</main>