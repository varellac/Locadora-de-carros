<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Projeto Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">    
</head>
<body>
<h1>Cadastro de carro</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php
include("conexao.php");
include_once __DIR__ . '/csrf.php';
// Validate CSRF token
$token = $_POST['csrf_token'] ?? '';
if (!csrf_check($token)) {
    echo '<h4>RequisiÃ§Ã£o invÃ¡lida (token CSRF).</h4>';
    exit;
}
try{
    // Validate and sanitize input
    $var_carro = isset($_POST['txt_carro']) ? trim($_POST['txt_carro']) : '';
    $var_tipo = filter_input(INPUT_POST, 'cmb_tipo', FILTER_VALIDATE_INT);
    $var_montadora = filter_input(INPUT_POST, 'cmb_montadora', FILTER_VALIDATE_INT);
    $var_valor_raw = isset($_POST['txt_valor']) ? str_replace(',', '.', trim($_POST['txt_valor'])) : '';
    $var_valor = is_numeric($var_valor_raw) ? (float)$var_valor_raw : 0.0;

    if ($var_carro === '' || $var_tipo === false || $var_montadora === false) {
        echo '<h4>Dados invÃ¡lidos. Verifique os campos e tente novamente.</h4>';
    } else {
        $sql = "INSERT INTO carro (carro, tipo_carro, montadora_carro, valor)
                VALUES (:carro, :tipo, :montadora, :valor)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':carro' => $var_carro,
            ':tipo' => $var_tipo,
            ':montadora' => $var_montadora,
            ':valor' => $var_valor,
        ]);
        echo '<h4>Carro incluÃ­do com sucesso</h4>';
        echo '<h3><a href="/locadora_m8">Voltar</a></h3>';
    }
}catch(PDOException $ex){
    error_log('cad_carro error: ' . $ex->getMessage());
    echo '<h4>Ocorreu um erro ao processar a requisiÃ§Ã£o. Contate o administrador.</h4>';
}
?>
</fieldset></div></div></body></html>
