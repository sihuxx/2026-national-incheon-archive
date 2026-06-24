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
get("/board/{idx}", function ($idx) {
    views('board/board-detail', ["idx" => $idx]);
});
get("/debate", function () {
    views('debate/debate');
});
get("/debate/{idx}", function ($idx) {
    views("debate/debate-detail", ["idx" => $idx]);
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
get("/inquire", function () {
    views("inquire/inquire");
});
get("/inquire/{idx}", function($idx) {
    views("inquire/inquire-detail", ["idx" => $idx]);
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
post('/deletePost', function () {
    extract($_POST);
    db::exec("delete from posts where idx = '$idx'");
    db::exec("delete from comments where post_idx = '$idx'");
    db::exec("delete from likes where post_idx = '$idx'");
    move("/", "게시글이 추가되었습니다");
});
post("/like", function () {
    extract($_POST);
    $user = ss();
    $liked = false;
    $like = db::fetch("select * from likes where post_idx = '$idx' and user_idx = '$user->idx'");
    if ($like) {
        db::exec("delete from likes where idx = '$like->idx'");
        $liked = false;
    } else {
        db::exec("insert into likes (user_idx, post_idx) values ('$user->idx', '$idx')");
        $liked = true;
    }
    $count = db::fetch("select count(*) cnt from likes where post_idx = '$idx'")->cnt;

    echo json_encode(["count" => $count, "liked" => $liked]);
    exit;
});
post("/comment", function () {
    extract($_POST);
    $user = ss();
    if ($user) {
        db::exec("insert into comments (post_idx, user_idx, content) values ('$post_idx', '$user->idx', '$content')");
        move("/boardDetail/$post_idx", "댓글 추가 성공");
    } else {
        move("/", "로그인한 회원만 이용 가능한 기능입니다");
    }
});
post("/commentLike", function () {
    extract($_POST);
    $user = ss();
    $post_idx = db::fetch("select post_idx from comments where idx = '$idx'")->post_idx;
    $liked = false;
    $like = db::fetch("select * from comments_likes where comment_idx = '$idx' and user_idx = '$user->idx'");

    if ($like) {
        db::exec("delete from comments_likes where comment_idx = '$idx'");
        $liked = false;
    } else {
        db::exec("insert into comments_likes(comment_idx, user_idx, post_idx) values ('$idx', '$user->idx', '$post_idx')");
        $liked = true;
    }
    $count = db::fetch("select count(*) as cnt from comments_likes where comment_idx = '$idx'")->cnt;

    echo json_encode(["count" => $count, "liked" => $liked]);
    exit;
});
post("/addDebate", function () {
    extract($_POST);
    $user = ss();
    if (db::fetch("select * from debates where title = '$title'")) {
        back("이미 동일한 토론이 존재합니다");
    } else {
        db::exec("insert into debates(title, user_idx) values('$title', '$user->idx')");
        move("/debate", "토론 추가 성공");
    }
});
post("/deleteDebate", function () {
    extract($_POST);
    db::exec("delete from debates where idx = '$idx'");
    move("/debate", "토론 삭제 성공");
});
post("/agree", function () {
    extract($_POST);
    $user = ss();
    if ($user) {
        db::exec("insert into opinions(user_idx, debate_idx, type) values('$user->idx', '$idx', 1)");
        echo json_encode(["completed" => true]);
        exit;
    } else {
        back("로그인 후 이용 가능한 기능입니다");
    }
});
post("/oppose", function () {
    extract($_POST);
    $user = ss();
    if ($user) {
        db::exec("insert into opinions(user_idx, debate_idx, type) values('$user->idx', '$idx', 0)");
        echo json_encode(["completed" => true]);
        exit;
    } else {
        back("로그인 후 이용 가능한 기능입니다");
    }
});
post("/addOpinion", function () {
    extract($_POST);
    $user = ss();
    db::exec("insert into debate_opinions(content, user_idx, debate_idx) values('$content', '$user->idx', '$debate_idx')");
    move("/debate/$debate_idx", "의견이 작성되었습니다");
});
get("/api/opinions/{debateIdx}", function ($debateIdx) {
    echo json_encode(db::fetchAll("select do.*, u.id, u.profile, u.idx user_idx, o.type from debate_opinions do left join users u on u.idx = do.user_idx inner join opinions o on o.user_idx = u.idx and o.debate_idx = '$debateIdx' where do.debate_idx = '$debateIdx'"));
});
post("/addInquire", function () {
    extract($_POST);
    $user = ss();
    $file = $_FILES["file"];
    $path = "/asset/inquires/" . $file["name"];
    if (isset($file["tmp_name"]) && move_uploaded_file($file["tmp_name"], ".$path")) {
        db::exec("insert into inquires(title, content, img, public, user_idx) values('$title', '$content', '$path', '$public', '$user->idx')");
        move("/inquire", "문의사항 등록 성공");
    } else {
        db::exec("insert into inquires(title, content, public, user_idx) values('$title', '$content', '$public', '$user->idx')");
        move("/inquire", "문의사항 등록 성공");
    }
});
