<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
<?php
// Handler to add a selected car to the current locacao
include __DIR__ . '/conexao.php';
include_once __DIR__ . '/csrf.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
try {
    $token = $_POST['csrf_token'] ?? '';
    if (!csrf_check($token)) {
        echo '<h4>RequisiÃ§Ã£o invÃ¡lida (token CSRF).</h4>';
        exit;
    }

    $item = filter_input(INPUT_POST, 'item', FILTER_VALIDATE_INT);
    if ($item === false || $item === null) {
        echo '<h4>Item invÃ¡lido.</h4>';
        exit;
    }

    // prefer locacao from session (set when cad_locacao.php inserted)
    $codloc = $_SESSION['current_locacao'] ?? null;
    if ($codloc === null) {
        // fallback to POSTed locacao id if provided
        $codloc = filter_input(INPUT_POST, 'locacao', FILTER_VALIDATE_INT);
    }
    if ($codloc === false || $codloc === null) {
        echo '<h4>Nenhuma locaÃ§Ã£o encontrada para associar o item.</h4>';
        exit;
    }

    $ins = $conn->prepare('INSERT INTO carros_locacao (carro_locado, locacao) VALUES (:carro, :locacao)');
    $ins->execute([':carro' => $item, ':locacao' => $codloc]);

    echo '<h4>Item incluÃ­do com sucesso</h4>';
    echo '<h3><a href="/locadora_m8/formulario/form_cad_itens.php">Selecionar outro veÃ­culo</a></h3><br>';
    echo '<h3><a href="/locadora_m8/formulario/cad_finalizar.php">Proceder com locaÃ§Ã£o</a></h3>';
} catch (PDOException $ex) {
    error_log('inserir_carros error: ' . $ex->getMessage());
    echo '<h4>Ocorreu um erro ao processar a requisiÃ§Ã£o. Contate o administrador.</h4>';
}
?>
