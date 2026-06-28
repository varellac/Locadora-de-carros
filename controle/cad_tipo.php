<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Cadastro de tipo do veÃ­culo</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php
include("conexao.php");
include_once __DIR__ . '/csrf.php';
$token = $_POST['csrf_token'] ?? '';
if (!csrf_check($token)) {
    echo '<h4>RequisiÃ§Ã£o invÃ¡lida (token CSRF).</h4>';
    exit;
}
try{
    $var_tipo = isset($_POST['txt_tipo']) ? trim($_POST['txt_tipo']) : '';
    if ($var_tipo === '') {
        echo '<h4>Nome do tipo invÃ¡lido.</h4>';
    } else {
        $stmt = $conn->prepare('INSERT INTO tipo (tipo) VALUES (:tipo)');
        $stmt->execute([':tipo' => $var_tipo]);
        echo '<h4>Tipo incluÃ­do com sucesso</h4>';
        echo '<h3><a href="/locadora_m8">Voltar</a></h3>';
    }
}catch(PDOException $ex){
    error_log('cad_tipo error: ' . $ex->getMessage());
    echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>
