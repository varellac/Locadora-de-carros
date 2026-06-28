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
<h1>Pesquisa de carros</h1>
<div class="flex-container">
<div id="box">
<fieldset>	
<?php include __DIR__ . '/../controle/csrf.php'; ?>
<form method="POST" action="../consulta/con_carros.php">
	<?php echo csrf_input(); ?>
	<input type="text" name="txt_carro">
	<input type="submit" value="Carros">
</form></fieldset></div></div></body></html>
