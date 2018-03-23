<?php
class db_solicitacoes{
  private $host = 'localhost';
  private $usuario = 'root';
  private $senha = 'root';
  private $database = 'registro_solicitacoes';

  public function conecta_mysql(){
    
    // sudo nano /etc/apache2/envvars
    // export DB_PATH=testanto
    // sudo service apache2 restart
    $output = shell_exec('env | grep DB_PATH');
    $pieces = explode("=", $output);
    $this->host = trim($pieces[1]);
    echo $this->host;

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
