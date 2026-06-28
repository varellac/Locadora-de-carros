<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
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
<h1>AtualizaÃ§Ã£o de montadora</h1>
<div class="flex-container">
<div id="box" class="barra">
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
	$cod_montadora = filter_input(INPUT_POST, 'cmb_montadora', FILTER_VALIDATE_INT);
	$up_montadora = isset($_POST['txt_montadora']) ? trim($_POST['txt_montadora']) : '';
	if ($cod_montadora === false || $up_montadora === '') {
		echo '<h4>Dados invÃ¡lidos.</h4>';
		exit;
	}
	$stmt = $conn->prepare('UPDATE montadora SET montadora = :montadora WHERE cod_montadora = :id');
	$stmt->execute([':montadora' => $up_montadora, ':id' => $cod_montadora]);
	echo '<p>Montadora atualizada com sucesso!</p><a href="/locadora_m8">Voltar</a>';
}catch(PDOException $ex){
	error_log('up_montadora error: ' . $ex->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>
