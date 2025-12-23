<?php
session_start();
require_once __DIR__ . "/../database.php";

$email = trim($_POST['email'] ?? '');
$passwort = $_POST['Passwort'] ?? '';

if ($email === '' || $passwort === '') {
    $_SESSION['login_error'] = "Bitte E-Mail und Passwort eingeben.";
    header("Location: ../Loginpage.php");
    exit;
}

$stmt = $conn->prepare("SELECT `ID`, `Password`, `isAdmin` FROM `users` WHERE `E-Mail` = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    $_SESSION['login_error'] = "E-Mail oder Passwort ist falsch!";
    header("Location: ../Loginpage.php");
    exit;
}

// Wenn du HASHED Passwörter nutzt:
if (!password_verify($passwort, $user['Password'])) {
    $_SESSION['login_error'] = "E-Mail oder Passwort ist falsch!";
    header("Location: ../Loginpage.php");
    exit;
}

$_SESSION['loggedin'] = (int)$user['ID'];
$_SESSION['is_admin'] = (int)$user['isAdmi'];

if ($_SESSION['is_admin'] === 1) {
    header("Location: ../Adminpage.php");
} else {
    header("Location: ../Homepage.php");
}
exit;