<?php
include ("conexao.php");
try{
	$sql = 'SELECT cod_bairro, bairro FROM bairro';
	foreach ($conn->query($sql) as $row) {
		$cod = intval($row['cod_bairro']);
		$bairroEsc = htmlspecialchars($row['bairro'], ENT_QUOTES, 'UTF-8');
		print $cod . " " . $bairroEsc . "<br/>";
	}
}catch(PDOException $ex_){
	error_log('con_bairro error: ' . $ex_->getMessage());
	echo '<h4>Ocorreu um erro. Contate o administrador.</h4>';
}
?>