<?php
// Inclua o arquivo de conexão com o banco de dados
include_once("../../conexao.php");

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os valores do formulário
   
    $cpfcnpj = $_POST["cpfcnpj"];
  

    // Consulta SQL baseada nos valores do formulário
    $query = "SELECT * FROM ixclientes WHERE cpfcnpj = :cpfcnpj";

    // Prepare a consulta
    $stmt = $pdo->prepare($query);

    // Substitua os parâmetros na consulta
    $stmt->bindParam(":cpfcnpj", $cpfcnpj, PDO::PARAM_STR);
  
    // Execute a consulta
    $stmt->execute();

    // Recupere os resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($resultados);
    // Faça algo com os resultados, como exibi-los na página
    if (count($resultados) > 0) {
        foreach ($resultados as $resultado) {
            // Exiba os dados encontrados
            echo "<br>";
            echo $resultado["id_cliente"];
            echo "<br>";
            echo $resultado["nome"];
           // echo "Outros campos: " . $resultado["outros_campos"] . "<br>";
            // Adicione mais campos conforme necessário
        }
    } else {
        echo "<br>";
        echo "CLIENTE ITLFibra não encontrado.";
    }

}
?>

<!-- <script>
     // Dentro da função que manipula a resposta da busca do nome do cliente
document.getElementById('nomeCliente').value = $resultado["nome"]; // Substitua 'resultadoDoCliente' pelo valor real que você está obtendo
</script>     
 -->