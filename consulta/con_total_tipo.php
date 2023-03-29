<!DOCTYPE html> 
<html lang="pt-br">
<head>
	<title>Projeto Locadora</title>
	<link rel='stylesheet' type='text/css' href='../estilo/geral.css'>
</head>
<body>
<h1>Faturamento por tipo</h1>
<div class="flex-container">
<div id="box">
<fieldset>	
	<table border="1"><tr><th width="50%">Tipo</th><th>Total locado</th></tr>
<?php
include ("../controle/conexao.php");
try{
	$sql = "SELECT t.tipo, SUM(c.valor) FROM carro c 
	INNER JOIN tipo t ON t.cod_tipo=c.tipo_carro 
	GROUP BY t.tipo ORDER BY SUM(c.valor) DESC";
	foreach ($conn->query($sql) as $row) {
	   print "<tr><td>".$row['tipo']."</td>
              <td class='valores' width='25%'>R$ ".number_format($row['SUM(c.valor)'],2,",",".")."</td></tr>";
	}
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
?>
</table><br><a href='http://localhost/locadora_m8'>Voltar</a>
</fieldset></div></div></body></html>