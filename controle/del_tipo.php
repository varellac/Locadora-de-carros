<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Exclusão de tipo</h1>
<div class="flex-container">
<div id="box">
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
	if ($cod_tipo === false || $cod_tipo === null) {
		echo '<h4>Tipo inválido.</h4>';
		exit;
	}
	$stmt = $conn->prepare('UPDATE cliente SET tipo_cliente = :default WHERE tipo_cliente = :tipo');
	$stmt->execute([':default' => 25, ':tipo' => $cod_tipo]);

	$del = $conn->prepare('DELETE FROM tipo WHERE cod_tipo = :tipo');
	$del->execute([':tipo' => $cod_tipo]);
	echo '<h4>Tipo excluído com sucesso</h4>';
	echo '<h3><a href="/locadora_m8">Voltar</a></h3>';
}catch(PDOException $ex){
	error_log('del_tipo error: ' . $ex->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>