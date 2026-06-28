<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
<?php
include(__DIR__ . '/conexao.php');
include_once __DIR__ . '/csrf.php';
$token = $_POST['csrf_token'] ?? '';
if (!csrf_check($token)) {
    $message = '<h4>RequisiÃ§Ã£o invÃ¡lida (token CSRF).</h4>';
} else {
    try{
        $var_bairro = isset($_POST['txt_bairro']) ? trim($_POST['txt_bairro']) : '';
        if ($var_bairro === '') {
            $message = '<h4>Nome do bairro invÃ¡lido.</h4>';
        } else {
            $stmt = $conn->prepare('INSERT INTO bairro (bairro) VALUES (:bairro)');
            $stmt->execute([':bairro' => $var_bairro]);
            $message = '<h4>Bairro incluÃ­do com sucesso</h4>';
            $message .= '<h3><a href="/locadora_m8">Voltar</a></h3>';
        }
    }catch(PDOException $ex){
        error_log('cad_bairro error: ' . $ex->getMessage());
        $message = '<h4>Ocorreu um erro. Contate o administrador.</h4>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
    <link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Cadastro de bairro</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php echo $message ?? ''; ?>
</fieldset></div></div></body></html>
