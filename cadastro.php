<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    if($_SESSION['perfil'] === 'funcionario') header("Location: dashboard_admin.php");
    else header("Location: area_cliente.php");
    exit;
}
$erro = $_GET['erro'] ?? '';
$msg_erro = match($erro) {
    'campos'  => 'Preencha todos os campos obrigatórios.',
    'email'   => 'Este e-mail já está cadastrado. Tente fazer login.',
    'senha'   => 'As senhas não coincidem.',
    'cpf'     => 'CPF inválido ou já cadastrado.',
    'interno' => 'Erro interno. Tente novamente.',
    default   => ''
};
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilo/geral.css">
    <title>Criar Conta - M8 Locadora</title>
    <style>
        .register-container {
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
        .register-box {
            width: 100%;
            max-width: 480px;
            background: rgba(30, 41, 59, 0.75);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .register-box h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
            text-align: center;
        }
        .register-box p.subtitle {
            color: var(--text-secondary);
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 28px;
        }
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
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
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--text-secondary);
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        .back-link:hover { color: #fff; }
        .section-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #60a5fa;
            margin: 20px 0 12px;
        }
        .password-hints {
            font-size: 0.78rem;
            color: var(--text-secondary);
            margin-top: -12px;
            margin-bottom: 16px;
            padding-left: 4px;
        }
        .cep-row {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 12px;
            align-items: end;
        }
        .cep-status {
            font-size: 0.8rem;
            margin-top: -14px;
            margin-bottom: 10px;
            padding-left: 4px;
            min-height: 16px;
            transition: all 0.3s;
        }
        .cep-status.ok  { color: #4ade80; }
        .cep-status.err { color: #f87171; }
        .cep-status.loading { color: #60a5fa; }
        input[readonly] {
            opacity: 0.65;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="brand">🚗 M8 LOCADORA</div>
        <div class="register-box">
            <h2>Criar nova conta</h2>
            <p class="subtitle">Preencha os dados abaixo para se cadastrar como cliente</p>

            <?php if ($msg_erro): ?>
            <div class="error-box">⚠️ <?= htmlspecialchars($msg_erro) ?></div>
            <?php endif; ?>

            <form method="POST" action="controle/cad_usuario.php">

                <p class="section-label">Dados Pessoais</p>
                <label>Nome Completo</label>
                <input type="text" name="nome" required placeholder="Seu nome completo"
                       value="<?= htmlspecialchars($_GET['nome'] ?? '') ?>">

                <div class="two-col">
                    <div>
                        <label>CPF</label>
                        <input type="text" name="cpf" required placeholder="000.000.000-00"
                               maxlength="14" id="cpf"
                               value="<?= htmlspecialchars($_GET['cpf'] ?? '') ?>">
                    </div>
                    <div>
                        <label>CEP</label>
                        <input type="text" name="cep" id="cep" required placeholder="00000-000" maxlength="9">
                    </div>
                </div>
                <p class="cep-status" id="cep-status"></p>

                <div class="cep-row">
                    <div>
                        <label>Estado (UF)</label>
                        <input type="text" name="uf" id="uf" placeholder="UF" readonly maxlength="2">
                    </div>
                    <div>
                        <label>Cidade</label>
                        <input type="text" name="cidade_nome" id="cidade_nome" placeholder="Preenchido pelo CEP" readonly>
                    </div>
                </div>
                <input type="hidden" name="bairro_nome" id="bairro_nome">

                <p class="section-label">Dados de Acesso</p>
                <label>E-mail</label>
                <input type="email" name="email" required placeholder="seu@email.com"
                       value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">

                <div class="two-col">
                    <div>
                        <label>Senha</label>
                        <input type="password" name="senha" required placeholder="Mín. 6 caracteres" minlength="6">
                    </div>
                    <div>
                        <label>Confirmar Senha</label>
                        <input type="password" name="senha_confirm" required placeholder="Repita a senha">
                    </div>
                </div>
                <p class="password-hints">A senha deve ter pelo menos 6 caracteres.</p>

                <input type="submit" value="Criar Conta" style="margin-top: 12px;">
            </form>

            <a href="index.php" class="back-link">← Já tenho conta, quero fazer login</a>
        </div>
    </div>

    <script>
        // Máscara CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '');
            v = v.substring(0, 11);
            if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, '$1.$2.$3-$4');
            else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{0,3})/, '$1.$2.$3');
            else if (v.length > 3) v = v.replace(/(\d{3})(\d{0,3})/, '$1.$2');
            e.target.value = v;
        });

        // Máscara + busca CEP
        const cepInput = document.getElementById('cep');
        const statusEl = document.getElementById('cep-status');

        cepInput.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '').substring(0, 8);
            if (v.length > 5) v = v.replace(/(\d{5})(\d{0,3})/, '$1-$2');
            e.target.value = v;
            if (v.replace('-','').length === 8) buscarCEP(v.replace('-',''));
            else limparCidade();
        });

        function buscarCEP(cep) {
            statusEl.className = 'cep-status loading';
            statusEl.textContent = '🔍 Buscando...';
            limparCidade();

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(r => r.json())
                .then(data => {
                    if (data.erro) {
                        statusEl.className = 'cep-status err';
                        statusEl.textContent = '❌ CEP não encontrado.';
                        return;
                    }
                    document.getElementById('cidade_nome').value = data.localidade;
                    document.getElementById('uf').value = data.uf;
                    document.getElementById('bairro_nome').value = data.localidade + ' - ' + data.uf;
                    statusEl.className = 'cep-status ok';
                    statusEl.textContent = `✅ ${data.logradouro ? data.logradouro + ', ' : ''}${data.localidade} - ${data.uf}`;
                })
                .catch(() => {
                    statusEl.className = 'cep-status err';
                    statusEl.textContent = '❌ Erro ao buscar CEP. Verifique sua conexão.';
                });
        }

        function limparCidade() {
            document.getElementById('cidade_nome').value = '';
            document.getElementById('uf').value = '';
            document.getElementById('bairro_nome').value = '';
            statusEl.textContent = '';
        }
    </script>
</body>
</html>
