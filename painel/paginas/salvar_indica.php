<?php
// Inclua o arquivo de conexão com o banco de dados
include_once("../../conexao.php");

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os valores do formulário
    $idCliente = $_POST["idCliente"];
    $nomeIndicado = $_POST["nomeIndicado"];
    $telefoneIndicado = $_POST["telefoneIndicado"];
    $cidadeIndicado = $_POST["cidadeIndicado"];

    // Consulta SQL para verificar se o telefone já existe na tabela de indicações
    $consultaExistencia = $pdo->prepare("SELECT COUNT(*) as count FROM indicacoes WHERE telefone_ind = :telefoneIndicado");
    $consultaExistencia->bindParam(":telefoneIndicado", $telefoneIndicado, PDO::PARAM_STR);

    // Consulta SQL para buscar o telefone do cliente
    $consultaCliente = $pdo->prepare("SELECT nome, telefone FROM ixclientes WHERE id_cliente = :idCliente");

    $consultaCliente->bindParam(":idCliente", $idCliente, PDO::PARAM_STR);

    // Execute a consulta para obter a contagem de registros com o mesmo telefone
    if ($consultaExistencia->execute()) {
        $count = $consultaExistencia->fetch(PDO::FETCH_ASSOC)['count'];

    if ($count > 0) {
        $popupMessage = "Já existe uma indicação para esse contato.";
        $redirectUrl = "../../indique.php";


        } else {
    // Execute a consulta para obter o telefone do cliente
    if ($consultaCliente->execute()) {
        $resultado = $consultaCliente->fetch(PDO::FETCH_ASSOC);
        if ($resultado) {
            $nomeCliente = $resultado['nome'];
            $telefoneCliente = $resultado['telefone'];


            // Consulta SQL para inserir os dados na tabela de indicações
            $query = $pdo->prepare("INSERT INTO indicacoes (nome_cli, telefone_cli, nome_ind, telefone_ind, cidade_ind, data_cadastro, status) VALUES (:nomeCliente, :telefoneCliente, :nomeIndicado, :telefoneIndicado, :cidadeIndicado, NOW(), 'Aguardando')");

            $query->bindParam(":nomeCliente", $nomeCliente, PDO::PARAM_STR);
            $query->bindParam(":telefoneCliente", $telefoneCliente, PDO::PARAM_STR);
            $query->bindParam(":nomeIndicado", $nomeIndicado, PDO::PARAM_STR);
            $query->bindParam(":telefoneIndicado", $telefoneIndicado, PDO::PARAM_STR);
            $query->bindParam(":cidadeIndicado", $cidadeIndicado, PDO::PARAM_STR);


            // Execute a consulta de inserção
            if ($query->execute()) {
                $popupMessage = "Indicação cadastrada com sucesso.";
                $redirectUrl = "../../indique.php";
            } else {
                $popupMessage = "Erro ao enviar indicação. Tente novamente.";
                $redirectUrl = "../../indique.php";
            }
        } else {
            $popupMessage = "Cliente não encontrado.";
            $redirectUrl = "../../indique.php";
        }
    } else {
        $popupMessage = "Erro ao buscar cliente. Tente novamente.";
        $redirectUrl = "../../indique.php";
    }
}
}
}

// Passa as mensagens e a URL de redirecionamento para o JavaScript
// Redirecione após mostrar a mensagem
echo "<script>
        var popupMessage = '" . addslashes($popupMessage) . "';
        var redirectUrl = '" . addslashes($redirectUrl) . "';

        // Exibe o popup
        alert(popupMessage);

        // Redireciona após clicar em OK
        window.location.href = redirectUrl;
      </script>";
?>
