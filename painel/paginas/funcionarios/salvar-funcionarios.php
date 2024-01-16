<?php 
$tabela = 'funcionarios';
require_once("../../../conexao.php");

// Dados de autenticação
require('../../api/WebserviceClient.php');

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
    'oper' => '>=', // Operador da consulta
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
    $usuarios = $data['registros'];

    foreach ($usuarios as $usuario) {
    if ($usuario['ativo'] = "S"){

    $id_funcao = $usuario['id_funcao'];
    $fone_celular = $usuario['fone'];
    $data_admissao = $usuario['data_admissao'];
    $ativo = $usuario['ativo'];
    $id_funcionario = $usuario['id'];
    $funcionario = $usuario['funcionario'];
  
    // Verifica se o cliente já existe no banco de dados
    $query = $pdo->prepare("SELECT * FROM $tabela WHERE id_funcionario = :id_funcionario");
    $query->bindParam(":id_funcionario", $id_funcionario, PDO::PARAM_INT);
    $query->execute();
    $existingClient = $query->fetch(PDO::FETCH_ASSOC);
    //var_dump($existingClient);

    /*$query = $pdo->query("SELECT * from $tabela where id_cliente = '$idixc'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $id_reg = @$res[0]['id'];*/

    

    //var_dump($id_ciente);
    /*if(@count($res) > 0 ){
    echo 'Cliente Já cadastrado';
    exit();
}*/
if ($existingClient) {
        if (
            // Verifica se há alterações nos campos
            $existingClient['id_funcao'] !== $id_funcao ||
            $existingClient['fone_celular'] !== $fone_celular ||
            $existingClient['ativo'] !== $ativo ||
            $existingClient['funcionario'] !== $funcionario
            
            
        ) {
            // Houve alterações, atualize o cliente
            $query = $pdo->prepare("UPDATE $tabela SET id_funcao = :id_funcao, fone_celular = :fone_celular, ativo = :ativo, funcionario = :funcionario WHERE id_funcionario = :id_funcionario");
            $query->bindParam(":id_funcionario", $id_funcionario, PDO::PARAM_INT);
            $query->bindParam(":id_funcao", $id_funcao, PDO::PARAM_INT);
            $query->bindParam(":fone_celular", $fone_celular, PDO::PARAM_STR);
            $query->bindParam(":ativo", $ativo, PDO::PARAM_STR);
            $query->bindParam(":funcionario", $funcionario, PDO::PARAM_STR);
            
            $query->execute();

            //echo "Cliente $nomeixc atualizado com sucesso<br>";
        }

/*if ($api_whatsapp == 'Sim' and $id == "") {
    $telefone_envio = '55'.preg_replace('/[ ()-]+/','' , $telefone);
    require("../../api/texto.php");
}*/
    
} else {
    //var_dump($nomeixc);
    // O cliente não existe, insira-o no banco de dados
    $query = $pdo->prepare("INSERT INTO $tabela (id_funcao, fone_celular, data_admissao, ativo, id_funcionario, funcionario) VALUES (:id_funcao, :fone_celular, :data_admissao, :ativo, :id_funcionario, :funcionario)");

    $query->bindParam(":id_funcao", $id_funcao, PDO::PARAM_INT); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
    $query->bindParam(":fone_celular", $fone_celular, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
    $query->bindParam(":data_admissao", $data_admissao, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
    $query->bindParam(":ativo", $ativo, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
    $query->bindParam(":id_funcionario", $id_funcionario, PDO::PARAM_INT); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
    $query->bindParam(":funcionario", $funcionario, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
    
    $query->execute();

    //echo "Cliente $idixc inserido com sucesso<br>";
    }
}

}
if (empty($clientes)) {
    
    }
    //echo "Nenhum cliente novo";
}
//echo "Nenhum cliente novo";

?>