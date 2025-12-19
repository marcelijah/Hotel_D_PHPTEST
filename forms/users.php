
<?php
// Session nur starten, wenn noch keine aktiv ist
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Standard-User + Admin definieren
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        'user1' => [
            'vorname' => 'Max',
            'nachname' => 'Mustermann',
            'email' => 'test@beispiel.com',
            'passwort' => '123',
            'role' => 'user'
        ],
        'admin1' => [
            'vorname' => 'Admin',
            'nachname' => 'EA',
            'email' => 'admin@hotel.com',
            'passwort' => '123',
            'role' => 'admin'
        ]
    ];
}
?>



