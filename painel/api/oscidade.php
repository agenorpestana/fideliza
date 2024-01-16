<?php 
require_once("../../conexao.php");

// Dados de autenticação
//require('WebserviceClient.php');

$host = 'https://ixc.itlfibra.com/webservice/v1';
$token = '75:b938ef38b4a4154c32248aaf79025b169bff1f2380a0163fb6109922c60d3ea9'; // Token gerado no cadastro do usuário (verificar permissões)
$selfSigned = true; // True para certificado auto assinado

// Crie uma instância da classe WebserviceClient
$api5 = new IXCsoft\WebserviceClient($host, $token, $selfSigned);

// Define a quantidade de registros por página
$registrosPorPaginaCi = 10000;
$params = array(
    'qtype' => 'cidade.id', // Campo de filtro
    'query' => '0', // Valor para consultar
    'oper' => '>=', // Operador da consulta
    'page' => '1', // Página a ser mostrada
    'rp' => $registrosPorPaginaCi, // Quantidade de registros por página
    'sortname' => 'cidade.id', // Campo para ordenar a consulta
    'sortorder' => 'desc' // Ordenação (asc= crescente | desc=decrescente)
);

// Faz a solicitação à API
$api5->get('cidade', $params);

// Obtém a resposta da API em formato JSON
$respostaJsonCi = $api5->getRespostaConteudo(false);
//echo($respostaJsonU);
// Decodifica a resposta JSON
$data = json_decode($respostaJsonCi, true);

// Verifica se a resposta foi bem-sucedida
if ($data && isset($data['registros'])) {
    $cidadeixc = $data['registros'];

    $cidadeAssociativos = array();

    foreach ($cidadeixc as $cidade) {
        $idCidade = $cidade['id'];
        $nomeCidade = $cidade['nome'];
        $cidadeAssociativos[$idCidade] = $nomeCidade;
    }

    //echo json_encode($assuntoAssociativos);
} else {
    echo 'Nenhum Registro encontrado.';
}
?>
