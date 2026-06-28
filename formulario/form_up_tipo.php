<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
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
<h1>AtualizaÃ§Ã£o de tipo</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php include __DIR__ . '/../controle/csrf.php'; ?>
<form method="POST" action="../controle/up_tipo.php">
	<?php echo csrf_input(); ?>
	<h3>Escolha o tipo a ser modificado</h3>
<?php
include ("../controle/conexao.php");
try{
  $sql = 'SELECT * FROM tipo ORDER BY tipo';
  print "<select name='cmb_tipo'>";
  foreach ($conn->query($sql) as $row) {
    print "<option value='".$row['cod_tipo']."'>".$row['tipo']."</option>";
  }
  print "</select>";
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
	<?php
		include ("../controle/conexao.php");
		try{
			$sql = 'SELECT cod_tipo, tipo FROM tipo ORDER BY tipo';
			$stmt = $conn->query($sql);
			$rows = $stmt->fetchAll();
			print "<select name='cmb_tipo'>";
			foreach($rows as $row){
				$val = intval($row['cod_tipo']);
				$txt = htmlspecialchars($row['tipo'], ENT_QUOTES, 'UTF-8');
				print "<option value='".$val."'>".$txt."</option>";
			}
			print "</select>";
		}catch(PDOException $ex){
			error_log('form_up_tipo error: '. $ex->getMessage());
			echo '<p>Erro ao carregar tipos.</p>';
		}
	?>
