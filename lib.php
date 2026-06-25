<?php

function move($page, $msg = false)
{
    if ($msg)  echo "<script>alert('$msg')</script>";
    echo "<script>location.href = '$page'</script>";
}
function back($msg)
{
    if ($msg)  echo "<script>alert('$msg')</script>";
    echo "<script>history.back()</script>";
}
function views($page, $data = [])
{
    extract($data);
    require_once "../views/template/header.php";
    require_once "../views/$page.php";
    require_once "../views/template/footer.php";
}
function ss()
{
    return $_SESSION["ss"] ?? false;
}

function token()
{
    $session = $_SESSION["ss"] ?? null;
    if (isset($session)) {
        $user = db::fetch("select login_token from users where idx = '$session->idx'");
        if ($user->login_token != $session->login_token) {
            session_destroy();
            move("/", "다른 곳에서 로그인 되었습니다");
        }
    }
}

function userDelete()
{
    $session = ss();
    if (isset($session)) {
        $user = db::fetch("select * from users where idx = '$session->idx'");
        if (!$user) {
            session_destroy();
            move("/", "해당 계정은 관리자에 의해 삭제되었습니다");
        }
    }
}
