<?php
session_start();

$current_lang = $_SESSION['lang'] ?? 'id';
$_SESSION['lang'] = ($current_lang === 'id') ? 'en' : 'id';

$referrer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header("Location: " . $referrer);
exit;
?>