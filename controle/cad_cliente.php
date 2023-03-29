<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Cadastro de cliente</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php
include("conexao.php");
try{
    $var_cliente=$_POST['txt_cliente'];
    $var_bairro=$_POST['cmb_bairro'];
    $var_cpf=$_POST['txt_cpf'];
    $sql="INSERT INTO cliente(cliente,bairro_cliente,cpf) VALUES ('$var_cliente',$var_bairro,'$var_cpf')";
    $conn->query($sql);
    echo "<h4>cliente incluido com sucesso</h4>
        <h3><a href='/locadora_m8'>Voltar</a></h3>";    
}catch(PDOException $ex){
    echo "Erro ".$ex->getMessage();
}
?>
</fieldset></div></div></body></html>