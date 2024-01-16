<?php 

$tabela = 'os';
require_once("../../conexao.php");

//echo "<meta HTTP-EQUIV='refresh' CONTENT='300;URL=script-salvaros.php'>"; 

// Dados de autenticação


//echo ('chegou');

$host = 'https://ixc.itlfibra.com/webservice/v1';
$token = '75:b938ef38b4a4154c32248aaf79025b169bff1f2380a0163fb6109922c60d3ea9'; // Token gerado no cadastro do usuário (verificar permissões)
$selfSigned = true; // True para certificado auto assinado

// Crie uma instância da classe WebserviceClient
$api = new IXCsoft\WebserviceClient($host, $token, $selfSigned);

// Define o número da página atual
//$paginaAtual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
// Define a quantidade de registros por página

$registrosPorPagina = 20000;

$valorA = 'EN';
$valorB = 'A';
$valorC = 'F';
$valoresConsulta = ['EN'];
$params = array(
    'qtype' => 'su_oss_chamado.status', // Campo de filtro
    'query' => 'A', // Valor para consultar
    'oper' => '=', // Operador da consulta
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
		if ($chamado['data_abertura'] >= "2023-01-01"){ 

			
			$formulario_respondido_os = 0;
			$id_os = $chamado['id'];
			$id_tecnico = $chamado['id_tecnico'];
			$funcionario = isset($funcionarioAssociativos[$chamado['id_tecnico']]) ? $funcionarioAssociativos[$chamado['id_tecnico']] : 'OS não Associada a um Técnico';
			$data_abertura = $chamado['data_abertura'];
			$data_fechamento = $chamado['data_fechamento'];
			$id_assunto = $chamado['id_assunto'];
			$id_cidade = $chamado['id_cidade'];
			$id_cliente = $chamado['id_cliente'];

			$assunto = isset($assuntoAssociativos[$id_assunto]) ? $assuntoAssociativos[$id_assunto] : 'Sem assunto';
			$cidade = isset($cidadeAssociativos[$id_cidade]) ? $cidadeAssociativos[$id_cidade] : 'Cidade não encontrada';
			$cliente = isset($clientesAssociativos[$id_cliente]) ? $clientesAssociativos[$id_cliente] : 'Cliente não encontrado';
			$whatsapp_cli = isset($clientesAssociativosWhatsapp[$id_cliente]) ? $clientesAssociativosWhatsapp[$id_cliente] : 'whatsapp não cad.';
			$status = $chamado['status'];

			//$data_fehcamento_F = implode('/', array_reverse(explode('-', $data_fechamento)));
    		$data_fehcamento_Final = date('d/m/Y H:i', strtotime($data_fechamento));

        // Verifique se já existe uma entrada com a mesma id_os no banco de dados
			$query = $pdo->prepare("SELECT * FROM $tabela WHERE id_os = :id_os");
			$query->bindParam(":id_os", $id_os, PDO::PARAM_INT);
			$query->execute();
			$existingOS = $query->fetch(PDO::FETCH_ASSOC);

        //var_dump($id_os);

			if ($existingOS) {
            // Verifique se houve alterações nos campos
				if (
					$existingOS['id_tecnico'] !== $id_tecnico ||
					$existingOS['funcionario'] !== $funcionario ||
					$existingOS['data_abertura'] !== $data_abertura ||
					$existingOS['data_fechamento'] !== $data_fechamento ||
					$existingOS['id_assunto'] !== $id_assunto ||
					$existingOS['id_cidade'] !== $id_cidade ||
					$existingOS['assunto'] !== $assunto ||
					$existingOS['cidade'] !== $cidade ||
					$existingOS['nome_cliente'] !== $cliente ||
					$existingOS['whatsapp_cli'] !== $whatsapp_cli ||
					$existingOS['status'] !== $status



				) {
                // Houve alterações, atualize a entrada existente
					$query = $pdo->prepare("UPDATE $tabela SET id_tecnico = :id_tecnico, funcionario = :funcionario, data_abertura = :data_abertura, data_fechamento = :data_fechamento, id_assunto = :id_assunto, id_cidade = :id_cidade, assunto = :assunto, cidade = :cidade, nome_cliente = :nome_cliente, whatsapp_cli = :whatsapp_cli, status = :status WHERE id_os = :id_os");
					$query->bindParam(":id_os", $id_os, PDO::PARAM_INT);
					$query->bindParam(":id_tecnico", $id_tecnico, PDO::PARAM_INT);
					$query->bindParam(":funcionario", $funcionario, PDO::PARAM_STR);
					$query->bindParam(":data_abertura", $data_abertura, PDO::PARAM_STR);
					$query->bindParam(":data_fechamento", $data_fechamento, PDO::PARAM_STR);
					$query->bindParam(":id_assunto", $id_assunto, PDO::PARAM_INT);
					$query->bindParam(":id_cidade", $id_cidade, PDO::PARAM_INT);
					$query->bindParam(":assunto", $assunto, PDO::PARAM_STR);
					$query->bindParam(":cidade", $cidade, PDO::PARAM_STR);
					$query->bindParam(":nome_cliente", $cliente, PDO::PARAM_STR);
					$query->bindParam(":whatsapp_cli", $whatsapp_cli, PDO::PARAM_STR);
					$query->bindParam(":status", $status, PDO::PARAM_STR);
					
					$query->execute();

	
				}
			} else {
				$token_os = bin2hex(random_bytes(16));
            // A entrada não existe, insira uma nova entrada no banco de dados
				$query = $pdo->prepare("INSERT INTO $tabela (id_os, id_tecnico, funcionario, data_abertura, data_fechamento, id_assunto, id_cidade, assunto, cidade, id_cliente, nome_cliente, whatsapp_cli, status, token_os, formulario_respondido_os) VALUES (:id_os, :id_tecnico,:funcionario, :data_abertura, :data_fechamento, :id_assunto, :id_cidade, :assunto, :cidade, :id_cliente, :nome_cliente, :whatsapp_cli, :status, :token_os, :formulario_respondido_os)");
				$query->bindParam(":id_os", $id_os, PDO::PARAM_INT);
				$query->bindParam(":id_tecnico", $id_tecnico, PDO::PARAM_INT);
				$query->bindParam(":funcionario", $funcionario, PDO::PARAM_STR);
				$query->bindParam(":data_abertura", $data_abertura, PDO::PARAM_STR);
				$query->bindParam(":data_fechamento", $data_fechamento, PDO::PARAM_STR);
				$query->bindParam(":id_assunto", $id_assunto, PDO::PARAM_INT);
				$query->bindParam(":id_cidade", $id_cidade, PDO::PARAM_INT);
				$query->bindParam(":assunto", $assunto, PDO::PARAM_STR);
				$query->bindParam(":cidade", $cidade, PDO::PARAM_STR);
				$query->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
				$query->bindParam(":nome_cliente", $cliente, PDO::PARAM_STR);
				$query->bindParam(":whatsapp_cli", $whatsapp_cli, PDO::PARAM_STR);
				$query->bindParam(":status", $status, PDO::PARAM_STR);
				$query->bindParam(":token_os", $token_os, PDO::PARAM_STR);
				$query->bindParam(":formulario_respondido_os", $formulario_respondido_os, PDO::PARAM_INT);
				$query->execute();


			}
		}

	}
	

} else {
	echo 'Nenhum Novo Registro encontrado.';
}

$query4 = $pdo->query("
        UPDATE $tabela AS os
        SET os.pontos = (
            SELECT ap.pontos
            FROM assunto_pontua AS ap
            WHERE os.id_assunto = ap.id_assunto
        )
       
    ");


require('script-salvaros-f.php');

?>
