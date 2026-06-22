<?php
$user = ss();
if($user) back("비회원 유저만 접근 가능한 페이지입니다");
?>

<main class="auth-page">
    <div class="intro__main">회원가입</div>
    <form action="/signup" method="post" enctype="multipart/form-data" class="default-form">
        <label>아이디 <input type="text" name="id" required placeholder="아이디를 입력해주세요"></label>
        <label>비밀번호 <input type="password" name="pw" required placeholder="비밀번호를 입력해주세요"></label>
        <label>이름 <input type="text" name="name" required placeholder="이름를 입력해주세요"></label>
        <label>프로필 사진 <input type="file" name="file" required></label>
        <button>회원가입</button>
    </form>
</main>

<script src="/js/lib.js"></script>
<script>
    function validate() {
        if(!/^[A-Za-z0-9]{4,12}$/.test($("[name='id']"))) return; alert("아이디 형식이 올바르지 않습니다");
        if(!/^[가-힣]+$/.test(name)) return alert("이름은 한글만 입력 가능합니다")
        if(!/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,12}$/.test(pw)) return alert("비밀번호 형식이 올바르지 않습니다")
        if(!file || !file.type.startsWith("image/")) return alert("이미지 파일만 업로드 가능합니다")
    }
$$("input").forEach(input => {
    input.onchange = () => validate();
})
</script>