<?php

session_start();
 $_SESSION = []; // Empty session array or use session_unset();
 // Destroy the session cookie (PHPSESSID)
 if (ini_get("session.use_cookies")) {
 $params = session_get_cookie_params();
 setcookie(session_name(), ''
, time() - 42000, $params["path"],
 $params["domain"], $params["secure"], $params["httponly"]);
 }

 session_destroy(); // Destroy the session
 header("Location: ../Homepage.php"); // Redirect back to login
 exit(); // Terminate the script
?>
