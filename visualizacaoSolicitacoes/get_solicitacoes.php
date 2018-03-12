<?php
session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php?erro=1');
}

require_once('db_solicitacoes.class.php');

$objDb = new db_solicitacoes();
$link = $objDb->conecta_mysql();

if(isset($_POST['dataSearch']) AND isset($_POST['inputEntradaSearch1']) AND isset($_POST['inputEntradaSearch2'])){
  $dataSearch = $_POST['dataSearch'];
  $inputEntradaSearch1 = $_POST['inputEntradaSearch1'];
  $inputEntradaSearch2 = $_POST['inputEntradaSearch2'];

  $sql = "SELECT * FROM solicitacoes_acesso WHERE data = '$dataSearch' ORDER BY id DESC;";
} else {
  $sql = "SELECT * FROM solicitacoes_acesso ORDER BY id DESC;";
}
//$sql = "SELECT * FROM solicitacoes_acesso ORDER BY id DESC;";

$resultado_id = mysqli_query($link, $sql);

if ($resultado_id) {
  while ($registro = mysqli_fetch_array($resultado_id)) {
    if (isset($_POST['dataSearch']) AND isset($_POST['inputEntradaSearch1']) AND isset($_POST['inputEntradaSearch2'])) {
      $horario = strtotime($registro['entrada']);
      $entradaSearch1 = strtotime($inputEntradaSearch1);
      $entradaSearch2 = strtotime($inputEntradaSearch2);

      if ( !(($entradaSearch1 < $entradaSearch2 && $horario >= $entradaSearch1 && $horario <= $entradaSearch2)
          || ($entradaSearch1 > $entradaSearch2 && ($horario >= $entradaSearch1 || $horario <= $entradaSearch2) ))
        ) {
          continue;
      }

      if ($registro['visualizado']) {
        $visualizado = "";
        $mostrarBotão = "none";
        $botaoSMS = "block";
      } else {
        $visualizado = "danger";
        $mostrarBotão = "block";
        $botaoSMS = "none";
      }
      echo '<tr id=row_'.$registro['id'].' class="'.$visualizado.'">';
        echo '<td>'.base64_decode($registro['matricula']).'</td>';
        echo '<td>'.base64_decode($registro['nome']).'</td>';
        echo '<td>'.base64_decode($registro['telefone']).'</td>';
        echo '<td>'.base64_decode($registro['empresa']).'</td>';
        echo '<td>'.base64_decode($registro['regional_estacao']).'</td>';
        echo '<td>'.$registro['data'].'</td>';
        echo '<td>'.$registro['entrada'].'</td>';
        echo '<td>'.$registro['saida'].'</td>';
        echo '<td>'.base64_decode($registro['ordem_servico']).'</td>';
        echo '<td>'.base64_decode($registro['atividade']).'</td>';
        echo '<td>'.base64_decode($registro['descricao_atividade']).'</td>';
        echo '<td>';
          echo '<button id=btn_'.$registro['id'].' class="btn btn-primary glyphicon glyphicon-ok btn-visualizado" style="display:'.$mostrarBotão.'"></button>';
          echo '<button id=btn_'.$registro['id'].' class="btn btn-info glyphicon glyphicon-envelope btn-SMS" style="display:'.$botaoSMS.'" data-telefone="'.base64_decode($registro['telefone']).'" data-toggle="modal" data-target="#janela_modal"></button>';
        echo '</td>';
      echo '</tr>';


    } else{
      if ($registro['visualizado']) {
        $visualizado = "";
        $mostrarBotão = "none";
        $botaoSMS = "block";
      } else {
        $visualizado = "danger";
        $mostrarBotão = "block";
        $botaoSMS = "none";
      }
      echo '<tr id=row_'.$registro['id'].' class="'.$visualizado.'">';
        echo '<td>'.base64_decode($registro['matricula']).'</td>';
        echo '<td>'.base64_decode($registro['nome']).'</td>';
        echo '<td>'.base64_decode($registro['telefone']).'</td>';
        echo '<td>'.base64_decode($registro['empresa']).'</td>';
        echo '<td>'.base64_decode($registro['regional_estacao']).'</td>';
        echo '<td>'.$registro['data'].'</td>';
        echo '<td>'.$registro['entrada'].'</td>';
        echo '<td>'.$registro['saida'].'</td>';
        echo '<td>'.base64_decode($registro['ordem_servico']).'</td>';
        echo '<td>'.base64_decode($registro['atividade']).'</td>';
        echo '<td>'.base64_decode($registro['descricao_atividade']).'</td>';
        echo '<td>';
          echo '<button id=btn_'.$registro['id'].' class="btn btn-primary glyphicon glyphicon-ok btn-visualizado" style="display:'.$mostrarBotão.'"></button>';
          echo '<button id=btn_'.$registro['id'].' class="btn btn-info glyphicon glyphicon-envelope btn-SMS" style="display:'.$botaoSMS.'" data-telefone="'.base64_decode($registro['telefone']).'" data-toggle="modal" data-target="#janela_modal"></button>';
        echo '</td>';
      echo '</tr>';
    }

  }
} else {
  echo 'Erro na consulta de usuários no banco de dados!';
}
?>
