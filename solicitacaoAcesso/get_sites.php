<?php
require_once('db_estacoes.class.php');
$nome_rua = $_POST['input_pesquisar'];

$objDb = new db_estacoes();
$link = $objDb->conecta_mysql();

$sql = "SELECT * ";
$sql.= "FROM estacoes ";
$sql.= "WHERE ENDERECO LIKE '%$nome_rua%';";
//echo $sql;
$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {
  while ($registro = mysqli_fetch_array($resultado_id)) {
    echo '<a href="#" class="list-group-item link_estacao" id="id_estacao_'.$registro['ESTACAO_TEL_ID'].'" data-id_estacao="'.$registro['ESTACAO_TEL_ID'].'" data-empresa="'.$registro['TIPO_EMPRESA'].'" data-estacao="'.$registro['ESTACAO'].'" >';
      echo '<strong>'.$registro['TIPO_EMPRESA'].' - '.$registro['ESTACAO'].'</strong> - '.$registro['NOME_LOCALIDADE'].' <small> - '.$registro['ENDERECO'].'</small>';
      echo '<p class="list-group-item-text pull-right">';
      echo '</p>';
    echo '</a>';
  }

} else {
  echo 'Erro na consulta de usuários no banco de dados!';
}




?>
