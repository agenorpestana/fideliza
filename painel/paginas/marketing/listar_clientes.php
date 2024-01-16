<?php 

require_once("../../../conexao.php");



$dataMes = Date('m');

$dataDia = Date('d');

$dataAno = Date('Y');

$data_atual = date('Y-m-d');



$data_semana = date('Y-m-d', strtotime("-7 days",strtotime($data_atual)));

//var_dump($data_semana);

@session_start();

$id_usuario = $_SESSION['id'];



$clientes = $_POST['cli'];



// Buscar os Contatos que serão enviados

if($clientes == "Teste"){

	$resultado = $pdo->query("SELECT telefone FROM usuarios where nivel = 'Administrador' and telefone != ''");	



}else if($clientes == "Aniversáriantes Mês"){

	$resultado = $pdo->query("SELECT telefone FROM ixclientes where month(data_nasc) = '$dataMes'  and telefone != ''");	

	

}else if ($clientes == "Aniversáriantes Dia"){

	$resultado = $pdo->query("SELECT telefone FROM ixclientes where month(data_nasc) = '$dataMes' and day(data_nasc) = '$dataDia' and telefone != ''");



}else if ($clientes == "Clientes Mês"){

	$resultado = $pdo->query("SELECT telefone FROM ixclientes where month(data_cadastro) = '$dataMes' and year(data_cadastro) = '$dataAno' and telefone != ''");



}else if ($clientes == "Clientes Semana"){

	$resultado = $pdo->query("SELECT telefone FROM ixclientes where data_cadastro >= '$data_semana' and telefone != ''");



}else{

	$resultado = $pdo->query("SELECT telefone FROM ixclientes where telefone != '' and ativo = 'S' ");

}



$res = $resultado->fetchAll(PDO::FETCH_ASSOC);

$total_reg = @count($res);



echo $total_reg;



?>