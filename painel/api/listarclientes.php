<?php 
//$tabela = 'contatos';
require_once("../../conexao.php");

// Dados de autenticação
//require('WebserviceClient.php');


$host = 'https://ixc.itlfibra.com/webservice/v1';
$token = '75:b938ef38b4a4154c32248aaf79025b169bff1f2380a0163fb6109922c60d3ea9'; // Token gerado no cadastro do usuário (verificar permissões)
$selfSigned = true; // True para certificado auto assinado

// Crie uma instância da classe WebserviceClient
$api2 = new IXCsoft\WebserviceClient($host, $token, $selfSigned);

// Define a quantidade de registros por página
$registrosPorPaginaC = 10000;
$params = array(
    'qtype' => 'cliente.id', // Campo de filtro
    'query' => '0', // Valor para consultar
    'oper' => '>', // Operador da consulta
    'page' => '1', // Página a ser mostrada
    'rp' => $registrosPorPaginaC, // Quantidade de registros por página
    'sortname' => 'cliente.id', // Campo para ordenar a consulta
    'sortorder' => 'desc' // Ordenação (asc= crescente | desc=decrescente)
);


// Faz a solicitação à API
$api4->get('cliente', $params);

// Obtém a resposta da API em formato JSON
$respostaJsonC = $api4->getRespostaConteudo(false);
//echo($respostaJsonU);
// Decodifica a resposta JSON
$data = json_decode($respostaJsonC, true);

// Verifica se a resposta foi bem-sucedida
if ($data && isset($data['registros'])) {
    $clientesixc = $data['registros'];

    $usuariosAssociativos = array();

    foreach ($clientesixc as $clienteixc) {
        $idCliente = $clienteixc['id'];
        $nomeCliente = $clienteixc['razao'];
        $whatsappCli = $clienteixc['telefone_celular'];
        $clientesAssociativos[$idCliente] = $nomeCliente;
        $clientesAssociativosWhatsapp[$idCliente] = $whatsappCli;
    }

    //echo json_encode($usuariosAssociativos);
} else {
    echo 'Nenhum Registro encontrado.';
}
?>


