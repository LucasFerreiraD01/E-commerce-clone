<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.html');
    exit;
}

echo "Bem-vindo, " . htmlspecialchars($_SESSION['user']) . "!";
echo "<br><a href='logout.php'>Sair</a>";
