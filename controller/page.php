<?php

get("/", function () {
    views('main');
});
get("/board", function () {
    views('board/board');
});
get("/bestBoard", function () {
    views('board/best-board');
});
get("/boardDetail/{idx}", function ($idx) {
    views('board/board-detail', ["idx" => $idx]);
});
get("/debate", function () {
    views('debate/debate');
});
get("/bestDebate", function () {
    views('debate/best-debate');
});
get("/register", function () {
    views('auth/register');
});
get("/login", function () {
    views('auth/login');
});
post("/signup", function () {
    extract($_POST);
    $file = $_FILES["file"];
    $path = "/asset/profile/" . $file["name"];
    if (move_uploaded_file($file["tmp_name"], ".$path")) {
        db::exec("insert into users(id, name, pw, profile) values ('$id','$name','$pw','$path')");
        move("/", "회원가입 성공");
    } else {
        back("회원가입 실패");
    }
});
post("/signin", function () {
    extract($_POST);
    $user = db::fetch("select * from users where id = '$id'");
    $token = bin2hex(random_bytes(32));
    if ($user) {
        if ($user->pw == $pw) {
            db::exec("update users set login_token = '$token' where id = '$id'");
            $user->login_token = $token; // = "DB에 저장한 새 토큰을 PHP 객체에도 반영해줘!"
            $_SESSION["ss"] = $user;
            move("/", "로그인 성공");
        } else {
            back("비밀번호가 일치하지 않습니다");
        }
    } else {
        back("로그인 실패");
    }
});
get("/logout", function () {
    $user = ss();
    db::exec("update users set login_token = null where idx = '$user->idx'");
    // IS NULL은 WHERE에서 쓰는 거고 SET에서는 못 씀
    session_destroy();
    move("/", "로그아웃 성공");
});
post("/addPost", function () {
    extract($_POST);
    $images = [];
    $user = ss();
    $file = $_FILES["file"];
    foreach ($file["tmp_name"] as $i => $tmp) {
        if (!$tmp) continue;
        $path = "/asset/posts/" . $file["name"][$i];
        move_uploaded_file($tmp, ".$path");
        $images[] = $path;
    }
    $image = implode(",", $images);

    if ($image) {
        db::exec("insert into posts (title, detail, category, photo, user_idx) values ('$title', '$detail', '$category', '$image', '$user->idx')");
        move("/board", "게시글 추가 성공");
    } else {
        db::exec("insert into posts (title, detail, user_idx) values ('$title', '$detail', '$category', '$user->idx')");
        move("/board", "게시글 추가 성공");
    }
});
post("/like", function () {
    extract($_POST);
    $user = ss();
    $like = db::fetch("select * from likes where post_idx = '$idx' and user_idx = '$user->idx'");
    if ($like) {
        db::exec("delete from likes where idx = '$like->idx'");
    } else {
        db::exec("insert into likes (user_idx, post_idx) values ('$user->idx', '$idx')");
    }
    $count = db::fetch("select count(*) cnt from likes where post_idx = '$idx'")->cnt;
    echo json_encode(["count" => $count]);
    exit;
});
post("/comment", function () {
    extract($_POST);
    $user = ss();
    db::exec("insert into comments (post_idx, user_idx, content) values ('$post_idx', '$user->idx', '$content')");
    move("/boardDetail/$post_idx", "댓글 추가 성공");
});
