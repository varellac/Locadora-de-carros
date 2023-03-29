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
<h1>Atualização de cliente</h1>
<div class="flex-container">
<div id="box" class="barra">
<fieldset>
<?php
include ("conexao.php");
try{
	$cod_cliente = $_POST['cmb_cliente'];	
	$up_cliente = $_POST['txt_cliente'];
	$sql = "UPDATE cliente set cliente='$up_cliente' WHERE cod_cliente=$cod_cliente";
	$conn->query($sql);
	echo "<p>cliente atualizado com sucesso!</p><a href='/locadora_m8'>Voltar</a>";
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
?>
</fieldset></div></div></body></html>