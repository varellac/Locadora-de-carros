<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>M8 Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">
</head>
<body>
<h1>Exclusão de cliente</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<form method="POST" action="../controle/del_cliente.php">
<label>cliente:</label>
    <?php
        include ("../controle/conexao.php");
        try{
            $sql = 'SELECT * FROM cliente ORDER BY cliente';
            print "<select name='cmb_cliente'>";
            foreach($conn->query($sql) as $row){
                print "<option value='".$row['cod_cliente']."'>".$row['cliente']."</option>";
            }
            print "</select>";
        }catch(PDOException $ex){
            echo 'Corra para as montanhas'.$ex->getMessage();
        }
    ?><br>
    <nav class="botoes"><input type="submit" value="Excluir"></nav>
</form></fieldset></div></div></body></html>