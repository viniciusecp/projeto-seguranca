<?php
session_start();
require_once('db_acesso.class.php');

$usuario = $_POST['inputUsuario'];
$senha = md5($_POST['inputSenha']);

$objDb = new db_acesso();
$link = $objDb->conecta_mysql();
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha';";

$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {
  $dados_usuario = mysqli_fetch_array($resultado_id);

  if (isset($dados_usuario['usuario'])) {  // se o campo usuario estiver preenchido
    $_SESSION['id_usuario'] = $dados_usuario['id'];
    $_SESSION['usuario'] = $dados_usuario['usuario'];
    header('Location: home.php');
  } else {
    header('Location: index.php?erro=1');  //erro=1 -> usuário não existe
  }
} else {
  header('Location: index.php?erro=2');
}
?>
