<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
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
include_once __DIR__ . '/csrf.php';
$token = $_POST['csrf_token'] ?? '';
if (!csrf_check($token)) {
    echo '<h4>RequisiÃ§Ã£o invÃ¡lida (token CSRF).</h4>';
    exit;
}
try{
    $var_cliente = filter_input(INPUT_POST, 'cmb_cliente', FILTER_VALIDATE_INT);
    $var_data = isset($_POST['txt_data']) ? trim($_POST['txt_data']) : null;
    if ($var_cliente === false || $var_data === null) {
        echo '<h4>Dados invÃ¡lidos.</h4>';
    } else {
        $stmt = $conn->prepare('INSERT INTO locacao (cliente_locacao, data_locacao, data_devolucao) VALUES (:cliente, :data, :devolucao)');
        // set data_devolucao same as data or NULL if not provided; original schema requires both â€” adjust as needed
        $stmt->execute([':cliente' => $var_cliente, ':data' => $var_data, ':devolucao' => $var_data]);
        // store current locacao in session to avoid race conditions
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $lastId = (int)$conn->lastInsertId();
        $_SESSION['current_locacao'] = $lastId;
        echo '<h4>LocaÃ§Ã£o inicializada (ID: ' . $lastId . ')</h4>';
        echo '<h3><a href="../formulario/form_cad_itens.php">Selecione os VeÃ­culos</a></h3>';
    }
}catch(PDOException $ex){
    error_log('cad_locacao error: ' . $ex->getMessage());
    echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>
