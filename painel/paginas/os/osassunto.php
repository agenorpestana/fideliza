<?php 
require_once("../../../conexao.php");

// Dados de autenticação
//require('WebserviceClient.php');

$host = 'https://ixc.itlfibra.com/webservice/v1';
$token = '75:b938ef38b4a4154c32248aaf79025b169bff1f2380a0163fb6109922c60d3ea9'; // Token gerado no cadastro do usuário (verificar permissões)
$selfSigned = true; // True para certificado auto assinado

// Crie uma instância da classe WebserviceClient
$api4 = new IXCsoft\WebserviceClient($host, $token, $selfSigned);

// Define a quantidade de registros por página
$registrosPorPaginaA = 10000;
$params = array(
    'qtype' => 'su_oss_assunto.id', // Campo de filtro
    'query' => '0', // Valor para consultar
    'oper' => '>=', // Operador da consulta
    'page' => '1', // Página a ser mostrada
    'rp' => $registrosPorPaginaA, // Quantidade de registros por página
    'sortname' => 'su_oss_assunto.id', // Campo para ordenar a consulta
    'sortorder' => 'desc' // Ordenação (asc= crescente | desc=decrescente)
);

// Faz a solicitação à API
$api4->get('su_oss_assunto', $params);

// Obtém a resposta da API em formato JSON
$respostaJsonA = $api4->getRespostaConteudo(false);
//echo($respostaJsonU);
// Decodifica a resposta JSON
$data = json_decode($respostaJsonA, true);

// Verifica se a resposta foi bem-sucedida
if ($data && isset($data['registros'])) {
    $assuntoixc = $data['registros'];

    $assuntoAssociativos = array();

    foreach ($assuntoixc as $assunto) {
        $idAssunto = $assunto['id'];
        $nomeAssunto = $assunto['assunto'];
        $assuntoAssociativos[$idAssunto] = $nomeAssunto;
    }

    //echo json_encode($assuntoAssociativos);
} else {
    echo 'Nenhum Registro encontrado.';
}
?>
