<?php
// database.php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Verbindungseinstellungen
$db_server   = "127.0.0.1";
$db_username = "root";
$db_password = "";
$db_name     = "hotel_db";   // <-- MUSS deine echte DB sein (wo die Tabelle users drin ist)

try {
    $conn = new mysqli($db_server, $db_username, $db_password, $db_name);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    // Keine "Connection successful"-Ausgaben. Nur sauber abbrechen.
    die("DB-Verbindung fehlgeschlagen: " . $e->getMessage());
}
