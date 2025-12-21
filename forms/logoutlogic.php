<?php
require 'users.php';

// Session löschen
session_unset();
session_destroy();

// Weiterleitung zur Homepage
header("Location: ../Homepage.php");
exit;
?>
