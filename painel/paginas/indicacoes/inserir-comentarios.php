<?php 
require_once("../../../conexao.php");
$tabela = 'comentarios_indica';
@session_start();
$id_usuario = $_SESSION['id'];
$comentario = $_POST['comentario'];
$status = $_POST['status-aprovar'];
$id_os_aprovar = $_POST['id_os_aprovar'];
$id_formulario = $_POST['nome_do_cleinte_indica'];


if ($status == 'Aprovado') {

// Verificar se a OS existe
$queryVerificaOS = $pdo->prepare("SELECT * FROM os WHERE id_os = :id_os");
$queryVerificaOS->bindParam(":id_os", $id_os_aprovar);
$queryVerificaOS->execute();

if ($queryVerificaOS->rowCount() > 0) {
    // OS encontrada, proceda com a inserção do comentário e o update
    $comentario = str_replace("'", " ", $comentario);
    $comentario = str_replace('"', ' ', $comentario);

    $query = $pdo->prepare("INSERT INTO $tabela SET id_formulario = '$id_formulario', comentario = :comentario, id_os = '$id_os_aprovar', id_usuario = '$id_usuario', data = curDate(), respondida = 'Não', status_comentario = :status");

    $query->bindValue(":status", "$status");
    $query->bindValue(":comentario", "$comentario");
    $query->execute();

    $queryUpdate = $pdo->prepare("UPDATE indicacoes SET status = :status WHERE id = :id_formulario");
    $queryUpdate->bindParam(":id_formulario", $id_formulario);
    $queryUpdate->bindParam(":status", $status);
    $queryUpdate->execute();

    

    // Consulta SQL para obter o id_cliente da tabela 'os'
	$queryOs = $pdo->prepare("SELECT nome_cli, telefone_cli, nome_ind FROM indicacoes WHERE id = :id_formulario");
	$queryOs->bindParam(":id_formulario", $id_formulario);
	$queryOs->execute();
	$resultOs = $queryOs->fetch(PDO::FETCH_ASSOC);



if ($resultOs) {
    
   
    $nome_cliente = $resultOs['nome_cli'];
    $telefone_cli = $resultOs['telefone_cli'];
    $nome_ind = $resultOs['nome_ind'];


    $telefone_envio = '55' . preg_replace('/[ ()-]+/', '', $telefone_cli);
								
								$mensagem = "_*ITLFibra*_ \r\n\r\n";																				
								//$mensagem .= "Técnico: *$funcionario* \r\n";
								//$mensagem .= "Motivo: *$assunto* \r\n";
								//$mensagem .= "Parabéns seu indicado : *$nome_ind* finalizou o cadastro \r\n";
								$mensagem .= "Olá *$nome_cliente* \r\n\r\n";
								$mensagem .= "Parabéns seu indicado(a) : *$nome_ind* finalizou o cadastro \r\n";
								$mensagem .= "Entre em contato com o nosso suporte para receber o PIX: TEL *(73)99912-7074* \r\n\r\n";
								$mensagem .= "_*mensagem automática de:* ($nome_sistema)_";

								require("../../api/texto.php");
}

echo 'Salvo com Sucesso';

} else {
    // OS não encontrada, retorne uma mensagem
    echo 'OS não encontrada';
}

}else{

	$comentario = str_replace("'", " ", $comentario);
    $comentario = str_replace('"', ' ', $comentario);

    $query = $pdo->prepare("INSERT INTO $tabela SET id_formulario = '$id_formulario', comentario = :comentario, id_os = '$id_os_aprovar', id_usuario = '$id_usuario', data = curDate(), respondida = 'Não', status_comentario = :status");

    $query->bindValue(":status", "$status");
    $query->bindValue(":comentario", "$comentario");
    $query->execute();

    $queryUpdate = $pdo->prepare("UPDATE indicacoes SET status = :status WHERE id = :nome_cli");
    $queryUpdate->bindParam(":nome_cli", $id_formulario);
    $queryUpdate->bindParam(":status", $status);
    $queryUpdate->execute();

    echo 'Salvo com Sucesso';

}
?>
