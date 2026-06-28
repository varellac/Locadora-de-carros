<?php include __DIR__ . '/controle/verifica_cliente.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Área do Cliente - M8</title>
    <link rel="stylesheet" type="text/css" href="estilo/geral.css">
</head>
<body>
<header>
    <div class="header-container">
        <h1>M8 LOCADORA - ÁREA DO CLIENTE</h1>
        <nav>
            <span style="color:#fff; margin-right: 20px;">Bem-vindo!</span>
            <a href="controle/logout.php" style="background: rgba(255,0,0,0.4); padding: 8px 16px; border-radius: 8px; color: white;">Sair</a>
        </nav>
    </div>
</header>
<main>
    <div class="flex-container">
        <div id="box" class="card">
            <h2 style="margin-bottom: 24px; color: white;">Alugar um Veículo</h2>
            <form method="POST" action="controle/cad_locacao_cliente.php">
                <label>Selecione o veículo desejado:</label>
                <?php
                include ("controle/conexao.php");
                try {
                    $sql = 'SELECT c.cod_carro, c.carro, c.valor, m.montadora 
                            FROM carro c 
                            JOIN montadora m ON c.montadora_carro = m.cod_montadora 
                            ORDER BY c.carro';
                    $stmt = $conn->query($sql);
                    $rows = $stmt->fetchAll();
                    echo "<select name='cmb_carro' required>";
                    echo "<option value=''>-- Escolha um veículo --</option>";
                    foreach ($rows as $row) {
                        $val = intval($row['cod_carro']);
                        $txt = htmlspecialchars($row['carro'] . " (" . $row['montadora'] . ") - R$ " . $row['valor'], ENT_QUOTES, 'UTF-8');
                        echo "<option value='".$val."'>".$txt."</option>";
                    }
                    echo "</select>";
                } catch(PDOException $ex) {
                    echo 'Erro ao carregar veículos.';
                }
                ?>
                <label>Data da Locação:</label>
                <input type="date" name="txt_data_locacao" required value="<?php echo date('Y-m-d'); ?>">
                
                <input type="submit" value="Confirmar Locação" style="margin-top: 20px;">
            </form>
        </div>
    </div>
</main>
</body>
</html>
