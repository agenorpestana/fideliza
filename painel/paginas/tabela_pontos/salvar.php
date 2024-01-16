<?php 
$tabela = 'assunto_pontua';
require_once("../../../conexao.php");

$pontos = $_POST['pontos'];
$pontos_negativo = $_POST['pontos_negativo'];
$id = $_POST['id'];

//validacao nome

$query = $pdo->prepare("UPDATE $tabela SET pontos = :pontos, pontos_negativo = :pontos_negativo where id = '$id'");


$query->bindValue(":pontos", "$pontos");
$query->bindValue(":pontos_negativo", "$pontos_negativo");

$query->execute();

echo 'Salvo com Sucesso';
 ?>