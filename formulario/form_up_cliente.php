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
<div id="box">
<fieldset>
<form method="POST" action="../controle/up_cliente.php">
	<h3>Escolha o cliente a ser modificado</h3>
<?php
include ("../controle/conexao.php");
try{
  $sql = 'SELECT * FROM cliente ORDER BY cliente';
  print "<select name='cmb_cliente'>";
  foreach ($conn->query($sql) as $row) {
    print "<option value='".$row['cod_cliente']."'>".$row['cliente']."</option>";
  }
  print "</select>";
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
?>
	<br><h3>Digite um novo nome para o cliente</h3><br>
	<input type="text" name="txt_cliente">
	<input type="submit" value="Atualizar">
</fieldset></form></div></div></body></html>