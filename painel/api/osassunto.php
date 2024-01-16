<?php 
require_once("../../conexao.php");

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

        // Verifique se já existe uma entrada com a mesma id_os no banco de dados
            $query2 = $pdo->prepare("SELECT * FROM assunto_pontua WHERE id_assunto = :id_assunto");
            $query2->bindParam(":id_assunto", $idAssunto, PDO::PARAM_INT);
            $query2->execute();
            $existingAssunto = $query2->fetch(PDO::FETCH_ASSOC);

            if ($existingAssunto) {
            // Verifique se houve alterações nos campos
                if (
                   
                    $existingAssunto['nome_assunto'] !== $nomeAssunto                  
                ) {
                // Houve alterações, atualize a entrada existente
                    $query2 = $pdo->prepare("UPDATE assunto_pontua SET nome_assunto = :nome_assunto WHERE id_assunto = :id_assunto");
                    $query2->bindParam(":id_assunto", $idAssunto, PDO::PARAM_INT);
                    $query2->bindParam(":nome_assunto", $nomeAssunto, PDO::PARAM_STR);
                    
                    
                    $query2->execute();

                                   
                }
            } else {
               
            // A entrada não existe, insira uma nova entrada no banco de dados
                $query2 = $pdo->prepare("INSERT INTO assunto_pontua (id_assunto, nome_assunto) VALUES (:id_assunto, :nome_assunto)");
                $query2->bindParam(":id_assunto", $idAssunto, PDO::PARAM_INT);
                $query2->bindParam(":nome_assunto", $nomeAssunto, PDO::PARAM_STR);
               
                $query2->execute();


               

            }

    }

    //echo json_encode($assuntoAssociativos);
} else {
    echo 'Nenhum Registro encontrado.';
}
?>
