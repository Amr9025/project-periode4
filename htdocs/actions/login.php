<?php
session_start();
require_once "../database/connection.php";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Both email and password are required';
        header('Location: /pages/login-form.php');
        exit;
    }

    try {
        $select_user = $conn->prepare("SELECT * FROM account WHERE email = :email");
        $select_user->bindParam(":email", $email);
        $select_user->execute();
        $user = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_admin'] = (bool)$user['is_admin'];
            $_SESSION['success'] = 'Successfully logged in!';
            header('Location: /');
            exit;
        } else {
            $_SESSION['error'] = 'Invalid email or password';
            header('Location: /pages/login-form.php');
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database error. Please try again later.';
        header('Location: /pages/login-form.php');
        exit;
    }
} else {
    header('Location: /pages/login-form.php');
    exit;
}
