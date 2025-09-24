<?php
session_start();
require_once 'configs/csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf()) {
    //Hủy bỏ sessionn an toàn
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    header('location: login.php');
    exit();
} else {
    $_SESSION['message'] = 'Invalid logout request';
    header('location: list_users.php');
    exit();
}
