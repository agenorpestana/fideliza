<?php 

require_once("../conexao.php");

$query = $pdo->query('SELECT funcionario FROM funcionarios');
$nomes = $query->fetchAll(PDO::FETCH_COLUMN);

$query2 = $pdo->query('SELECT nome_assunto FROM assunto_pontua');
$assuntos = $query2->fetchAll(PDO::FETCH_COLUMN);


$pdo = null;
 ?>

