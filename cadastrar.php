<?php
require_once 'user.php';

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$user = User::cadastrar($nome ,$email, $senha);

if ($user !== true) {
    header("Location: cadastro.php?erro=$user");
} else {
    header("Location: cadastro.php?sucesso=usuario_cadastrado");
}