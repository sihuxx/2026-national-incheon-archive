 <main class="page" style="padding-top:0;">

    <section class="admin">
      <div class="container admin__grid">

        <!-- 메인 콘텐츠 -->
        <div class="admin__content">

          <div class="section-head section-head--left">
            <span class="eyebrow">Inquiries</span>
            <h2>문의 사항 답변</h2>
            <p>회원들의 문의에 대한 답변을 작성하고 관리하세요.</p>
          </div>

          <!-- 상단 툴바: 카운트 -->
          <div class="admin__toolbar">
            <div class="admin__count">
              답변 대기 <b id="pendingCount">5</b>건 / 전체 <b id="totalCount">23</b>건
            </div>
          </div>

          <!-- 문의 목록 (오래된 순) -->
          <ul class="inquiry-list">

            <!-- 답변 대기 -->
            <li class="inquiry-item" data-status="pending">
              <span class="inquiry-item__num">01</span>
              <div class="inquiry-item__body">
                <button type="button" class="inquiry-item__title" data-open-modal>
                  계정 비밀번호를 잊어버렸어요. 어떻게 찾을 수 있나요?
                </button>
                <div class="inquiry-item__meta">
                  <span class="inquiry-item__author">@lost_user</span>
                  <span class="inquiry-item__dot">·</span>
                  <span class="inquiry-item__date">2026-02-01</span>
                </div>
              </div>
              <span class="status-tag status-tag--pending">답변 대기</span>
            </li>

            <!-- 답변 완료 -->
            <li class="inquiry-item" data-status="done">
              <span class="inquiry-item__num">02</span>
              <div class="inquiry-item__body">
                <a href="inquiry_detail.html" class="inquiry-item__title">
                  내가 작성한 게시글이 갑자기 사라졌어요
                </a>
                <div class="inquiry-item__meta">
                  <span class="inquiry-item__author">@incheon_lover</span>
                  <span class="inquiry-item__dot">·</span>
                  <span class="inquiry-item__date">2026-02-08</span>
                </div>
              </div>
              <span class="status-tag status-tag--done">답변 완료</span>
            </li>

            <!-- 답변 대기 -->
            <li class="inquiry-item" data-status="pending">
              <span class="inquiry-item__num">03</span>
              <div class="inquiry-item__body">
                <button type="button" class="inquiry-item__title" data-open-modal>
                  토론 게시판에 글이 등록이 안 됩니다
                </button>
                <div class="inquiry-item__meta">
                  <span class="inquiry-item__author">@debate_fan</span>
                  <span class="inquiry-item__dot">·</span>
                  <span class="inquiry-item__date">2026-02-15</span>
                </div>
              </div>
              <span class="status-tag status-tag--pending">답변 대기</span>
            </li>

            <!-- 답변 완료 -->
            <li class="inquiry-item" data-status="done">
              <span class="inquiry-item__num">04</span>
              <div class="inquiry-item__body">
                <a href="inquiry_detail.html" class="inquiry-item__title">
                  프로필 사진 변경 방법을 알려주세요
                </a>
                <div class="inquiry-item__meta">
                  <span class="inquiry-item__author">@newbie_2026</span>
                  <span class="inquiry-item__dot">·</span>
                  <span class="inquiry-item__date">2026-02-22</span>
                </div>
              </div>
              <span class="status-tag status-tag--done">답변 완료</span>
            </li>

            <!-- 답변 대기 -->
            <li class="inquiry-item" data-status="pending">
              <span class="inquiry-item__num">05</span>
              <div class="inquiry-item__body">
                <button type="button" class="inquiry-item__title" data-open-modal>
                  댓글 알림이 오지 않는 문제 신고합니다
                </button>
                <div class="inquiry-item__meta">
                  <span class="inquiry-item__author">@silent_owl</span>
                  <span class="inquiry-item__dot">·</span>
                  <span class="inquiry-item__date">2026-03-03</span>
                </div>
              </div>
              <span class="status-tag status-tag--pending">답변 대기</span>
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
      </div>
    </section>

  </main>

  <!-- =========================================================
       답변 작성 모달
       - 답변 대기 상태의 문의를 클릭하면 표시
       - JS에서 .answer-modal--show 클래스 토글
       ========================================================= -->
  <div class="answer-modal" id="answerModal">
    <div class="answer-modal__panel">

      <div class="answer-modal__head">
        <h3 class="answer-modal__title">문의 답변 작성</h3>
        <button type="button" class="answer-modal__close" id="closeModal">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg>
        </button>
      </div>

      <!-- 원본 문의 내용 -->
      <div class="answer-modal__quote">
        <div class="answer-modal__quote-head">
          <span class="answer-modal__quote-author" id="modalAuthor">@lost_user</span>
          <span class="answer-modal__quote-date" id="modalDate">2026-02-01</span>
        </div>
        <p class="answer-modal__quote-title" id="modalQuestion">
          계정 비밀번호를 잊어버렸어요. 어떻게 찾을 수 있나요?
        </p>
        <p class="answer-modal__quote-body">
          최근에 비밀번호를 변경했는데, 기억이 잘 나지 않습니다.
          이메일로 인증을 받거나 다른 방법으로 찾을 수 있나요?
        </p>
      </div>

      <!-- 답변 입력 -->
      <div class="answer-modal__field">
        <label for="answerInput" class="answer-modal__label">답변 내용</label>
        <textarea id="answerInput"
                  class="answer-modal__textarea"
                  placeholder="답변 내용을 입력하세요"></textarea>
      </div>

      <div class="answer-modal__actions">
        <button type="button" class="btn-admin btn-admin--ghost" id="cancelModal">취소</button>
        <button type="button" class="btn-admin btn-admin--primary" id="submitAnswer">답변</button>
      </div>

    </div>
  </div>
