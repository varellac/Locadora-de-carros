<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">
</head>
<body>
<h1>Exclusão de carro</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php
include ("conexao.php");
try{
	$cod_carro = $_POST['cmb_carro'];
	$sql = "UPDATE cliente set carro_cliente=25 WHERE carro_cliente='$cod_carro'";
	$conn->query($sql);
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
try{	
	$sql = "DELETE FROM carro WHERE cod_carro='$cod_carro'";
	$conn->query($sql);
    echo "<h4>carro excluido com sucesso</h4>
    <h3><a href='/locadora_m31'>Voltar</a></h3>";
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
?>
</fieldset></div></div></body></html>