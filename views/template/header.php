<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>베스트 게시판 | 인천 아카이브</title>
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/common.css">
  <link rel="stylesheet" href="/css/sub.css">
</head>

<body>

  <?php
  $user = ss();
  ?>

  <!-- 헤더 (모든 페이지 공통 · 상단 고정) -->
  <header class="header">
    <div class="container header__inner">
      <a href="/" class="logo" title="인천 아카이브 홈으로">
        <svg class="logo__symbol" viewBox="0 0 48 48" fill="none" aria-hidden="true">
          <rect width="48" height="48" rx="13" fill="#21a366" />
          <path d="M24 12c-4 3-8 3-11 1v17c3 2 7 2 11-1 4 3 8 3 11 1V13c-3 2-7 2-11-1Z" fill="#fff" opacity="0.95" />
          <path d="M13 31c3 2 7 2 11-1 4 3 8 3 11 1" stroke="#0f3d2e" stroke-width="2" stroke-linecap="round" />
          <path d="M13 36c3 2 7 2 11-1 4 3 8 3 11 1" stroke="#6fcf97" stroke-width="2" stroke-linecap="round" />
          <circle cx="24" cy="20" r="2.4" fill="#21a366" />
        </svg>
        <span class="logo__text">인천 <span>아카이브</span></span>
      </a>
      <nav>
        <ul class="gnb">
          <li><a href="#">문의사항</a></li>
          <li><a href="#">게시판</a>
            <ul class="submenu">
              <li><a href="/sub1">베스트 게시판</a></li>
              <li><a href="#">전체 게시판</a></li>
            </ul>
          </li>
          <li><a href="#">토론</a>
            <ul class="submenu">
              <li><a href="/sub2">베스트 토론</a></li>
              <li><a href="#">전체 토론</a></li>
            </ul>
          </li>
          <li><a href="#">마이페이지</a></li>
        </ul>
      </nav>
      <div class="header__actions">
        <?php if ($user) { ?>
          <a class="btn-btn--ghost user-link">
            <img src="<?= $user->profile ?>" class="profile-image">
            <p><?= $user->id ?></p>
          </a>
          <a href="/logout" class="btn-btn--primary">로그아웃</a>
        <?php } else { ?>
          <a href="/login" class="btn btn--ghost">로그인</a>
          <a href="/register" class="btn btn--primary">회원가입</a>
        <?php } ?>
      </div>
    </div>
  </header>