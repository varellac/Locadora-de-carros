<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">
</head>
<body>
<h1>ExclusÃ£o de carro</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php
include ("conexao.php");
include_once __DIR__ . '/csrf.php';
$token = $_POST['csrf_token'] ?? '';
if (!csrf_check($token)) {
	echo '<h4>RequisiÃ§Ã£o invÃ¡lida (token CSRF).</h4>';
	exit;
}
try{
	$cod_carro = filter_input(INPUT_POST, 'cmb_carro', FILTER_VALIDATE_INT);
	if ($cod_carro === false || $cod_carro === null) {
		echo '<h4>Carro invÃ¡lido.</h4>';
		exit;
	}
	$del = $conn->prepare('DELETE FROM carro WHERE cod_carro = :id');
	$del->execute([':id' => $cod_carro]);
	echo '<h4>Carro excluÃ­do com sucesso</h4>';
	echo '<h3><a href="/locadora_m8">Voltar</a></h3>';
}catch(PDOException $ex){
	error_log('del_carro error: ' . $ex->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>
