<?php
session_start();
unset($_SESSION['name']);
session_destroy();
header("Location: http://localhost:82/webpasokon/login.php");

exit;
?>