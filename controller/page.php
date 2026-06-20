<?php

get("/", function() {
    views('main');
});
get("/sub1", function() {
    views('sub1');
});
get("/sub2", function() {
    views('sub2');
});
get("/sub3", function() {
    views('sub3');
});
get("/sub4", function() {
    views('sub4');
});
get("/register", function() {
    views('auth/register');
});
get("/login", function() {
    views('auth/login');
});
post("/signup", function() {
    extract($_POST);
    $file = $_FILES["file"];
    $path = "/asset/profile/" . $file["name"];
    if(move_uploaded_file($file["tmp_name"], ".$path")) {
        db::exec("insert into users(id, name, pw, profile) values ('$id','$name','$pw','$path')");
        move("/", "회원가입 성공");
    } else {
        back("회원가입 실패");
    }
});
post("/signin", function() {
    extract($_POST);
    $user = db::fetch("select * from users where id = '$id'");
    $token = bin2hex(random_bytes(32));
    if($user) {
        if($user->pw == $pw) {
            $_SESSION["ss"] = $user;
            db::exec("update users set login_token = '$token' where id = '$id'");
            move("/", "로그인 성공");
        } else {
            back("비밀번호가 일치하지 않습니다");
        }
    } else {
        back("로그인 실패");
    }
});
get("/logout", function() {
    session_destroy();
    move("/", "로그아웃 성공");
});