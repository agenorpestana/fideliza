<?php 
$tabela = 'funcionarios';
require_once("../../../conexao.php");


//validacao id

// Dados de autenticação para a API
require('WebserviceClient.php');
$host = 'https://ixc.itlfibra.com/webservice/v1';
$token = '75:b938ef38b4a4154c32248aaf79025b169bff1f2380a0163fb6109922c60d3ea9'; // Token gerado no cadastro do usuário (verificar permissões)
$selfSigned = true; // True para certificado auto assinado

// Crie uma instância da classe WebserviceClient
$api = new IXCsoft\WebserviceClient($host, $token, $selfSigned);

// Parâmetros da consulta à API
$params = array(
    'qtype' => 'usuarios.status', // Campo de filtro
    'query' => 'A', // Valor para consultar
    'oper' => '=', // Operador da consulta
    'page' => '1', // Página a ser mostrada
    'rp' => $registrosPorPaginaU, // Quantidade de registros por página
    'sortname' => 'usuarios.id', // Campo para ordenar a consulta
    'sortorder' => 'desc' // Ordenação (asc= crescente | desc=decrescente)
);



// Faz a solicitação à API
$api->get('usuarios', $params);

// Obtém a resposta da API em formato JSON
$respostaJson = $api->getRespostaConteudo(false);

// Decodifica a resposta JSON
$data = json_decode($respostaJson, true);

// Verifica se a resposta foi bem-sucedida
if ($data && isset($data['registros'])) {
    $funcionarios = $data['registros'];
  



foreach ($funcionarios as $funcionario) {

  

    $idfunc = $funcionario['id'];
    $usuariofunc = $funcionario['nome'];
    $emailfunc = $funcionario['email'];
    $statusfunc = $funcionario['status'];
    $funcionariofunc = $funcionario['funcionario'];

    // Verifica se o cliente já existe no banco de dados
    $query = $pdo->prepare("SELECT * FROM $tabela WHERE email = :email");
    $query->bindParam(":email", $emailfunc, PDO::PARAM_INT);
    $query->execute();
    $existingFunc = $query->fetch(PDO::FETCH_ASSOC);
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
            $existingFunc['nome'] !== $nomeixc ||
            $existingFunc['email'] !== $telefoneixc ||
            $existingFunc['status'] !== $emailixc ||
            $existingFunc['funcionario'] !== $datacadastroixc
        ) {
            // Houve alterações, atualize o cliente
            $query = $pdo->prepare("UPDATE $tabela SET nome = :nome, telefone = :telefone, email = :email, data_cadastro = :data_cadastro WHERE id_cliente = :id_cliente");
            $query->bindParam(":id_cliente", $idixc, PDO::PARAM_INT);
            $query->bindParam(":nome", $nomeixc, PDO::PARAM_STR);
            $query->bindParam(":telefone", $telefoneixc, PDO::PARAM_STR);
            $query->bindParam(":email", $emailixc, PDO::PARAM_STR);
            $query->bindParam(":data_cadastro", $datacadastroixc, PDO::PARAM_STR);
            $query->execute();

            echo "Cliente $nomeixc atualizado com sucesso<br>";
        }

/*if ($api_whatsapp == 'Sim' and $id == "") {
	$telefone_envio = '55'.preg_replace('/[ ()-]+/','' , $telefone);
	require("../../api/texto.php");
}*/
	
} else {
	//var_dump($nomeixc);
	// O cliente não existe, insira-o no banco de dados
	$query = $pdo->prepare("INSERT INTO $tabela (id_cliente, nome, telefone, email, data_cadastro) VALUES (:id_cliente, :nome, :telefone, :email, :data_cadastro)");

	$query->bindParam(":id_cliente", $idixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
	$query->bindParam(":nome", $nomeixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
	$query->bindParam(":telefone", $telefoneixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
	$query->bindParam(":email", $emailixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
	$query->bindParam(":data_cadastro", $datacadastroixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados

	$query->execute();

    echo "Cliente $idixc inserido com sucesso<br>";
    }
}

}
if (empty($clientes)) {
    
	
	//echo "Nenhum cliente novo";
}
echo "Nenhum cliente novo";
exit();

?>
  
<script type="text/javascript">
    $(document).ready( function () {        
    $('#tabela').DataTable({
        "language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
        },
        "ordering": false,
        "stateSave": true
    });
} );
</script>

<script type="text/javascript">
    function editar(id, nome){
        $('#mensagem').text('');
        $('#titulo_inserir').text('Editar Registro');

        $('#id').val(id);
        $('#nome').val(nome);
    
        $('#modalForm').modal('show');
    }



    function limparCampos(){
        $('#id').val('');
        $('#nome').val('');
    

        $('#ids').val('');
        $('#btn-deletar').hide();   
    }

    function selecionar(id){

        var ids = $('#ids').val();

        if($('#seletor-'+id).is(":checked") == true){
            var novo_id = ids + id + '-';
            $('#ids').val(novo_id);
        }else{
            var retirar = ids.replace(id + '-', '');
            $('#ids').val(retirar);
        }

        var ids_final = $('#ids').val();
        if(ids_final == ""){
            $('#btn-deletar').hide();
        }else{
            $('#btn-deletar').show();
        }
    }

    function deletarSel(){
        var ids = $('#ids').val();
        var id = ids.split("-");
        
        for(i=0; i<id.length-1; i++){
            excluir(id[i]);         
        }

        limparCampos();
    }
</script>
