<?php 
$tabela = 'indicacoes';
require_once("../../../conexao.php");

$id = $_POST['id'];
$nome_ind = $_POST['nome_indicado'];
$obs = $_POST['obs'];


//validacao nome
/*$query = $pdo->query("SELECT * from $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Nome já Cadastrado!';
	exit();
}*/


$query = $pdo->prepare("UPDATE $tabela SET nome_ind = :nome_indicado, obs = :obs where id = '$id'");

$query->bindValue(":nome_indicado", "$nome_ind");
$query->bindValue(":obs", "$obs");


$query->execute();

echo 'Salvo com Sucesso';
 ?>