<?php
session_start(); 
session_destroy(); // Destrói todos os dados da sessão
header("Location: login.html"); // Redireciona pra página de login
exit(); // Termina o script
?>