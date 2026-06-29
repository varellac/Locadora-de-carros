<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    if($_SESSION['perfil'] === 'funcionario') header("Location: dashboard_admin.php");
    else header("Location: area_cliente.php");
    exit;
}
$erro = $_GET['erro'] ?? '';
$msg_erro = match($erro) {
    'campos'    => 'Preencha todos os campos obrigatórios.',
    'email'     => 'Este e-mail já está cadastrado.',
    'senha'     => 'As senhas não coincidem.',
    'cpf'       => 'CPF inválido ou já cadastrado.',
    default     => ''
};
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilo/geral.css">
    <title>Login - M8 Locadora</title>
    <style>
        .login-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
        }
        .brand {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(to right, #60a5fa, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 32px;
            letter-spacing: -1px;
        }
        .login-box {
            width: 100%;
            max-width: 420px;
            background: rgba(30, 41, 59, 0.75);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .login-box h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
            text-align: center;
        }
        .login-box p.subtitle {
            color: var(--text-secondary);
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 28px;
        }
        .divider {
            text-align: center;
            margin: 20px 0;
            color: var(--text-secondary);
            font-size: 0.85rem;
            position: relative;
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }
        .divider::before { left: 0; }
        .divider::after { right: 0; }
        .btn-secondary {
            display: block;
            width: 100%;
            padding: 12px;
            text-align: center;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.12);
            color: #fff;
            border-color: rgba(255,255,255,0.25);
        }
        .error-box {
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.35);
            border-radius: 8px;
            padding: 12px 16px;
            color: #f87171;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }
        .test-accounts {
            margin-top: 24px;
            padding: 14px;
            background: rgba(255,255,255,0.04);
            border-radius: 10px;
            font-size: 0.8rem;
            color: var(--text-secondary);
            line-height: 1.8;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="brand">🚗 M8 LOCADORA</div>
        <div class="login-box">
            <h2>Bem-vindo de volta!</h2>
            <p class="subtitle">Acesse sua conta para continuar</p>

            <?php if ($msg_erro): ?>
            <div class="error-box">⚠️ <?= htmlspecialchars($msg_erro) ?></div>
            <?php endif; ?>

            <form method="POST" action="controle/valida_login.php">
                <label>E-mail</label>
                <input type="email" name="email" required placeholder="seu@email.com">

                <label>Senha</label>
                <input type="password" name="senha" required placeholder="••••••••">

                <input type="submit" value="Entrar" style="margin-top: 8px;">
            </form>

            <div class="divider">ou</div>

            <a href="cadastro.php" class="btn-secondary">Criar nova conta</a>

            <div class="test-accounts">
                <b>Contas de teste</b><br>
                Funcionário: <i>admin@locadora.com</i> / <i>123</i><br>
                Cliente: <i>cliente@teste.com</i> / <i>123</i>
            </div>
        </div>
    </div>
</body>
</html>
