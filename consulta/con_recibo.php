<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Projeto Locadora</title>
	<link rel='stylesheet' type='text/css' href='../estilo/geral.css'>
</head>
<body>
<h1>Recido de locaÃ§Ãµes</h1>
<div class="flex-container">
<div id="box" >
<fieldset>
<?php
echo "<small>Locadora M8 - data: ".date('d/m/y')." - hora: ".date('H:i')."</small>";
?>
<table class="tabrecibo"><tr><th>Carro</th><th>Valor R$</th></tr>	
<?php
include ("../controle/conexao.php");
include_once __DIR__ . '/../controle/csrf.php';
try{
	$token = $_POST['csrf_token'] ?? '';
	if (!csrf_check($token)) {
		echo '<h4>RequisiÃ§Ã£o invÃ¡lida (token CSRF).</h4>';
		exit;
	}
	$locacao = filter_input(INPUT_POST, 'locacao', FILTER_VALIDATE_INT);
	if ($locacao === false || $locacao === null) {
		echo '<h4>LocaÃ§Ã£o invÃ¡lida.</h4>';
		exit;
	}
	$total = 0.0;
	$sql = 'SELECT c.cliente, l.cod_locacao, i.carro_locado, f.carro, f.valor FROM cliente c '
		 . 'INNER JOIN locacao l ON c.cod_cliente = l.cliente_locacao '
		 . 'INNER JOIN carros_locacao i ON l.cod_locacao = i.locacao '
		 . 'INNER JOIN carro f ON i.carro_locado = f.cod_carro '
		 . 'WHERE l.cod_locacao = :locacao';
	$stmt = $conn->prepare($sql);
	$stmt->execute([':locacao' => $locacao]);
	$rows = $stmt->fetchAll();
	foreach ($rows as $row) {
	   $carEsc = htmlspecialchars($row['carro'], ENT_QUOTES, 'UTF-8');
	   echo "<tr class='linharecibo'><td>".$carEsc."</td>";
	   echo "<td class='valores'>".number_format($row['valor'],2,',','.')."</td></tr>";
		$total += $row['valor'];
	}
	if (!empty($rows)) {
		$last = end($rows);
		$codloc = htmlspecialchars($last['cod_locacao'], ENT_QUOTES, 'UTF-8');
		$cliente = htmlspecialchars($last['cliente'], ENT_QUOTES, 'UTF-8');
		print "<h3>RECIBO NÃšMERO <u>".$codloc."</u></h3><h4>Cliente :<u>".$cliente.
			"</u> Total R$: <u><b>".number_format($total,2,',','.')."</b></u></h4>
			<h3>Carros selecionados:</h3></table><br>
			<a href='http://localhost/projeto_locadora'>Voltar</a>";
	} else {
		echo '<h4>Nenhum item encontrado para essa locaÃ§Ã£o.</h4>';
	}
}catch(PDOException $ex){
	error_log('con_recibo error: ' . $ex->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?></fildset></div></div></body></html>
