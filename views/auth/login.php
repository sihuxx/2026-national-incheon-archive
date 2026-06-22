<?php
$user = ss();
if($user) back("비회원 유저만 접근 가능한 페이지입니다");
?>

<main class="auth-page">
    <div class="intro__main">로그인</div>
    <form action="/signin" method="post" class="default-form">
        <label>아이디 <input type="text" name="id" required placeholder="아이디를 입력해주세요"></label>
        <label>비밀번호 <input type="password" name="pw" required placeholder="비밀번호를 입력해주세요"></label>
        <button>로그인</button>
    </form>
</main>