<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>M8 Locadora</title>
	<link rel="stylesheet" type="text/css" href="../estilo/geral.css">
</head>
<body>
<h1>ExclusÃ£o de montadora</h1>
<div class="flex-container">
<div id="box">
<fieldset>
<?php include __DIR__ . '/../controle/csrf.php'; ?>
<form method="POST" action="../controle/del_montadora.php">
    <?php echo csrf_input(); ?>
<label>montadora:</label>
            <?php
                include ("../controle/conexao.php");
                try{
                    $sql = 'SELECT cod_montadora, montadora FROM montadora ORDER BY montadora';
                    $stmt = $conn->query($sql);
                    $rows = $stmt->fetchAll();
                    print "<select name='cmb_montadora'>";
                    foreach($rows as $row){
                        $val = intval($row['cod_montadora']);
                        $txt = htmlspecialchars($row['montadora'], ENT_QUOTES, 'UTF-8');
                        print "<option value='".$val."'>".$txt."</option>";
                    }
                    print "</select>";
                }catch(PDOException $ex){
                    error_log('form_del_montadora error: '. $ex->getMessage());
                    echo '<p>Erro ao carregar montadoras.</p>';
                }
            ?>
    <nav class="botoes"><input type="submit" value="Excluir"></nav>
</form></fieldset></div></div></body></html>
