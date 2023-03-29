<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Projeto Locadora</title>
	<link rel='stylesheet' type='text/css' href='../estilo/geral.css'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1>Carros</h1>
<div class="flex-container">
<div id="box">
	<table border="1"><tr><th width="30%">Carro</th><th>Tipo</th><th>Montadora</th>
	<th>Valor</th></tr>
<?php
include ("../controle/conexao.php");
try{
    $carro = $_POST['txt_carro'];
	$sql = "SELECT c.cod_carro, c.carro, t.tipo, m.montadora, c.valor FROM carro c 
	INNER JOIN tipo t ON t.cod_tipo=c.tipo_carro 
	INNER JOIN montadora m ON m.cod_montadora=c.montadora_carro
    WHERE carro LIKE '%$carro%' ORDER BY c.carro";

	print "<form method='post' action='/locadora_m8/controle/inserir_carros.php'";
	foreach ($conn->query($sql) as $row) {
	   print "<tr><td width='20%'><input type='radio' name='item' value='".$row['cod_carro']."'>".$row['carro']."</td>
	   		  <td width='25%'>".$row['tipo']."</td>
              <td width='25%'>".$row['montadora']."</td>
              <td class='valores' width='30%'> R$ ".number_format($row['valor'],2,",",".")."</td></tr>";
	}
	echo "<a href='http://localhost/locadora_m8/formularios/cad_itens_locacao.php'>Voltar</a>";	
	echo "<td colspan='3'></td>";
	print "<td><input type='submit' value=Incluir item'></td></form>";
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
?></table></div></div></body></html>