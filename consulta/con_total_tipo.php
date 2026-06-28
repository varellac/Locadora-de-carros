<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
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
	$sql = "SELECT t.tipo, SUM(c.valor) AS total_valor FROM carro c 
	INNER JOIN tipo t ON t.cod_tipo=c.tipo_carro 
	GROUP BY t.tipo ORDER BY SUM(c.valor) DESC";
	foreach ($conn->query($sql) as $row) {
	   $tipoEsc = htmlspecialchars($row['tipo'], ENT_QUOTES, 'UTF-8');
	   print "<tr><td>".$tipoEsc."</td>
			  <td class='valores' width='25%'>R$ ".number_format($row['total_valor'],2,",","")."</td></tr>";
	}
}catch(PDOException $ex){
	error_log('con_total_tipo error: ' . $ex->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</table><br><a href='http://localhost/locadora_m8'>Voltar</a>
</fieldset></div></div></body></html>
