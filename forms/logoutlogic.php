<?php
session_start(); // Startet die Session (oder nimmt die bestehende wieder auf)

// 1. Session-Variablen leeren
// Damit sind alle gespeicherten Daten (wie User-ID, Name, Admin-Status) weg.
$_SESSION = []; 

// 2. Das Session-Cookie löschen
// Damit der Browser nicht mehr weiß, zu welcher alten Session er gehörte.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    
    // Wir setzen das Cookie auf eine Zeit in der Vergangenheit (time() - 42000),
    // damit der Browser es sofort als "abgelaufen" betrachtet und löscht.
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

// 3. Die Session auf dem Server zerstören
session_destroy(); 

// 4. Zur Startseite weiterleiten
// Nach dem Logout landet der User wieder auf der öffentlichen Homepage.
header("Location: ../Homepage.php"); 
exit(); // Wichtig: Skript beenden, damit kein weiterer Code ausgeführt wird.
?>