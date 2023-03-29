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
<h1>Seleção de veículos</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php
include("conexao.php");
try{
    $item=$_POST['item'];
    $sql="SELECT cod_locacao FROM locacao ORDER BY cod_locacao DESC LIMIT 1";
    foreach($conn->query($sql) as $row){
        $codloc=$row['cod_locacao'];
    }
    $sql="INSERT INTO carros_locacao(carro_locado,locacao) VALUES ('$item',$codloc)";
    $conn->query($sql);
    echo "<h4>Item incluido com sucesso</h4>
        <h3><a href='/locadora_m8/formulario/form_cad_itens.php'>Selecionar outro veículo</a></h3><br>
        <h3><a href='/locadora_m8/formulario/cad_finalizar.php'>Proceder com locação</a></h3>";
}catch(PDOException $ex){
    echo "Erro ".$ex->getMessage();
}
?></fieldset></div></div></body></html>