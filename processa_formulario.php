<?php
$tabela = 'formulario';
include_once("conexao.php");
$token_os = $_POST['token_os'];
$id_os = $_POST['id_os'];

// Consulta SQL para obter o id_cliente da tabela 'os'
$queryOs = $pdo->prepare("SELECT id_cliente, id_os, nome_cliente, whatsapp_cli FROM os WHERE id = ?");
$queryOs->execute([$id_os]);
$resultOs = $queryOs->fetch(PDO::FETCH_ASSOC);



if ($resultOs) {
    $id_cliente = $resultOs['id_cliente'];
    $idOS = $resultOs['id_os'];
    $nome_cliente = $resultOs['nome_cliente'];
    $whatsapp_cli = $resultOs['whatsapp_cli'];
    

    if (!empty($_POST['avaliacaoCurso']) && ($_POST['avaliacaoInstalacao']) && ($_POST['probabilidade'])) {
        $perg1 = $_POST['avaliacaoCurso'];
        $perg2 = $_POST['avaliacaoInstalacao'];
        $perg3 = $_POST['probabilidade'];
        $perg4 = $_POST['melhorarSatisfacao'];

        // Insira os dados do formulário na tabela 'formulario' incluindo o id_cliente
        $query = $pdo->prepare("INSERT INTO $tabela ( perg1, perg2, perg3, perg4, id_cliente, id_os, nome_cliente, telefone_cliente, status, data_resposta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pendente', NOW())");
        $query->execute([$perg1, $perg2, $perg3, $perg4, $id_cliente, $idOS, $nome_cliente, $whatsapp_cli]);

        if ($query) {
            // Marque o formulário como respondido na tabela 'os'
            $query = $pdo->prepare("UPDATE os SET formulario_respondido_os = 1 WHERE id = ?");
            $query->execute([$id_os]);

            $popupMessage = "Obrigado por responder nosso questionário ";
            if ($perg3 > 8){
                $redirectUrl = "indique.php";
            }else{
                $redirectUrl = "https://www.instagram.com/itlfibraprovedor/";
            }
        } else {
            $popupMessage = "Erro ao cadastrar a avaliação.";
            $redirectUrl = "formulario.php?token=" . $token_os;
        }
    } else {
        $popupMessage = "Necessário selecionar pelo menos 1 estrela.";
        $redirectUrl = "formulario.php?token=" . $token_os;
    }
} else {
    $popupMessage = "Erro ao obter o ID do cliente associado a esta ordem de serviço.";
    $redirectUrl = "formulario.php?token_os=" . $token_os;
}

// Passa as mensagens e a URL de redirecionamento para o JavaScript
echo "<script>
        var popupMessage = '" . addslashes($popupMessage) . "';
        var redirectUrl = '" . addslashes($redirectUrl) . "';

        // Exibe o popup
        alert(popupMessage);

        // Redireciona após clicar em OK
        window.location.href = redirectUrl;
      </script>";
?>
