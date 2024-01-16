<?php
// Inclua o arquivo de conexão com o banco de dados
//include_once("../../conexao.php");

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os valores do formulário

    $cpfcnpj = $_POST["cpfcnpj"];


// Dados de autenticação
    require('../api/WebserviceClient.php');

    $host = 'https://ixc.itlfibra.com/webservice/v1';
$token = '75:b938ef38b4a4154c32248aaf79025b169bff1f2380a0163fb6109922c60d3ea9'; // Token gerado no cadastro do usuário (verificar permissões)
$selfSigned = true; // True para certificado auto assinado

// Crie uma instância da classe WebserviceClient
$api3 = new IXCsoft\WebserviceClient($host, $token, $selfSigned);

// Define a quantidade de registros por página
$registrosPorPaginaU = 10000;
$params = array(
    'qtype' => 'cliente.id', // Campo de filtro
    'query' => '0', // Valor para consultar
    'oper' => '>=', // Operador da consulta
    'page' => '1', // Página a ser mostrada
    'rp' => $registrosPorPaginaU, // Quantidade de registros por página
    'sortname' => 'cliente.id', // Campo para ordenar a consulta
    'sortorder' => 'desc' // Ordenação (asc= crescente | desc=decrescente)
);

// Faz a solicitação à API
$api3->get('cliente', $params);

// Obtém a resposta da API em formato JSON
$respostaJsonU = $api3->getRespostaConteudo(false);
//var_dump($respostaJsonU);
// Decodifica a resposta JSON
$data = json_decode($respostaJsonU, true);

// Verifica se a resposta foi bem-sucedida
if ($data && isset($data['registros'])) {
    $clientesixc = $data['registros'];
    $cliente_encontrado = false;



    foreach ($clientesixc as $cliente) {
            // Limpe o valor do CNPJ/CPF da API para remover possíveis caracteres especiais ou formatações
        $cnpj_cpf_api = preg_replace('/[^0-9]/', '', $cliente['cnpj_cpf']);

    // Limpe o valor do CNPJ/CPF recebido do formulário
        $cpfcnpj_limpo = preg_replace('/[^0-9]/', '', $cpfcnpj);
   
    // Compare os valores sem formatação
        // Compare os valores sem formatação
    if ($cnpj_cpf_api === $cpfcnpj_limpo) {
        // O CNPJ/CPF corresponde, então você pode imprimir o nome correspondente
        
        e$razao = $cliente['razao'];
        $telefone_celular = $cliente['telefone_celular'];
         break; // Saia do loop, pois você encontrou uma correspondência
    
    }
   
}

if (!$cliente_encontrado) {
    echo "<br>";
    echo "Cliente não encontrado"; // Exibe a mensagem se nenhum cliente for encontrado
}
header("Location: indique.php?razao=" . urlencode($razao) . "&telefone_celular=" . urlencode($telefone_celular));
exit;

}

}
    
?>