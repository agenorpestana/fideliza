<?php 
$tabela = 'indicacoes';
require_once("../../../conexao.php");

echo $id = $_POST['id'];

$obs_ind = $_POST['obs_ind'];

//validacao nome
/*$query = $pdo->query("SELECT * from $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Nome já Cadastrado!';
	exit();
}*/


if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET obs_ind = :obs_ind ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET obs_ind = :obs_ind where id = '$id'");
}
$query->bindValue(":obs_ind", "$obs_ind");

$query->execute();

echo 'Salvo com Sucesso';
 ?>