<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Exclusão de cliente</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php
include ("conexao.php");
try{
	$cod_cliente = $_POST['cmb_cliente'];
	$sql = "UPDATE cliente set cliente_cliente=25 WHERE cliente_cliente='$cod_cliente'";
	$conn->query($sql);
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
try{	
	$sql = "DELETE FROM cliente WHERE cod_cliente='$cod_cliente'";
	$conn->query($sql);
    echo "<h4>cliente excluido com sucesso</h4>
    <h3><a href='/locadora_m31'>Voltar</a></h3>";
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
?>
</fieldset></div></div></body></html>