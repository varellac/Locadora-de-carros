<?php
include __DIR__ . '/verifica_cliente.php';
include __DIR__ . '/conexao.php';

$id_cliente = $_SESSION['id_cliente'];
$carro_id = filter_input(INPUT_POST, 'cmb_carro', FILTER_VALIDATE_INT);
$data = $_POST['txt_data_locacao'] ?? '';

if (!$carro_id || empty($data)) {
    echo "<!DOCTYPE html><html lang='pt-BR'><head><link rel='stylesheet' href='../estilo/geral.css'></head><body><div class='flex-container'><div id='box' class='card'><h2>Dados inválidos!</h2><br><a href='../area_cliente.php'>Voltar</a></div></div></body></html>";
    exit;
}

try {
    $conn->beginTransaction();
    
    // Fetch car price
    $stmt = $conn->prepare("SELECT valor FROM carro WHERE cod_carro = ?");
    $stmt->execute([$carro_id]);
    $carro = $stmt->fetch();
    $valor = $carro['valor'];

    // Insert locacao
    $stmt = $conn->prepare("INSERT INTO locacao (cliente_locacao, data_locacao) VALUES (?, ?)");
    $stmt->execute([$id_cliente, $data]);
    $locacao_id = $conn->lastInsertId();

    // Insert carros_locacao
    $stmt = $conn->prepare("INSERT INTO carros_locacao (carro_locado, locacao, valor) VALUES (?, ?, ?)");
    $stmt->execute([$carro_id, $locacao_id, $valor]);

    $conn->commit();

    echo "<!DOCTYPE html><html lang='pt-BR'><head><link rel='stylesheet' href='../estilo/geral.css'></head><body><div class='flex-container'><div id='box' class='card'><h2>Reserva confirmada com sucesso! 🚗</h2><br><a href='../area_cliente.php'>Voltar para minha área</a></div></div></body></html>";
} catch (PDOException $ex) {
    $conn->rollBack();
    echo "Erro: " . $ex->getMessage();
}
