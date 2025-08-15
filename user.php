<?php
require_once 'database.php';

class User {
    public static function authenticar($email, $senha) {
        // Usa o SupabaseClient para autenticar o usuário
        try {    
            $supabase = new SupabaseClient(DB_HOST, DB_APIKEY);
            try {
                    // Usa o SupabaseClient para autenticar o usuário
                    $resposta = $supabase->select('clientes', '*', ['email'=> $email]);
                    if (isset($resposta['body']) && is_array($resposta['body']) && count($resposta['body']) > 0) { //Checa se o corpo da resposta é um array e se contém dados
                        $user = $resposta['body'][0];
                        if (password_verify($senha, $user['senha'])) { //Verifica a senha
                            return $user; 
                        } else{
                            return 'senha_incorreta'; //Senha incorreta
                        }
                    } else {
                        return 'usuario_inexistente'; //Usuário não encontrado
                    }
            } catch (Exception $e) {
                return return "Erro na autenticação, " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
            }
        } catch (Exception $e) {
            return return "Erro na conexão com o Supabase, " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
    public static function cadastrar($nome, $email ,$senha) {
        // Usa o SupabaseClient para cadastrar o usuário
        try {
            $supabase = new SupabaseClient(DB_HOST, DB_APIKEY);
            // Verifica se o email já está cadastrado
            $resposta = $supabase->select('clientes', '*', ['email'=> $email]);
            if (isset($resposta['body']) && is_array($resposta['body']) && count($resposta['body']) > 0) {
                header("Location: cadastro.html?erro=usuario_ja_cadastrado");
                exit; //Email já cadastrado
            }
            // Insere o novo usuário
            try{
                $novoUsuario = $supabase->insert('clientes', [
                    'nome' => $nome,
                    'email' => $email,
                    'senha' => password_hash($senha, PASSWORD_DEFAULT)
                ]);
            } catch (Exception $e) {
                return "Erro ao cadastrar, " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'); //Erro ao cadastrar
            }
        } catch (Exception $e) {
            echo "Erro ao conectar ao Supabase: " . $e->getMessage();
            return "Erro na conexão com o Supabase, " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
}
