 <?php
  if (ss()->type != 'admin') back("관리자만 접근 할 수 있는 페이지입니다");
  $inquires = db::fetchAll("select i.*, u.id as user_id from inquires i inner join users u on i.user_idx = u.idx order by date");
  $pendingInquires = db::fetchAll("select * from inquires where answer is null");
  ?>

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
             답변 대기 <b id="pendingCount"><?= count($pendingInquires) ?></b>건 / 전체 <b id="totalCount"><?= count($inquires) ?></b>건
           </div>
         </div>

         <!-- 문의 목록 (오래된 순) -->
         <ul class="inquiry-list">
           <?php foreach ($inquires as $inquire) { ?>
             <li class="inquiry-item" data-status="pending">
               <span class="inquiry-item__num"><?= $inquire->idx ?></span>
               <div class="inquiry-item__body">
                 <?php if ($inquire->answer == null) { ?>
                   <button type="button" class="inquiry-item__title" onclick="document.querySelector('#answerModal<?= $inquire->idx ?>').classList.add('answer-modal--show')">
                     <?= $inquire->title ?>
                   </button>
                 <?php } else { ?>
                   <a href="/inquire/<?= $inquire->idx ?>" class="inquiry-item__title">
                     <?= $inquire->title ?>
                   </a>
                 <?php } ?>
                 <div class="inquiry-item__meta">
                   <span class="inquiry-item__author">@<?= $inquire->user_id ?></span>
                   <span class="inquiry-item__dot">·</span>
                   <span class="inquiry-item__date"><?= $inquire->date ?></span>
                 </div>
               </div>
               <span class="status-tag status-tag--<?= $inquire->answer == null ? "pending" : "done" ?>"><?= $inquire->answer == null ? "답변 대기" : "답변 완료" ?></span>
             </li>


             <div class="answer-modal" id="answerModal<?= $inquire->idx ?>">
               <div class="answer-modal__panel">

                 <div class="answer-modal__head">
                   <h3 class="answer-modal__title">문의 답변 작성</h3>
                   <button type="button" class="answer-modal__close" id="closeModal" onclick="document.querySelector('#answerModal<?= $inquire->idx ?>').classList.remove('answer-modal--show')">
                     <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                       <line x1="18" y1="6" x2="6" y2="18" />
                       <line x1="6" y1="6" x2="18" y2="18" />
                     </svg>
                   </button>
                 </div>

                 <!-- 원본 문의 내용 -->
                 <div class="answer-modal__quote">
                   <div class="answer-modal__quote-head">
                     <span class="answer-modal__quote-author" id="modalAuthor">@<?= $inquire->user_id ?></span>
                     <span class="answer-modal__quote-date" id="modalDate"><?= $inquire->date ?></span>
                   </div>
                   <p class="answer-modal__quote-title" id="modalQuestion">
                     <?= $inquire->title ?>
                   </p>
                   <p class="answer-modal__quote-body">
                     <?= $inquire->content ?>
                   </p>
                 </div>

                 <!-- 답변 입력 -->
                 <form action="/adminAnswer" method="post">
                   <div class="answer-modal__field">
                     <label for="answerInput" class="answer-modal__label">답변 내용</label>
                     <input type="hidden" name="inquire_idx" value="<?= $inquire->idx ?>">
                     <textarea id="answerInput"
                       class="answer-modal__textarea"
                       placeholder="답변 내용을 입력하세요" name="answer"></textarea>
                   </div>

                   <div class="answer-modal__actions">
                     <button type="button" class="btn-admin btn-admin--ghost" id="cancelModal" onclick="document.querySelector('#answerModal<?= $inquire->idx ?>').classList.remove('answer-modal--show')">취소</button>
                     <button class="btn-admin btn-admin--primary" id="submitAnswer">답변</button>
                   </div>
                 </form>

               </div>
             </div>
           <?php } ?>
         </ul>

       </div>
     </div>
   </section>

 </main>

 <script src="/js/lib.js"></script>
 <script>
 </script>