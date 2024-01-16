<?php 
require_once("../../conexao.php");

// Dados de autenticação
//require('WebserviceClient.php');

$host = 'https://ixc.itlfibra.com/webservice/v1';
$token = '75:b938ef38b4a4154c32248aaf79025b169bff1f2380a0163fb6109922c60d3ea9'; // Token gerado no cadastro do usuário (verificar permissões)
$selfSigned = true; // True para certificado auto assinado

// Crie uma instância da classe WebserviceClient
$api3 = new IXCsoft\WebserviceClient($host, $token, $selfSigned);

// Define a quantidade de registros por página
$registrosPorPaginaU = 10000;
$params = array(
    'qtype' => 'funcionarios.id', // Campo de filtro
    'query' => '0', // Valor para consultar
    'oper' => '>', // Operador da consulta
    'page' => '1', // Página a ser mostrada
    'rp' => $registrosPorPaginaU, // Quantidade de registros por página
    'sortname' => 'funcionarios.id', // Campo para ordenar a consulta
    'sortorder' => 'desc' // Ordenação (asc= crescente | desc=decrescente)
);

// Faz a solicitação à API
$api3->get('funcionarios', $params);

// Obtém a resposta da API em formato JSON
$respostaJsonU = $api3->getRespostaConteudo(false);
//echo($respostaJsonU);
// Decodifica a resposta JSON
$data = json_decode($respostaJsonU, true);

// Verifica se a resposta foi bem-sucedida
if ($data && isset($data['registros'])) {
    $usuariosixc = $data['registros'];

    $funcionarioAssociativos = array();

    foreach ($usuariosixc as $usuario) {
        $idUsuario = $usuario['id'];
        $nomeUsuario = $usuario['funcionario'];
        $funcionarioAssociativos[$idUsuario] = $nomeUsuario;
    }

    //echo json_encode($funcionarioAssociativos);
} else {
    echo 'Nenhum Registro encontrado.';
}
?>
