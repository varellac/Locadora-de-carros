<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Exclusão de bairro</h1>
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
	$cod_bairro = filter_input(INPUT_POST, 'cmb_bairro', FILTER_VALIDATE_INT);
	if ($cod_bairro === false || $cod_bairro === null) {
		echo '<h4>Bairro inválido.</h4>';
		exit;
	}
	$stmt = $conn->prepare('UPDATE cliente SET bairro_cliente = :default WHERE bairro_cliente = :bairro');
	$stmt->execute([':default' => 25, ':bairro' => $cod_bairro]);

	$del = $conn->prepare('DELETE FROM bairro WHERE cod_bairro = :bairro');
	$del->execute([':bairro' => $cod_bairro]);
	echo '<h4>Bairro excluído com sucesso</h4>';
	echo '<h3><a href="/locadora_m8">Voltar</a></h3>';
}catch(PDOException $ex){
	error_log('del_bairro error: ' . $ex->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>