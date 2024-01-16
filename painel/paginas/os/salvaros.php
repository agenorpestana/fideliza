<?php

//require_once("../../../conexao.php");

// Dados de autenticação

/*require('WebserviceClient.php');
require('listarusuarios.php');
require('osassunto.php');
require('oscidade.php');*/


//echo ('chegou');

$host = 'https://ixc.itlfibra.com/webservice/v1';
$token = '75:b938ef38b4a4154c32248aaf79025b169bff1f2380a0163fb6109922c60d3ea9'; // Token gerado no cadastro do usuário (verificar permissões)
$selfSigned = true; // True para certificado auto assinado

// Crie uma instância da classe WebserviceClient
$api = new IXCsoft\WebserviceClient($host, $token, $selfSigned);

// Define o número da página atual
//$paginaAtual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
// Define a quantidade de registros por página

$registrosPorPagina = 10000;

$valorA = 'EN';
$valorB = 'A';
$valorC = 'F';
$valoresConsulta = ['EN'];
$params = array(
    'qtype' => 'su_oss_chamado.status', // Campo de filtro
    'query' => 'A,EN,F', // Valor para consultar
    'oper' => '>', // Operador da consulta
    'page' => '1', // Página a ser mostrada
    'rp' => $registrosPorPagina, // Quantidade de registros por página
    'sortname' => 'su_oss_chamado.data_abertura', // Campo para ordenar a consulta
    'sortorder' => 'desc' // Ordenação (asc= crescente | desc=decrescente)
);

// Faz a solicitação à API
$api->get('su_oss_chamado', $params);

// Obtém a resposta da API em formato JSON
$respostaJson = $api->getRespostaConteudo(false);
//echo $respostaJson;

// Decodifica a resposta JSON
$data = json_decode($respostaJson, true);
//var_dump($data);
// Verifica se a resposta foi bem-sucedida

// Verifica se a resposta foi bem-sucedida
if ($data && isset($data['registros'])) {
    $chamados = $data['registros'];

    foreach ($chamados as $chamado) {
      if ($chamado['data_abertura'] > "2015-01-01") {  
        $id_os = $chamado['id'];
        $funcionario = isset($usuariosAssociativos[$chamado['id_tecnico']]) ? $usuariosAssociativos[$chamado['id_tecnico']] : 'OS não Associada a um Técnico';
        $data_abertura = $chamado['data_abertura'];
        $data_fechamento = $chamado['data_fechamento'];
        $id_assunto = $chamado['id_assunto'];
        $id_cidade = $chamado['id_cidade'];
        $assunto = isset($assuntoAssociativos[$id_assunto]) ? $assuntoAssociativos[$id_assunto] : 'Sem assunto';
        $cidade = isset($cidadeAssociativos[$id_cidade]) ? $cidadeAssociativos[$id_cidade] : 'Cidade não encontrada';

        // Verifique se já existe uma entrada com a mesma id_os no banco de dados
        $query = $pdo->prepare("SELECT * FROM $tabela WHERE id_os = :id_os");
        $query->bindParam(":id_os", $id_os, PDO::PARAM_INT);
        $query->execute();
        $existingOS = $query->fetch(PDO::FETCH_ASSOC);

        if ($existingOS) {
            // Verifique se houve alterações nos campos
            if (
                $existingOS['funcionario'] !== $funcionario ||
                $existingOS['data_abertura'] !== $data_abertura ||
                $existingOS['data_fechamento'] !== $data_fechamento ||
                $existingOS['id_assunto'] !== $id_assunto ||
                $existingOS['id_cidade'] !== $id_cidade ||
                $existingOS['assunto'] !== $assunto ||
                $existingOS['cidade'] !== $cidade
            ) {
                // Houve alterações, atualize a entrada existente
                $query = $pdo->prepare("UPDATE $tabela SET funcionario = :funcionario, data_abertura = :data_abertura, data_fechamento = :data_fechamento, id_assunto = :id_assunto, id_cidade = :id_cidade, assunto = :assunto, cidade = :cidade WHERE id_os = :id_os");
                $query->bindParam(":id_os", $id_os, PDO::PARAM_INT);
                $query->bindParam(":funcionario", $funcionario, PDO::PARAM_STR);
                $query->bindParam(":data_abertura", $data_abertura, PDO::PARAM_STR);
                $query->bindParam(":data_fechamento", $data_fechamento, PDO::PARAM_STR);
                $query->bindParam(":id_assunto", $id_assunto, PDO::PARAM_INT);
                $query->bindParam(":id_cidade", $id_cidade, PDO::PARAM_INT);
                $query->bindParam(":assunto", $assunto, PDO::PARAM_STR);
                $query->bindParam(":cidade", $cidade, PDO::PARAM_STR);
                $query->execute();
            }
        } else {
            // A entrada não existe, insira uma nova entrada no banco de dados
            $query = $pdo->prepare("INSERT INTO $tabela (id_os, funcionario, data_abertura, data_fechamento, id_assunto, id_cidade, assunto, cidade) VALUES (:id_os, :funcionario, :data_abertura, :data_fechamento, :id_assunto, :id_cidade, :assunto, :cidade)");
            $query->bindParam(":id_os", $id_os, PDO::PARAM_INT);
            $query->bindParam(":funcionario", $funcionario, PDO::PARAM_STR);
            $query->bindParam(":data_abertura", $data_abertura, PDO::PARAM_STR);
            $query->bindParam(":data_fechamento", $data_fechamento, PDO::PARAM_STR);
            $query->bindParam(":id_assunto", $id_assunto, PDO::PARAM_INT);
            $query->bindParam(":id_cidade", $id_cidade, PDO::PARAM_INT);
            $query->bindParam(":assunto", $assunto, PDO::PARAM_STR);
            $query->bindParam(":cidade", $cidade, PDO::PARAM_STR);
            $query->execute();
        }
    }
}
} else {
    echo 'Nenhum Novo Registro encontrado.';
}



?>
