<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Cadastro de locacao</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php
include("conexao.php");
try{
    $var_cliente=$_POST['cmb_cliente'];
    $var_data=$_POST['txt_data'];
    $var_data=DATE($var_data);
    $sql="INSERT INTO locacao(cliente_locacao,data_locacao) VALUES ('$var_cliente','$var_data')";
    $conn->query($sql);
    echo "<h4>Locação inicializada</h4>
        <h3><a href='../formulario/form_cad_itens.php'>Selecione os Veiculos</a></h3>";    
}catch(PDOException $ex){
    echo "Erro ".$ex->getMessage();
}
?>
</fieldset></div></div></body></html>