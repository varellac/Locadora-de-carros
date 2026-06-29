<?php include __DIR__ . '/controle/verifica_cliente.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Cliente - M8</title>
    <link rel="stylesheet" type="text/css" href="estilo/geral.css">
    <style>
        .rental-form { display: flex; flex-direction: column; gap: 20px; }
        .date-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .price-tag {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-top: -14px;
            margin-bottom: 4px;
            padding-left: 4px;
        }
        .total-box {
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.35);
            border-radius: 12px;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.4s ease;
        }
        .total-box .label { color: var(--text-secondary); font-size: 0.95rem; }
        .total-box .value {
            font-size: 1.6rem;
            font-weight: 800;
            color: #60a5fa;
        }
        .total-box .days-tag {
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-align: right;
            margin-top: 2px;
        }
        .hidden { display: none; }
        .car-option-info {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-top: -14px;
            margin-bottom: 4px;
            padding-left: 4px;
        }
        #car-daily-rate { color: #60a5fa; font-weight: 600; }
    </style>
</head>
<body>
<header>
    <div class="header-container">
        <h1>M8 LOCADORA</h1>
        <nav>
            <span style="color:#94a3b8; margin-right: 20px; font-size: 0.9rem;">Área do Cliente</span>
            <a href="controle/logout.php" style="background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); padding: 8px 16px; border-radius: 8px; color: #f87171;">Sair</a>
        </nav>
    </div>
</header>
<main>
    <div class="flex-container">
        <div id="box" class="card">
            <h2 style="color: white; margin-bottom: 8px;">Alugar um Veículo</h2>
            <p style="color: var(--text-secondary); margin-bottom: 24px; font-size: 0.9rem;">Escolha o carro, selecione as datas e confirme sua reserva.</p>

            <?php if (isset($_GET['bem_vindo'])): ?>
            <div style="background: rgba(139,92,246,0.15); border: 1px solid rgba(139,92,246,0.4); border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; color: #c084fc; font-weight: 600;">
                🎉 Conta criada com sucesso! Seja bem-vindo(a) à M8 Locadora!
            </div>
            <?php elseif (isset($_GET['sucesso'])): 
                $nome_carro = htmlspecialchars(urldecode($_GET['carro'] ?? ''));
                $dias = intval($_GET['dias'] ?? 0);
                $total = number_format(floatval($_GET['total'] ?? 0), 2, ',', '.');
            ?>
            <div style="background: rgba(34,197,94,0.15); border: 1px solid rgba(34,197,94,0.4); border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; color: #4ade80; font-weight: 600;">
                ✅ Reserva confirmada! <br>
                <span style="font-weight: 400; color: #86efac; font-size: 0.9rem;">
                    <b><?= $nome_carro ?></b> por <?= $dias ?> dia(s) — Total: <b>R$ <?= $total ?></b>
                </span>
            </div>
            <?php elseif (isset($_GET['erro'])): ?>
            <div style="background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.4); border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; color: #f87171;">
                ⚠️ Erro ao processar sua reserva. Verifique os dados e tente novamente.
            </div>
            <?php endif; ?>

            <form method="POST" action="controle/cad_locacao_cliente.php" class="rental-form" id="rentalForm">

                <div>
                    <label>Veículo</label>
                    <select name="cmb_carro" id="cmb_carro" required onchange="updateCarInfo()">
                        <option value="">-- Escolha um veículo --</option>
                        <?php
                        include ("controle/conexao.php");
                        try {
                            $sql = 'SELECT c.cod_carro, c.carro, c.valor, m.montadora, t.tipo
                                    FROM carro c
                                    JOIN montadora m ON c.montadora_carro = m.cod_montadora
                                    JOIN tipo t ON c.tipo_carro = t.cod_tipo
                                    ORDER BY c.carro';
                            $stmt = $conn->query($sql);
                            $rows = $stmt->fetchAll();
                            foreach ($rows as $row) {
                                $val = intval($row['cod_carro']);
                                $nome = htmlspecialchars($row['carro'], ENT_QUOTES, 'UTF-8');
                                $montadora = htmlspecialchars($row['montadora'], ENT_QUOTES, 'UTF-8');
                                $tipo = htmlspecialchars($row['tipo'], ENT_QUOTES, 'UTF-8');
                                $valor = number_format($row['valor'], 2, ',', '.');
                                echo "<option value='{$val}' data-valor='{$row['valor']}' data-tipo='{$tipo}' data-montadora='{$montadora}'>{$nome} ({$montadora}) — R$ {$valor}/dia</option>";
                            }
                        } catch(PDOException $ex) {
                            echo '<option disabled>Erro ao carregar veículos.</option>';
                        }
                        ?>
                    </select>
                    <p class="car-option-info hidden" id="car-info">
                        Categoria: <span id="car-tipo">—</span> &nbsp;|&nbsp; Diária: <span id="car-daily-rate">—</span>
                    </p>
                </div>

                <div class="date-row">
                    <div>
                        <label>Data de Início</label>
                        <input type="date" name="txt_data_locacao" id="txt_data_locacao" required
                               value="<?php echo date('Y-m-d'); ?>"
                               min="<?php echo date('Y-m-d'); ?>"
                               onchange="calcTotal()">
                    </div>
                    <div>
                        <label>Data de Devolução</label>
                        <input type="date" name="txt_data_devolucao" id="txt_data_devolucao" required
                               min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                               onchange="calcTotal()">
                    </div>
                </div>

                <div class="total-box" id="total-box">
                    <div>
                        <div class="label">Total estimado</div>
                        <div class="days-tag" id="days-label">Selecione as datas e o veículo</div>
                    </div>
                    <div class="value" id="total-value">R$ —</div>
                </div>

                <input type="hidden" name="total_valor" id="total_valor" value="0">

                <input type="submit" value="Confirmar Reserva" id="submitBtn" disabled style="opacity: 0.5; cursor: not-allowed; transition: all 0.3s;">
            </form>
        </div>
    </div>
