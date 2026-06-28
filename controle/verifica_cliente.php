<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'cliente') {
    header("Location: /index.php");
    exit;
}
