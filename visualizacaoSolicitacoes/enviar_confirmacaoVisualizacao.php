<?php
session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php?erro=1');
}

require_once('db_solicitacoes.class.php');

$idRow = $_POST['idRow'];

$objDb = new db_solicitacoes();
$link = $objDb->conecta_mysql();

$sql = "UPDATE solicitacoes_acesso SET visualizado = 1 WHERE id = $idRow;";
if (mysqli_query($link, $sql)) {
  
} else {
  $mensagem = '<h2><div class="alert alert-danger">Erro ao enviar a solitação de acesso!</div></h2>';
}

?>
