<?php
session_start();
include __DIR__ . '/conexao.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if(empty($email) || empty($senha)){
    echo "<!DOCTYPE html><html lang='pt-BR'><head><meta charset='utf-8'><link rel='stylesheet' href='../estilo/geral.css'></head><body><div class='flex-container'><div id='box' class='card'><h2>Preencha todos os campos.</h2><br><a href='../index.php'>Voltar</a></div></div></body></html>";
    exit;
}

try {
    $stmt = $conn->prepare("SELECT id, senha, perfil, id_cliente FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();
    
    if($user && password_verify($senha, $user['senha'])){
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['perfil'] = $user['perfil'];
        $_SESSION['id_cliente'] = $user['id_cliente'];
        
        if($user['perfil'] === 'funcionario') {
            header("Location: ../dashboard_admin.php");
        } else {
            header("Location: ../area_cliente.php");
        }
    } else {
        echo "<!DOCTYPE html><html lang='pt-BR'><head><meta charset='utf-8'><link rel='stylesheet' href='../estilo/geral.css'></head><body><div class='flex-container'><div id='box' class='card'><h2>Usuário ou senha inválidos.</h2><br><a href='../index.php'>Voltar</a></div></div></body></html>";
    }
} catch(PDOException $ex) {
    echo "Erro: " . $ex->getMessage();
}
