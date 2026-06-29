<?php
session_start();
include __DIR__ . '/conexao.php';

$nome  = trim($_POST['nome'] ?? '');
$cpf   = trim($_POST['cpf'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$senha_confirm = $_POST['senha_confirm'] ?? '';
$cidade_nome = trim($_POST['bairro_nome'] ?? ''); // ex: "São Paulo - SP"
$cep = trim($_POST['cep'] ?? '');

$back = "../cadastro.php?nome=" . urlencode($nome) . "&email=" . urlencode($email) . "&cpf=" . urlencode($cpf);

// Validate required fields
if (empty($nome) || empty($cpf) || empty($email) || empty($senha) || empty($cidade_nome) || empty($cep)) {
    header("Location: $back&erro=campos");
    exit;
}

// Validate passwords match
if ($senha !== $senha_confirm) {
    header("Location: $back&erro=senha");
    exit;
}

// Validate CPF format (simple)
$cpf_num = preg_replace('/\D/', '', $cpf);
if (strlen($cpf_num) !== 11) {
    header("Location: $back&erro=cpf");
    exit;
}

try {
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        header("Location: $back&erro=email");
        exit;
    }

    // Check if CPF already exists
    $stmt = $conn->prepare("SELECT cod_cliente FROM cliente WHERE cpf = ?");
    $stmt->execute([$cpf]);
    if ($stmt->fetch()) {
        header("Location: $back&erro=cpf");
        exit;
    }

    $conn->beginTransaction();

    // Find or create city in the bairro table
    $stmt = $conn->prepare("SELECT cod_bairro FROM bairro WHERE bairro = ?");
    $stmt->execute([$cidade_nome]);
    $cidade_row = $stmt->fetch();
    if ($cidade_row) {
        $id_bairro = $cidade_row['cod_bairro'];
    } else {
        $conn->prepare("INSERT INTO bairro (bairro) VALUES (?)")->execute([$cidade_nome]);
        $id_bairro = $conn->lastInsertId();
    }

    // Insert into cliente table
    $stmt = $conn->prepare("INSERT INTO cliente (cliente, cpf, bairro_cliente) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $cpf, $id_bairro]);
    $id_cliente = $conn->lastInsertId();

    // Insert into usuarios table
    $hash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (email, senha, perfil, id_cliente) VALUES (?, ?, 'cliente', ?)");
    $stmt->execute([$email, $hash, $id_cliente]);
    $id_usuario = $conn->lastInsertId();

    $conn->commit();

    // Log the user in automatically
    $_SESSION['usuario_id'] = $id_usuario;
    $_SESSION['perfil'] = 'cliente';
    $_SESSION['id_cliente'] = $id_cliente;

    header("Location: ../area_cliente.php?bem_vindo=1");
    exit;

} catch (PDOException $ex) {
    $conn->rollBack();
    error_log("cad_usuario error: " . $ex->getMessage());
    header("Location: $back&erro=interno");
    exit;
}
