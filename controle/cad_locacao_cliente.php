<?php
include __DIR__ . '/verifica_cliente.php';
include __DIR__ . '/conexao.php';

$id_cliente = $_SESSION['id_cliente'];
$carro_id = filter_input(INPUT_POST, 'cmb_carro', FILTER_VALIDATE_INT);
$data_inicio = $_POST['txt_data_locacao'] ?? '';
$data_fim = $_POST['txt_data_devolucao'] ?? '';

if (!$carro_id || empty($data_inicio) || empty($data_fim)) {
    header("Location: ../area_cliente.php?erro=dados_invalidos");
    exit;
}

// Validate dates
$d1 = new DateTime($data_inicio);
$d2 = new DateTime($data_fim);
if ($d2 <= $d1) {
    header("Location: ../area_cliente.php?erro=data_invalida");
    exit;
}

$dias = $d2->diff($d1)->days;

try {
    // Fetch car price
    $stmt = $conn->prepare("SELECT valor, carro FROM carro WHERE cod_carro = ?");
    $stmt->execute([$carro_id]);
    $carro = $stmt->fetch();
    if (!$carro) {
        header("Location: ../area_cliente.php?erro=carro_nao_encontrado");
        exit;
    }

    $valor_diaria = $carro['valor'];
    $valor_total = round($dias * $valor_diaria, 2);

    $conn->beginTransaction();

    // Insert locacao
    $stmt = $conn->prepare("INSERT INTO locacao (cliente_locacao, data_locacao, data_devolucao) VALUES (?, ?, ?)");
    $stmt->execute([$id_cliente, $data_inicio, $data_fim]);
    $locacao_id = $conn->lastInsertId();

    // Insert carros_locacao
    $stmt = $conn->prepare("INSERT INTO carros_locacao (carro_locado, locacao, valor) VALUES (?, ?, ?)");
    $stmt->execute([$carro_id, $locacao_id, $valor_total]);

    $conn->commit();

    // Redirect to success page with details
    $nome_carro = urlencode($carro['carro']);
    header("Location: ../area_cliente.php?sucesso=1&carro={$nome_carro}&dias={$dias}&total={$valor_total}");
} catch (PDOException $ex) {
    $conn->rollBack();
    error_log("cad_locacao_cliente error: " . $ex->getMessage());
    header("Location: ../area_cliente.php?erro=erro_interno");
    exit;
}
