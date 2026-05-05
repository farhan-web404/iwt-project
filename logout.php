<?php
// =============================================
// logout.php — Destroy Session & Redirect
// =============================================
session_start();
session_unset();
session_destroy();
header('Location: login.php');
exit;
?>
