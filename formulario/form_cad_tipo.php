<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>M8 Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">
</head>
<body>
<h1>Cadastro de tipo</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php include __DIR__ . '/../controle/csrf.php'; ?>
<form method="POST" action="../controle/cad_tipo.php">
    <?php echo csrf_input(); ?>
    <label>tipo:</label>
    <input type="text" name="txt_tipo"/>
    <nav class="botoes"><input type="submit" value="Cadastrar"></nav>
</form></fieldset></div></div></body></html>
