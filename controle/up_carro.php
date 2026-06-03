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
<h1>Atualização de carro</h1>
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
	$cod_carro = filter_input(INPUT_POST, 'cmb_carro', FILTER_VALIDATE_INT);
	$up_carro = isset($_POST['txt_carro']) ? trim($_POST['txt_carro']) : '';
	$up_tipo = filter_input(INPUT_POST, 'cmb_tipo', FILTER_VALIDATE_INT);
	$up_montadora = filter_input(INPUT_POST, 'cmb_montadora', FILTER_VALIDATE_INT);
	$up_valor_raw = isset($_POST['txt_valor']) ? str_replace(',', '.', trim($_POST['txt_valor'])) : '';
	$up_valor = is_numeric($up_valor_raw) ? (float)$up_valor_raw : 0.0;
	if ($cod_carro === false || $up_carro === '' || $up_tipo === false || $up_montadora === false) {
		echo '<h4>Dados inválidos.</h4>';
		exit;
	}
	$stmt = $conn->prepare('UPDATE carro SET carro = :carro, tipo_carro = :tipo, montadora_carro = :montadora, valor = :valor WHERE cod_carro = :id');
	$stmt->execute([':carro' => $up_carro, ':tipo' => $up_tipo, ':montadora' => $up_montadora, ':valor' => $up_valor, ':id' => $cod_carro]);
	echo '<p>Carro atualizado com sucesso!</p><a href="/locadora_m8">Voltar</a>';
}catch(PDOException $ex){
	error_log('up_carro error: ' . $ex->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>