<?php
session_start();
$_SESSION['theme'] = ($_SESSION['theme'] ?? 'light') === 'light' ? 'dark' : 'light';
header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'beranda.php'));
exit;
?>