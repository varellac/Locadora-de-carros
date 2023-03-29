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
try{
	$cod_montadora = $_POST['cmb_montadora'];
	$sql = "UPDATE cliente set montadora_cliente=25 WHERE montadora_cliente='$cod_montadora'";
	$conn->query($sql);
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
try{	
	$sql = "DELETE FROM montadora WHERE cod_montadora='$cod_montadora'";
	$conn->query($sql);
    echo "<h4>montadora excluido com sucesso</h4>
    <h3><a href='/locadora_m31'>Voltar</a></h3>";
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
?>
</fieldset></div></div></body></html>