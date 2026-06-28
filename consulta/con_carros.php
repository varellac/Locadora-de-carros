<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
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
include_once __DIR__ . '/../controle/csrf.php';
try{
	$token = $_POST['csrf_token'] ?? '';
	if (!csrf_check($token)) {
		echo '<h4>RequisiÃ§Ã£o invÃ¡lida (token CSRF).</h4>';
		exit;
	}
	$carro = isset($_POST['txt_carro']) ? trim($_POST['txt_carro']) : '';
	$sql = 'SELECT c.cod_carro, c.carro, t.tipo, m.montadora, c.valor FROM carro c '
		 . 'INNER JOIN tipo t ON t.cod_tipo = c.tipo_carro '
		 . 'INNER JOIN montadora m ON m.cod_montadora = c.montadora_carro '
		 . 'WHERE c.carro LIKE :carro ORDER BY c.carro';
	$stmt = $conn->prepare($sql);
	$stmt->execute([':carro' => "%$carro%"]);

	echo "<form method='post' action='/locadora_m8/controle/inserir_carros.php'>";
	echo csrf_input();
	foreach ($stmt->fetchAll() as $row) {
	   $carEsc = htmlspecialchars($row['carro'], ENT_QUOTES, 'UTF-8');
	   $tipoEsc = htmlspecialchars($row['tipo'], ENT_QUOTES, 'UTF-8');
	   $montEsc = htmlspecialchars($row['montadora'], ENT_QUOTES, 'UTF-8');
	   echo "<tr><td width='20%'><input type='radio' name='item' value='".intval($row['cod_carro'])."'>".$carEsc."</td>";
	   echo "<td width='25%'>".$tipoEsc."</td>";
	   echo "<td width='25%'>".$montEsc."</td>";
	   echo "<td class='valores' width='30%'> R$ ".number_format($row['valor'],2,',','.')."</td></tr>";
	}
	echo "</table><div><a href='/locadora_m8/formulario/form_cad_itens.php'>Voltar</a></div>";
	echo "<div><input type='submit' value='Incluir item'></div></form>";
}catch(PDOException $ex){
	error_log('con_carros error: ' . $ex->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?></table></div></div></body></html>
