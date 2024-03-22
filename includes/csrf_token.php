<?php
$month = 30 * 24 * 60 * 60; // 30 days * 24 hours * 60 minutes * 60 seconds
ini_set('session.cookie_lifetime', $month);
ini_set('session.gc_maxlifetime', $month);
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
