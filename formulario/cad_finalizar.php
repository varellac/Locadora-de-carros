<?php include_once __DIR__ . '/../controle/verifica_funcionario.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Projeto Locadora</title>
	<link rel='stylesheet' type='text/css' href='../estilo/geral.css'>
</head>
<body>
<h1>Recibo</h1>    
<div class="flex-container">
<div id="box">
<fieldset>
<?php include __DIR__ . '/../controle/csrf.php'; ?>
<form method='POST' action='/locadora_m8/consulta/con_recibo.php'>
  <?php echo csrf_input(); ?>
    <label>Imprimir:</label>
<?php
include_once __DIR__ . '/../controle/conexao.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$locacao = $_SESSION['current_locacao'] ?? null;
if ($locacao === null) {
  // fallback to the latest locacao in DB
  try {
    $sql = 'SELECT cod_locacao FROM locacao ORDER BY cod_locacao DESC LIMIT 1';
    $query = $conn->prepare($sql);
    $query->execute();
    $locacao = $query->fetchColumn();
  } catch (PDOException $ex) {
    error_log('cad_finalizar error: ' . $ex->getMessage());
  }
}
if ($locacao) {
  echo "<input type='hidden' name='locacao' value='" . htmlspecialchars($locacao, ENT_QUOTES, 'UTF-8') . "'>";
} else {
  echo '<p>Nenhuma locaÃ§Ã£o disponÃ­vel para finalizar.</p>';
}
?>
    <input type='submit' name='Recibo' value='ok'>
</form></fieldset></div></div></body></html>
