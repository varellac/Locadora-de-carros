<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>M8 Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">
</head>
<body>
<h1>Cadastro de carro</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php include __DIR__ . '/../controle/csrf.php'; ?>
<form method="POST" action="../controle/cad_carro.php">
    <table>
    <?php echo csrf_input(); ?>
    <tr><td><label>Carro:</label></td><td><input type="text" name="txt_carro"/></td></tr>
    <tr><td><label>Tipo:</label></td>
        <td><?php
            include ("../controle/conexao.php");
            try{
                $sql = 'SELECT * FROM tipo ORDER BY tipo';
                $stmt = $conn->query($sql);
                $rows = $stmt->fetchAll();
                print "<select name='cmb_tipo'>";
                foreach ($rows as $row) {
                    $val = intval($row['cod_tipo']);
                    $txt = htmlspecialchars($row['tipo'], ENT_QUOTES, 'UTF-8');
                    print "<option value='".$val."'>".$txt."</option>";
                }
                print "</select>";
            }catch(PDOException $ex){
	            echo 'Erro '. $ex->getMessage();
            }
        ?></td>
    </tr>
    <tr><td><label>Montadora:</label></td>
        <td><?php
            include ("../controle/conexao.php");
            try{
                $sql = 'SELECT * FROM montadora ORDER BY montadora';
                $stmt = $conn->query($sql);
                $rows = $stmt->fetchAll();
                print "<select name='cmb_montadora'>";
                foreach ($rows as $row) {
                    $val = intval($row['cod_montadora']);
                    $txt = htmlspecialchars($row['montadora'], ENT_QUOTES, 'UTF-8');
                    print "<option value='".$val."'>".$txt."</option>";
                }
                print "</select>";
             }catch(PDOException $ex){
	            echo 'Erro '. $ex->getMessage();
            }
        ?></td>
    </tr>
    <tr><td><label>Valor:</label></td><td><input type="text" name="txt_valor"/></td></tr>
    <tr><td></td><td><nav class="botoes"><input type="submit" value="Cadastrar"></nav></td></tr>
    </table>
</form></fieldset></div></div></body></html>