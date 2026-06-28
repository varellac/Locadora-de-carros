<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    if($_SESSION['perfil'] === 'funcionario') header("Location: dashboard_admin.php");
    else header("Location: area_cliente.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilo/geral.css">
    <title>Login - M8 Locadora</title>
</head>
<body>
    <div class="flex-container">
        <div id="box" class="card" style="margin-top: 100px;">
            <h1 style="text-align: center; margin-bottom: 30px;">Acesse sua conta</h1>
            <form method="POST" action="controle/valida_login.php">
                <label>Email</label>
                <input type="email" name="email" required placeholder="Digite seu email">
                
                <label>Senha</label>
                <input type="password" name="senha" required placeholder="Sua senha">
                
                <input type="submit" value="Entrar" style="margin-top: 20px;">
            </form>
            <div style="margin-top: 20px; text-align: center; color: var(--text-secondary); font-size: 0.9em; line-height:1.6">
                <p><b>Contas para teste:</b></p>
                <p>Funcionário: <i>admin@locadora.com</i> / Senha: <i>123</i></p>
                <p>Cliente: <i>cliente@teste.com</i> / Senha: <i>123</i></p>
            </div>
        </div>
    </div>
</body>
</html>
