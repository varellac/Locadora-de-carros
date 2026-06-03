<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Cadastro de bairro</h1>
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
    $var_bairro = isset($_POST['txt_bairro']) ? trim($_POST['txt_bairro']) : '';
    if ($var_bairro === '') {
        echo '<h4>Nome do bairro inválido.</h4>';
    } else {
        $stmt = $conn->prepare('INSERT INTO bairro (bairro) VALUES (:bairro)');
        $stmt->execute([':bairro' => $var_bairro]);
        echo '<h4>Bairro incluído com sucesso</h4>';
        echo '<h3><a href="/locadora_m8">Voltar</a></h3>';
    }
}catch(PDOException $ex){
    error_log('cad_bairro error: ' . $ex->getMessage());
    echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>