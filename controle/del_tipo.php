<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Exclusão de tipo</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php
include ("conexao.php");
try{
	$cod_tipo = $_POST['cmb_tipo'];
	$sql = "UPDATE cliente set tipo_cliente=25 WHERE tipo_cliente='$cod_tipo'";
	$conn->query($sql);
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
try{	
	$sql = "DELETE FROM tipo WHERE cod_tipo='$cod_tipo'";
	$conn->query($sql);
    echo "<h4>tipo excluido com sucesso</h4>
    <h3><a href='/locadora_m31'>Voltar</a></h3>";
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
?>
</fieldset></div></div></body></html>