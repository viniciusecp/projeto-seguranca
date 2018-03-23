<?php
$loopStart = time();
$updateAt = 3;
$loopSeconds = 20;


// sudo nano /etc/apache2/envvars
// export DB_PATH=testanto
// sudo service apache2 restart
$output = shell_exec('env | grep DB_PATH');
$pieces = explode("=", $output);
$db_path = trim($pieces[1]);


$pdo = new PDO("mysql:host=$db_path;dbname=registro_solicitacoes", "root", "root");

if(isset($_POST["timestamp"])){
	$timestamp = $_POST["timestamp"];
} else {
	$current = $pdo->prepare("SELECT NOW() AS now");
	$current->execute();
	$row = $current->fetchObject();
	$timestamp = $row->now;
}

$timestamp = date($timestamp, time() + $updateAt);

$sql = $pdo->prepare("SELECT id,matricula,nome,telefone,empresa,regional_estacao,data,entrada,saida,ordem_servico,atividade,descricao_atividade FROM solicitacoes_acesso WHERE timestamp > :timestamp ORDER BY id");
$sql->bindParam(":timestamp", $timestamp, PDO::PARAM_STR);

$newMessages = false;
$newRequest = array();

while(!$newMessages && (time() - $loopStart) < $loopSeconds){
	$sql->execute();
	while($row = $sql->fetchAll(PDO::FETCH_ASSOC)){
		$newRequest = $row;
		$newMessages = true;
	}
	usleep(500000);
}

$current = $pdo->prepare("SELECT NOW() AS now");
$current->execute();
$row = $current->fetchObject();
$timestamp = $row->now;

$data = array('solicitacoes'=>$newRequest, 'timestamp'=>$timestamp);
echo json_encode($data);
exit;
?>
