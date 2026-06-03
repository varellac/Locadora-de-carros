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
<h1>Atualização de montadora</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php include __DIR__ . '/../controle/csrf.php'; ?>
<form method="POST" action="../controle/up_montadora.php">
	<?php echo csrf_input(); ?>
	<h3>Escolha o montadora a ser modificado</h3>
<?php
include ("../controle/conexao.php");
try{
  $sql = 'SELECT * FROM montadora ORDER BY montadora';
  print "<select name='cmb_montadora'>";
  foreach ($conn->query($sql) as $row) {
    print "<option value='".$row['cod_montadora']."'>".$row['montadora']."</option>";
  }
  print "</select>";
}catch(PDOException $ex){
	echo 'Erro '. $ex->getMessage();
}
	<?php
		include ("../controle/conexao.php");
		try{
			$sql = 'SELECT cod_montadora, montadora FROM montadora ORDER BY montadora';
			$stmt = $conn->query($sql);
			$rows = $stmt->fetchAll();
			print "<select name='cmb_montadora'>";
			foreach($rows as $row){
				$val = intval($row['cod_montadora']);
				$txt = htmlspecialchars($row['montadora'], ENT_QUOTES, 'UTF-8');
				print "<option value='".$val."'>".$txt."</option>";
			}
			print "</select>";
		}catch(PDOException $ex){
			error_log('form_up_montadora error: '. $ex->getMessage());
			echo '<p>Erro ao carregar montadoras.</p>';
		}
	?>