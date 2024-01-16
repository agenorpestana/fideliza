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
