<?php
session_start();

/* Saari session values clear */
session_unset();

/* Session destroy */
session_destroy();

/* Login page par redirect */
header("Location: index.php");
exit();
?>
