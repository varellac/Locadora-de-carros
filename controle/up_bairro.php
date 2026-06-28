<?php
include(__DIR__ . '/conexao.php');
include_once __DIR__ . '/csrf.php';
$token = $_POST['csrf_token'] ?? '';
if (!csrf_check($token)) {
	$message = '<h4>Requisição inválida (token CSRF).</h4>';
} else {
	try{
		$cod_bairro = filter_input(INPUT_POST, 'cmb_bairro', FILTER_VALIDATE_INT);
		$up_bairro = isset($_POST['txt_bairro']) ? trim($_POST['txt_bairro']) : '';
		if ($cod_bairro === false || $up_bairro === '') {
			$message = '<h4>Dados inválidos.</h4>';
		} else {
			$stmt = $conn->prepare('UPDATE bairro SET bairro = :bairro WHERE cod_bairro = :id');
			$stmt->execute([':bairro' => $up_bairro, ':id' => $cod_bairro]);
			$message = '<p>Bairro atualizado com sucesso!</p><a href="/locadora_m8">Voltar</a>';
		}
	}catch(PDOException $ex){
		error_log('up_bairro error: ' . $ex->getMessage());
		$message = '<h4>Ocorreu um erro. Contate o administrador.</h4>';
	}
}
?>
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
<h1>Atualização de bairro</h1>
<div class="flex-container">
<div id="box" class="barra">
<fieldset>
<?php echo $message ?? ''; ?>
</fieldset></div></div></body></html>