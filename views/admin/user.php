<?php
if (ss()->type != 'admin') back("관리자만 접근 할 수 있는 페이지입니다");
$users = db::fetchAll("select * from users where type != 'admin' order by date desc");

?>

<section class="admin">
    <div class="container admin__grid">

        <!-- 메인 콘텐츠 -->
        <div class="admin__content">

            <div class="section-head section-head--left">
                <span class="eyebrow">User Management</span>
                <h2>회원 관리</h2>
                <p>전체 가입 회원을 모니터링하고 권한을 관리하세요.</p>
            </div>

            <!-- 상단 툴바: 검색 + 결과 수 -->
            <div class="admin__toolbar">
                <div class="admin__count">
                    총 <b id="userCount"><?= count($users) ?></b>명
                </div>
                <div class="search-box">
                    <input type="text" placeholder="이름 또는 아이디로 검색">
                    <button type="button">검색</button>
                </div>
            </div>

            <!-- 회원 리스트 -->
            <ul class="user-list">
                <?php foreach ($users as $user) { ?>

                    <!-- 1. 일반 회원 -->
                    <li class="user-item" data-role="<?= $user->type == 'general' ? "general" : ($user->type == 'post' ? "post" : ($user->type = 'debate' ? 'debate' : "")) ?>">
                        <div class="user-item__profile">
                            <a href="/profile/<?= $user->idx ?>">
                                <img src="<?= $user->profile ?>"
                                    alt="프로필" class="user-item__avatar">
                            </a>
                            <div class="user-item__meta">
                                <div class="user-item__name-row">
                                    <span class="user-item__name"><?= $user->name ?></span>
                                    <!-- 매니저 표식 (data-role 에 따라 표시) -->
                                    <span class="role-badge role-badge--post">게시판 매니저</span>
                                    <span class="role-badge role-badge--debate">토론 매니저</span>
                                </div>
                                <a href="/profile/<?= $user->idx ?>" class="user-item__id">@<?= $user->id ?></a>
                                <span class="user-item__date"><?= $user->date ?> 가입</span>
                            </div>
                        </div>

                        <form method="post" class="user-item__actions">
                            <input type="hidden" name="user_idx" value="<?= $user->idx ?>">
                            <button name="type" value="post" formaction="/userUpgrade" class="btn-admin btn-admin--promote">
                                게시판 매니저
                            </button>
                            <button name="type" value="debate" formaction="/userUpgrade" class="btn-admin btn-admin--promote">
                                토론 매니저
                            </button>
                            <button name="type" value="general" formaction="/userUpgrade" class="btn-admin btn-admin--demote">
                                일반 회원
                            </button>
                            <button formaction="/userDelete" class="btn-admin btn-admin--delete">
                                삭제
                            </button>
                        </form>
                    </li>
                <?php } ?>


                <!-- 2. 게시판 매니저 (data-role="post") -->

                <!-- 3. 토론 매니저 (data-role="debate") -->
            </ul>
        </div>
    </div>
</section>

</main>