</main>

<script>
    let currentDiaria = 0;

    function updateCarInfo() {
        const sel = document.getElementById('cmb_carro');
        const opt = sel.options[sel.selectedIndex];
        const carInfo = document.getElementById('car-info');

        if (sel.value === '') {
            carInfo.classList.add('hidden');
            currentDiaria = 0;
            calcTotal();
            return;
        }

        currentDiaria = parseFloat(opt.dataset.valor) || 0;
        document.getElementById('car-tipo').textContent = opt.dataset.tipo;
        document.getElementById('car-daily-rate').textContent = 'R$ ' + currentDiaria.toFixed(2).replace('.', ',');
        carInfo.classList.remove('hidden');
        calcTotal();
    }

    function calcTotal() {
        const inicio = document.getElementById('txt_data_locacao').value;
        const fim = document.getElementById('txt_data_devolucao').value;
        const totalValorInput = document.getElementById('total_valor');
        const submitBtn = document.getElementById('submitBtn');
        const totalBox = document.getElementById('total-box');

        // Ensure end date is after start date
        if (inicio) {
            const nextDay = new Date(inicio);
            nextDay.setDate(nextDay.getDate() + 1);
            const minFim = nextDay.toISOString().split('T')[0];
            document.getElementById('txt_data_devolucao').min = minFim;
            if (fim && fim <= inicio) {
                document.getElementById('txt_data_devolucao').value = minFim;
                return calcTotal();
            }
        }

        if (!inicio || !fim || currentDiaria === 0) {
            document.getElementById('total-value').textContent = 'R$ —';
            document.getElementById('days-label').textContent = 'Selecione as datas e o veículo';
            totalValorInput.value = 0;
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
            submitBtn.style.cursor = 'not-allowed';
            totalBox.style.borderColor = 'rgba(59,130,246,0.35)';
            return;
        }

        const d1 = new Date(inicio);
        const d2 = new Date(fim);
        const dias = Math.round((d2 - d1) / (1000 * 60 * 60 * 24));

        if (dias <= 0) {
            document.getElementById('total-value').textContent = 'R$ —';
            document.getElementById('days-label').textContent = 'Data inválida';
            return;
        }

        const total = dias * currentDiaria;
        document.getElementById('total-value').textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
        document.getElementById('days-label').textContent = dias + (dias === 1 ? ' dia' : ' dias') + ' × R$ ' + currentDiaria.toFixed(2).replace('.', ',') + '/dia';
        totalValorInput.value = total.toFixed(2);

        totalBox.style.borderColor = 'rgba(59,130,246,0.7)';
        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
        submitBtn.style.cursor = 'pointer';
    }
</script>
</body>
</html>
