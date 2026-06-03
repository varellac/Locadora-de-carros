<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>M8 Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">
</head>
<body>
<h1>Exclusão de carro</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php include __DIR__ . '/../controle/csrf.php'; ?>
<form method="POST" action="../controle/del_carro.php">
    <?php echo csrf_input(); ?>
<label>carro:</label>
    <?php
        include ("../controle/conexao.php");
        try{
              $sql = 'SELECT cod_carro, placa, modelo FROM carro ORDER BY placa';
            print "<select name='cmb_carro'>";
              $stmt = $conn->query($sql);
              $rows = $stmt->fetchAll();
              foreach($rows as $row){
                 $val = intval($row['cod_carro']);
                 $pla = htmlspecialchars($row['placa'], ENT_QUOTES, 'UTF-8');
                 $mod = htmlspecialchars($row['modelo'], ENT_QUOTES, 'UTF-8');
                 print "<option value='".$val."'>".$pla." - " . $mod . "</option>";
            }
            print "</select>";
        }catch(PDOException $ex){
              error_log('form_del_carro error: '. $ex->getMessage());
              echo '<p>Erro ao carregar carros.</p>';
        }
    ?><br>
    <nav class="botoes"><input type="submit" value="Excluir"></nav>
</form></fieldset></div></div></body></html>