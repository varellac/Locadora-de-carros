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
<h1>Atualização de montadora</h1>
<div class="flex-container">
<div id="box" class="barra">
<fieldset>
<?php
include ("conexao.php");
try{
	$cod_montadora = $_POST['cmb_montadora'];	
	$up_montadora = $_POST['txt_montadora'];
	$sql = "UPDATE montadora set montadora='$up_montadora' WHERE cod_montadora=$cod_montadora";
	$conn->query($sql);
	echo "<p>montadora atualizado com sucesso!</p><a href='/locadora_m8'>Voltar</a>";
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
?>
</fieldset></div></div></body></html>