<?php
// database.php

// Aktiviert detaillierte Fehlermeldungen für MySQLi (gut zum Debuggen)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// --- Verbindungseinstellungen ---
$db_server   = "127.0.0.1";
$db_username = "root";
$db_password = "";
$db_name     = "hotel_db"; // Deine Datenbank

try {
    // Erstellen der Verbindung
    $conn = new mysqli($db_server, $db_username, $db_password, $db_name);
    
    // Setzen des Zeichensatzes auf UTF-8, damit Umlaute/Sonderzeichen korrekt bleiben
    $conn->set_charset("utf8mb4");

} catch (mysqli_sql_exception $e) {
    // Bei Fehler: Programm sauber beenden und Fehler anzeigen
    die("DB-Verbindung fehlgeschlagen: " . $e->getMessage());
}
?>