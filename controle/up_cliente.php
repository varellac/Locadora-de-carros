<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Projeto Locadora</title>
	<link rel='stylesheet' type='text/css' href='../estilo/geral.css'>
</head>
<body>
<h1>Atualização de cliente</h1>
<div class="flex-container">
<div id="box" class="barra">
<fieldset>
<?php
include ("conexao.php");
include_once __DIR__ . '/csrf.php';
$token = $_POST['csrf_token'] ?? '';
if (!csrf_check($token)) {
	echo '<h4>Requisição inválida (token CSRF).</h4>';
	exit;
}
try{
	$cod_cliente = filter_input(INPUT_POST, 'cmb_cliente', FILTER_VALIDATE_INT);
	$up_cliente = isset($_POST['txt_cliente']) ? trim($_POST['txt_cliente']) : '';
	if ($cod_cliente === false || $up_cliente === '') {
		echo '<h4>Dados inválidos.</h4>';
		exit;
	}
	$stmt = $conn->prepare('UPDATE cliente SET cliente = :cliente WHERE cod_cliente = :id');
	$stmt->execute([':cliente' => $up_cliente, ':id' => $cod_cliente]);
	echo '<p>Cliente atualizado com sucesso!</p><a href="/locadora_m8">Voltar</a>';
}catch(PDOException $ex){
	error_log('up_cliente error: ' . $ex->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>