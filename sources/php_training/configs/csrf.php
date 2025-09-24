<?php
// Simple CSRF protection helpers
// Đảm bảo một phiên tồn tại để lưu trữ mã thông báo CSRF
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Get or create the session CSRF token
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Render a hidden input containing the CSRF token
function csrf_field(): string
{
    $token = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

// Validate that the incoming POST includes a valid CSRF token
function verify_csrf(): bool
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return false;
    }
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], (string)$_POST['csrf_token']);
}
