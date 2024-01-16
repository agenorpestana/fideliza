<?php 
$tabela = 'indicacoes';
require_once("../../../conexao.php");

$id = $_POST['id'];
$status = $_POST['status'];
$obs = $_POST['obs'];

//validacao nome
/*$query = $pdo->query("SELECT * from $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Nome já Cadastrado!';
	exit();
}*/


$query = $pdo->prepare("UPDATE $tabela SET status = :status, obs = :obs where id = '$id'");

$query->bindValue(":status", "$status");
$query->bindValue(":obs", "$obs");

$query->execute();

echo 'Salvo com Sucesso';
 ?>