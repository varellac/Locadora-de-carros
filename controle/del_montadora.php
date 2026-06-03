<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Exclusão de montadora</h1>
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
	$cod_montadora = filter_input(INPUT_POST, 'cmb_montadora', FILTER_VALIDATE_INT);
	if ($cod_montadora === false || $cod_montadora === null) {
		echo '<h4>Montadora inválida.</h4>';
		exit;
	}
	$stmt = $conn->prepare('DELETE FROM montadora WHERE cod_montadora = :id');
	$stmt->execute([':id' => $cod_montadora]);
	echo '<h4>Montadora excluída com sucesso</h4>';
	echo '<h3><a href="/locadora_m8">Voltar</a></h3>';
} catch(PDOException $ex){
	error_log('del_montadora error: ' . $ex->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>