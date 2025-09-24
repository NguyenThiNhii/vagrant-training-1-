<?php
session_start();
require_once 'configs/csrf.php';
require_once 'models/UserModel.php';
$userModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    if (!verify_csrf()) {
        http_response_code(400);
        $_SESSION['message'] = 'CSRF token validation failed';
        header('location: list_users.php');
        exit;
    }
    $id = $_POST['id'];
    $userModel->deleteUserById($id);
}
header('location: list_users.php');
exit;
