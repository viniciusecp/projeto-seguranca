<?php
session_start();

require_once('db_solicitacoes.class.php');

$matricula = base64_encode($_POST['matricula']);
$nome = base64_encode($_POST['nome']);
$telefone = base64_encode($_POST['telefone']);
$empresa = base64_encode($_POST['empresa']);
$estacao = base64_encode($_POST['estacao']);
$data = $_POST['data'];
$entrada = $_POST['entrada'];
$saida = $_POST['saida'];
$numeroOS = base64_encode($_POST['numeroOS']);
$atividade = base64_encode($_POST['atividade']);
$descricaoAtividade = base64_encode($_POST['descricaoAtividade']);

$objDb = new db_solicitacoes();
$link = $objDb->conecta_mysql();

$mensagem = '';
$redirecionar = 0;

//$sql = "SELECT * FROM solicitacoes_acesso WHERE ordem_servico = '$numeroOS'";
//if ($resultado_id = mysqli_query($link, $sql)) {
  //$dados_OS = mysqli_fetch_array($resultado_id);
  //if (isset($dados_OS['ordem_servico'])) {
    //$mensagem = '<h2><div class="alert alert-warning">Ordem de serviço já cadastrada!</div></h2>';
  //} else {
    $sql = "INSERT INTO solicitacoes_acesso(matricula, nome, telefone, empresa, regional_estacao, data, entrada, saida, ordem_servico, atividade, descricao_atividade) VALUES('$matricula', '$nome', '$telefone', '$empresa', '$estacao', '$data', '$entrada', '$saida', '$numeroOS', '$atividade', '$descricaoAtividade');";

    if (mysqli_query($link, $sql)) {
      $mensagem = '<h2><div class="alert alert-success">Solicitação de acesso enviada!</div></h2>';
    } else {
      $mensagem = '<h2><div class="alert alert-danger">Erro ao enviar a solitação de acesso!</div></h2>';
    }
  //}
//} else {
  //$mensagem = '<h2><div class="alert alert-danger">Erro na consulta de OS no banco de dados!</div></h2>';
//}

echo '<!-- Janela Modal ---------------------------------------------------------------------------------------->';
echo '<form class="modal fade" id="janela_modal" data-redirecionar="'.$redirecionar.'">';
  echo '<div class="modal-dialog modal-lg"  >';
    echo '<div class="modal-content">';
      echo $mensagem;
    echo '</div>';
  echo '</div>';
echo '</form>';
echo '<!-- Janela Modal ---------------------------------------------------------------------------------------->';

?>
