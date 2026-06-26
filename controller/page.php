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
get("/inquire/{idx}", function ($idx) {
    views("inquire/inquire-detail", ["idx" => $idx]);
});
get("/profile/{idx}", function ($idx) {
    views("profile", ["idx" => $idx]);
});
get("/postAdmin", function () {
    views("admin/postAdmin");
});
get("/postAdmin", function () {
    views("admin/postAdmin");
});
get("/userAdmin", function () {
    views("admin/user");
});
get("/inquireAnswer", function () {
    views("admin/inquire");
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
        db::exec("insert into posts (title, detail, category, user_idx) values ('$title', '$detail', '$category', '$user->idx')");
        move("/board", "게시글 추가 성공");
    }
});
post('/deletePost', function () {
    extract($_POST);
    db::exec("delete from posts where idx = '$idx'");
    move("/", "게시글이 삭제 되었습니다");
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
post("/addAnswer", function () {
    extract($_POST);
    db::exec("update inquires set answer = '$answer' where idx = '$idx'");
    move("/inquire/$idx", "답변 추가 성공");
});
post("/addInquireComment", function () {
    extract($_POST);
    $user = ss();
    if ($user) {
        db::exec("insert into inquire_comments (content, user_idx, inquire_idx) values ('$content', '$user->idx', '$inquire_idx')");
        move("/inquire/$inquire_idx", "댓글 추가 성공");
    } else {
        move("/", "로그인 후 이용 가능한 기능입니다");
    }
});
post("/follow", function () {
    extract($_POST);
    $user = ss();
    if ($user) {
        db::exec("insert into follows (user_idx, target_user_idx) values ('$user->idx', '$target_user_idx')");
        move("/profile/$target_user_idx", "팔로우 성공");
    } else {
        move("/", "로그인 후 이용 가능한 기능입니다");
    }
});
post("/followCancel", function () {
    extract($_POST);
    $user = ss();
    db::exec("delete from follows where user_idx = '$user->idx' and target_user_idx = '$target_user_idx'");
    move("/profile/$target_user_idx", "팔로우 취소 성공");
});
get("/api/alert", function () {
    $user = ss();
    $following_new_post = db::fetch("select u.id from posts p inner join follows f on p.user_idx = f.target_user_idx inner join users u on u.idx = p.user_idx where f.user_idx = '$user->idx' and p.date > DATE_SUB(NOW(), INTERVAL 5 SECOND) order by p.date desc limit 1");
    $following_new_debate = db::fetch("select u.id from debates d inner join follows f on d.user_idx = f.target_user_idx inner join users u on u.idx = d.user_idx where f.user_idx = '$user->idx' and d.date > DATE_SUB(NOW(), INTERVAL 5 SECOND) order by d.date desc limit 1");

    if ($following_new_debate) {
        echo json_encode(["msg" => "$following_new_debate->id 님이 토론을 생성하였습니다"]);
    } else if ($following_new_post) {
        echo json_encode(["msg" => "$following_new_post->id 님이 게시글을 작성하였습니다"]);
    } else {
        echo json_encode(["msg" => null]);
    }
});
post("/block", function () {
    extract($_POST);
    $user = ss();
    $target_user = db::fetch("select id from users where idx = '$target_user_idx'")->id;
    if ($user) {
        db::exec("insert into blocks(user_idx, target_user_idx) values('$user->idx', '$target_user_idx')");
        move("/profile/$target_user_idx", "$target_user 님이 차단되었습니다.");
    } else {
        move("/", "로그인 후 이용 가능한 기능입니다");
    }
});
post("/blockCancel", function () {
    extract($_POST);
    $user = ss();
    $target_user = db::fetch("select id from users where idx = '$target_user_idx'")->id;
    db::exec("delete from blocks where user_idx = '$user->idx' and target_user_idx = '$target_user_idx'");
    move("/profile/$target_user_idx", "$target_user 님의 차단이 해제되었습니다.");
});
post("/userUpgrade", function () {
    extract($_POST);
    db::exec("update users set type = '$type' where idx = '$user_idx'");
    move("/userAdmin", "권한 변경 성공");
});
post("/userDelete", function () {
    extract($_POST);
    db::exec("delete from users where idx = '$user_idx'");
    move("/userAdmin", "유저 탈퇴 처리 성공");
});
post("/adminAnswer", function () {
    extract($_POST);
    db::exec("update inquires set answer = '$answer' where idx = '$inquire_idx'");
    move("/inquireAnswer", "관리자 답변 성공");
});
post('/ban', function () {
    extract($_POST);
    $date = date("Y-m-d", strtotime("+$days days"));
    db::exec("insert into bans(user_idx, date) values ('$user_idx', '$date')");
    move("/postAdmin", "이용 금지 처리되었습니다");
});
post("/banCancel", function() {
    extract($_POST);
    db::exec("delete from bans where user_idx = '$user_idx'");
    move("/postAdmin", "이용 금지 취소되었습니다");
});