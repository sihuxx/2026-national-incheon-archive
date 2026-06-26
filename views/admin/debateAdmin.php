
  <main class="page" style="padding-top:0;">

    <section class="admin">
      <div class="container">

        <!-- 페이지 헤드 -->
        <div class="admin-head">
          <span class="eyebrow">Debate Manager</span>
          <h2>토론 회원 관리</h2>
          <p>토론을 생성한 회원을 모니터링하고 토론 생성·의견 작성 권한을 관리하세요.</p>
        </div>

        <!-- 툴바 -->
        <div class="admin__toolbar">
          <div class="admin__count">
            토론 생성 회원 <b id="userCount">27</b>명
          </div>
          <div class="search-box">
            <input type="text" placeholder="아이디 또는 이름으로 검색">
            <button type="button">검색</button>
          </div>
        </div>

        <!-- 회원 리스트 -->
        <ul class="user-list">

          <!-- 일반 상태 (data-banned="false") -->
          <li class="user-item" data-banned="false" data-idx="1">
            <a href="userpage.html" class="user-item__avatar-link">
              <img src="/asset/image/avatar-default.jpg" alt="프로필" class="user-item__avatar">
            </a>
            <div class="user-item__meta">
              <div class="user-item__name-row">
                <span class="user-item__name">홍길동</span>
                <span class="ban-badge">이용금지</span>
              </div>
              <a href="userpage.html" class="user-item__id">@hong_gildong</a>
              <span class="user-item__ban-until">~ 2026-07-03 까지 제한</span>
            </div>
            <div class="user-item__actions">
              <button type="button" class="btn-ban" data-open-ban>이용금지</button>
              <button type="button" class="btn-unban">취소</button>
            </div>
          </li>

          <!-- 이용금지 상태 (data-banned="true") -->
          <li class="user-item" data-banned="true" data-idx="2">
            <a href="userpage.html" class="user-item__avatar-link">
              <img src="/asset/image/avatar-default.jpg" alt="프로필" class="user-item__avatar">
            </a>
            <div class="user-item__meta">
              <div class="user-item__name-row">
                <span class="user-item__name">김인천</span>
                <span class="ban-badge">이용금지</span>
              </div>
              <a href="userpage.html" class="user-item__id">@kim_incheon</a>
              <span class="user-item__ban-until">~ 2026-07-01 까지 제한</span>
            </div>
            <div class="user-item__actions">
              <button type="button" class="btn-ban" data-open-ban>이용금지</button>
              <button type="button" class="btn-unban">취소</button>
            </div>
          </li>

          <!-- 일반 상태 -->
          <li class="user-item" data-banned="false" data-idx="3">
            <a href="userpage.html" class="user-item__avatar-link">
              <img src="/asset/image/avatar-default.jpg" alt="프로필" class="user-item__avatar">
            </a>
            <div class="user-item__meta">
              <div class="user-item__name-row">
                <span class="user-item__name">박송도</span>
                <span class="ban-badge">이용금지</span>
              </div>
              <a href="userpage.html" class="user-item__id">@park_songdo</a>
              <span class="user-item__ban-until">~ 2026-07-03 까지 제한</span>
            </div>
            <div class="user-item__actions">
              <button type="button" class="btn-ban" data-open-ban>이용금지</button>
              <button type="button" class="btn-unban">취소</button>
            </div>
          </li>

        </ul>

        <!-- 페이징 -->
        <div class="pager">
          <a href="#" class="disabled">◀</a>
          <a href="#" class="active">1</a>
          <a href="#">2</a>
          <a href="#">3</a>
          <a href="#">▶</a>
        </div>

      </div>
    </section>

  </main>

  <!-- =========================================================
       이용금지 기간 설정 모달
       ========================================================= -->
  <div class="ban-modal" id="banModal">
    <div class="ban-modal__panel">

      <div class="ban-modal__head">
        <h3 class="ban-modal__title">토론 생성·의견 작성 권한 제한</h3>
        <button type="button" class="ban-modal__close" id="closeBanModal">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <p class="ban-modal__desc">
        선택한 기간 동안 해당 회원의 토론 생성 및 의견 작성 권한이 제한됩니다.
      </p>

      <div class="ban-modal__field">
        <label for="banPeriod" class="ban-modal__label">정지 기간</label>
        <select id="banPeriod" class="ban-modal__select">
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
        <button type="button" class="btn-ghost" id="cancelBanModal">취소</button>
        <button type="button" class="btn-ban-confirm" id="submitBan">이용금지</button>
      </div>

    </div>
  </div>