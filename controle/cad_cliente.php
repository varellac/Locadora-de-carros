<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Cadastro de cliente</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php
include("conexao.php");
include_once __DIR__ . '/csrf.php';
$token = $_POST['csrf_token'] ?? '';
if (!csrf_check($token)) {
    echo '<h4>Requisição inválida (token CSRF).</h4>';
    exit;
}
try{
    $var_cliente = isset($_POST['txt_cliente']) ? trim($_POST['txt_cliente']) : '';
    $var_bairro = filter_input(INPUT_POST, 'cmb_bairro', FILTER_VALIDATE_INT);
    $var_cpf = isset($_POST['txt_cpf']) ? trim($_POST['txt_cpf']) : '';
    if ($var_cliente === '' || $var_bairro === false) {
        echo '<h4>Dados inválidos. Verifique e tente novamente.</h4>';
    } else {
        $stmt = $conn->prepare('INSERT INTO cliente (cliente, bairro_cliente, cpf) VALUES (:cliente, :bairro, :cpf)');
        $stmt->execute([':cliente' => $var_cliente, ':bairro' => $var_bairro, ':cpf' => $var_cpf]);
        echo '<h4>Cliente incluído com sucesso</h4>';
        echo '<h3><a href="/locadora_m8">Voltar</a></h3>';
    }
}catch(PDOException $ex){
    error_log('cad_cliente error: ' . $ex->getMessage());
    echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>