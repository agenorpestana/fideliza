<?php 
require_once("../../../conexao.php");
$tabela = 'comentarios';
@session_start();
$id_usuario = $_SESSION['id'];
$comentario = $_POST['comentario'];
$status = $_POST['status'];
$id_os = $_POST['id_curso'];


$comentario = str_replace("'", " ", $comentario);
$comentario = str_replace('"', ' ', $comentario);

$query = $pdo->prepare("INSERT INTO $tabela SET id_formulario = '$id_os', comentario = :comentario, id_os = '$id_os', id_usuario = '$id_usuario', data = curDate(), respondida = 'Não', status_comentario = :status");

$query->bindValue(":status", "$status");
$query->bindValue(":comentario", "$comentario");
$query->execute();


$query = $pdo->prepare("UPDATE formulario SET status = :status WHERE id = :id_os");
$query->bindParam(":id_os", $id_os);
$query->bindParam(":status", $status);
$query->execute();

echo 'Salvo com Sucesso';

?>