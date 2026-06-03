<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Exclusão de cliente</h1>
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
	$cod_cliente = filter_input(INPUT_POST, 'cmb_cliente', FILTER_VALIDATE_INT);
	if ($cod_cliente === false || $cod_cliente === null) {
		echo '<h4>Cliente inválido.</h4>';
		exit;
	}
	$del = $conn->prepare('DELETE FROM cliente WHERE cod_cliente = :id');
	$del->execute([':id' => $cod_cliente]);
	echo '<h4>Cliente excluído com sucesso</h4>';
	echo '<h3><a href="/locadora_m8">Voltar</a></h3>';
}catch(PDOException $ex){
	error_log('del_cliente error: ' . $ex->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>