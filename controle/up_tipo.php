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
<h1>Atualização de tipo</h1>
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
	$cod_tipo = filter_input(INPUT_POST, 'cmb_tipo', FILTER_VALIDATE_INT);
	$up_tipo = isset($_POST['txt_tipo']) ? trim($_POST['txt_tipo']) : '';
	if ($cod_tipo === false || $up_tipo === '') {
		echo '<h4>Dados inválidos.</h4>';
		exit;
	}
	$stmt = $conn->prepare('UPDATE tipo SET tipo = :tipo WHERE cod_tipo = :id');
	$stmt->execute([':tipo' => $up_tipo, ':id' => $cod_tipo]);
	echo '<p>Tipo atualizado com sucesso!</p><a href="/locadora_m8">Voltar</a>';
}catch(PDOException $ex){
	error_log('up_tipo error: ' . $ex->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>