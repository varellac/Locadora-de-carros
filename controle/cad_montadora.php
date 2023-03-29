<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Cadastro de montadora</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php
include("conexao.php");
try{
    $var_montadora=$_POST['txt_montadora'];
    $sql="INSERT INTO montadora(montadora) VALUES ('$var_montadora')";
    $conn->query($sql);
    echo "<h4>Montadora incluido com sucesso</h4>
        <h3><a href='/locadora_m8'>Voltar</a></h3>";    
}catch(PDOException $ex){
    echo "Erro ".$ex->getMessage();
}
?>
</fieldset></div></div></body></html>