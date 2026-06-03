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
        echo '<h4>Requisição inválida (token CSRF).</h4>';
        exit;
    }

    $item = filter_input(INPUT_POST, 'item', FILTER_VALIDATE_INT);
    if ($item === false || $item === null) {
        echo '<h4>Item inválido.</h4>';
        exit;
    }

    // prefer locacao from session (set when cad_locacao.php inserted)
    $codloc = $_SESSION['current_locacao'] ?? null;
    if ($codloc === null) {
        // fallback to POSTed locacao id if provided
        $codloc = filter_input(INPUT_POST, 'locacao', FILTER_VALIDATE_INT);
    }
    if ($codloc === false || $codloc === null) {
        echo '<h4>Nenhuma locação encontrada para associar o item.</h4>';
        exit;
    }

    $ins = $conn->prepare('INSERT INTO carros_locacao (carro_locado, locacao) VALUES (:carro, :locacao)');
    $ins->execute([':carro' => $item, ':locacao' => $codloc]);

    echo '<h4>Item incluído com sucesso</h4>';
    echo '<h3><a href="/locadora_m8/formulario/form_cad_itens.php">Selecionar outro veículo</a></h3><br>';
    echo '<h3><a href="/locadora_m8/formulario/cad_finalizar.php">Proceder com locação</a></h3>';
} catch (PDOException $ex) {
    error_log('inserir_carros error: ' . $ex->getMessage());
    echo '<h4>Ocorreu um erro ao processar a requisição. Contate o administrador.</h4>';
}
?>