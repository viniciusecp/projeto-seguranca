<?php
class db_solicitacoes{
  private $host = 'localhost';
  private $usuario = 'root';
  private $senha = 'root';
  private $database = 'registro_solicitacoes';

  public function conecta_mysql(){
    $con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);
    mysqli_set_charset($con, 'utf8');

    if (mysqli_connect_errno()) {
      //header('Location: index.php?erro=2');
      echo 'Erro ao tentar se conectar com o DB MySQl: '.mysqli_connect_error();
    }
    return $con;
  }
}
?>
