<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>M8 Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">
</head>
<body>
<h1>Exclusão de bairro</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php include __DIR__ . '/../controle/csrf.php'; ?>
<form method="POST" action="../controle/del_bairro.php">
    <?php echo csrf_input(); ?>
<label>Bairro:</label>
    <?php
        include ("../controle/conexao.php");
        try{
            $sql = 'SELECT * FROM bairro ORDER BY bairro';
            $stmt = $conn->query($sql);
            $rows = $stmt->fetchAll();
            print "<select name='cmb_bairro'>";
            foreach($rows as $row){
                $val = intval($row['cod_bairro']);
                $txt = htmlspecialchars($row['bairro'], ENT_QUOTES, 'UTF-8');
                print "<option value='".$val."'>".$txt."</option>";
            }
            print "</select>";
        }catch(PDOException $ex){
            error_log('form_del_bairro error: '. $ex->getMessage());
            echo '<p>Erro ao carregar bairros.</p>';
        }
    ?>
    <nav class="botoes"><input type="submit" value="Excluir"></nav>
</form></fieldset></div></div></body></html>