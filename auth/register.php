<?php
include '../config/database.php';

$db = new Database();
$conn = $db->conn;

$message = '';

if (isset($_POST['register'])) {
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $password_ver = trim($_POST['password_ver']);
    $name = trim($_POST['name']);
    $birth = trim($_POST['birth']);
    $address = trim($_POST['address']);

    if ($password !== $password_ver) {
        $message = "Password yang dimasukkan tidak sesuai!";
    } else {
        $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "Email is already registered!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, name, birth, password, role) VALUES (?, ?, ?, ?, ?, 'user')");
            $stmt->bind_param("sss",$username,$email, $name, $birth, $hashed);
            if ($stmt->execute()) {
                header("Location: login.php?register=success");
                exit;
            } else {
                $message = "Failed to register. Please try again.";
            }
        }
    }
}
?>