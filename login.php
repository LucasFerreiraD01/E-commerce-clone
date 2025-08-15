<?php
session_start();
require_once 'user.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$user = User::authenticar($email, $senha);

if($user === 'senha_incorreta'){
    header("Location: login.html?error=senha_incorreta");
    exit;
}else if($user === 'usuario_inexistente'){
    header("Location: login.html?error=usuario_inexistente");
    exit;
} else if($user === false){
    header("Location: login.html?error=erro_autenticacao");
    exit;
} else {
    $_SESSION['user'] = $user['email'];
    header('Location: painel.php');
    exit;
}

