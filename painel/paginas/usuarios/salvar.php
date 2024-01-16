<?php 
$tabela = 'usuarios';
require_once("../../../conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$nivel = $_POST['nivel'];
$endereco = $_POST['endereco'];
$senha = '123';
$senha_crip = md5($senha);
$id = $_POST['id'];
$token = bin2hex(random_bytes(16));

//validacao email
$query = $pdo->query("SELECT * from $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
    echo 'Email já Cadastrado!';
    exit();
}

//validacao telefone
$query = $pdo->query("SELECT * from $tabela where telefone = '$telefone'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
    echo 'Telefone já Cadastrado!';
    exit();
}

if($id == ""){
    $query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, email = :email, senha = '$senha', senha_crip = '$senha_crip', nivel = '$nivel', ativo = 'Sim', foto = 'sem-foto.jpg', telefone = :telefone, data = curDate(), endereco = :endereco, token = :token ");
} else {
    $query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, nivel = '$nivel', telefone = :telefone, endereco = :endereco, token = :token where id = '$id'");
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":token", $token);
$query->execute();

$link = "https://itlfibra.com/formulario.php?token_os=" . $token;

echo 'Salvo com Sucesso';

//enviando mensagem via WhatsApp
if ($api_whatsapp == 'Sim'){
    $telefone_envio = '55' . preg_replace('/[ ()-]+/', '', $telefone);
    if ($id == ""){
        $mensagem = "_*mensagem automática de:* ($nome_sistema)_ \r\n\r\n";
    } else {
        $mensagem = "_*mensagem automática de:* ($nome_sistema)_ \r\n\r\n";
    }
    $mensagem .= "Nome: *$nome* \r\n";
    $mensagem .= "Email e Login: *$email* \r\n";
    $mensagem .= "Senha: *123* \r\n\r\n";
    $mensagem .= "Acesse https://itlfbira.com/fideliza";

    $mensagem .= "Link: *$link*";
    
    require("../../api/texto.php");
}
?>
