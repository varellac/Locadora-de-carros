<?php include __DIR__ . '/../controle/csrf.php'; ?>
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
<h1>Atualização de bairro</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<form method="POST" action="../controle/up_bairro.php">
	<?php echo csrf_input(); ?>
	<h3>Escolha o bairro a ser modificado</h3>
	<?php
		include (__DIR__ . '/../controle/conexao.php');
		try{
			$stmt = $conn->query('SELECT cod_bairro, bairro FROM bairro ORDER BY bairro');
			echo "<select name='cmb_bairro'>";
			foreach($stmt as $row){
				$val = intval($row['cod_bairro']);
				$txt = htmlspecialchars($row['bairro'], ENT_QUOTES, 'UTF-8');
				echo "<option value='".$val."'>".$txt."</option>";
			}
			echo "</select>";
		}catch(PDOException $ex){
			error_log('form_up_bairro error: '. $ex->getMessage());
			echo '<p>Erro ao carregar bairros.</p>';
		}
	?>
	<label>Novo nome:</label>
	<input type="text" name="txt_bairro" />
	<nav class="botoes"><input type="submit" value="Atualizar"></nav>
</form>
</fieldset></div></div></body></html>