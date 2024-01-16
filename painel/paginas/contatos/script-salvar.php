<!DOCTYPE html>
<html>
<head>
    <title>Script Salvar Contatos</title>
</head>
<body>

</body>
</html>

<?php 
$tabela = 'ixclientes';
require_once("../../../conexao.php");

echo "<meta HTTP-EQUIV='refresh' CONTENT='3600;URL=script-salvar.php'>"; 
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
    'qtype' => 'cliente.ativo', // Campo de filtro para o ID do cliente
    'query' => 'S', // Consulta para encontrar IDs maiores ou iguais ao valor definido
    'oper' => '=', // Operador da consulta
    'page' => '1', // Página a ser mostrada
    'rp' => '10000', // Quantidade de registros por página (ajuste conforme necessário)
    'sortname' => 'cliente.ativo', // Campo para ordenar a consulta
    'sortorder' => 'desc' // Ordenação (asc= crescente)
);



// Faz a solicitação à API
$api->get('cliente', $params);

// Obtém a resposta da API em formato JSON
$respostaJson = $api->getRespostaConteudo(false);

// Decodifica a resposta JSON
$data = json_decode($respostaJson, true);

// Verifica se a resposta foi bem-sucedida
if ($data && isset($data['registros'])) {
    $clientes = $data['registros'];
  



foreach ($clientes as $cliente) {
	$dataCadastro = $cliente['data_cadastro'];
    //if ($dataCadastro > "2023-09-20"){

    $idixc = $cliente['id'];
    $nomeixc = $cliente['razao'];
    $telefoneixc = $cliente['telefone_celular'];
    $emailixc = $cliente['email'];
    $datacadastroixc = $cliente['data_cadastro'];
    $cpfcnpj = $cliente['cnpj_cpf'];
    $ativoixc = $cliente['ativo'];
    $enderecoixc = $cliente['endereco'];
    $datanascixc = $cliente['data_nascimento'];


    // Verifica se o cliente já existe no banco de dados
    $query = $pdo->prepare("SELECT * FROM $tabela WHERE id_cliente = :id_cliente");
    $query->bindParam(":id_cliente", $idixc, PDO::PARAM_INT);
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
            $existingClient['nome'] !== $nomeixc ||
            $existingClient['telefone'] !== $telefoneixc ||
            $existingClient['email'] !== $emailixc ||
            $existingClient['ativo'] !== $ativoixc ||
            $existingClient['endereco'] !== $enderecoixc ||
            $existingClient['data_nasc'] !== $datanascixc
            
        ) {
            // Houve alterações, atualize o cliente
            $query = $pdo->prepare("UPDATE $tabela SET nome = :nome, telefone = :telefone, email = :email, ativo = :ativo, endereco = :endereco, data_nasc = :data_nasc WHERE id_cliente = :id_cliente");
            $query->bindParam(":id_cliente", $idixc, PDO::PARAM_INT);
            $query->bindParam(":nome", $nomeixc, PDO::PARAM_STR);
            $query->bindParam(":telefone", $telefoneixc, PDO::PARAM_STR);
            $query->bindParam(":email", $emailixc, PDO::PARAM_STR);
            $query->bindParam(":ativo", $ativoixc, PDO::PARAM_STR);
            $query->bindParam(":endereco", $enderecoixc, PDO::PARAM_STR);
            $query->bindParam(":data_nasc", $datanascixc, PDO::PARAM_STR);
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
	$query = $pdo->prepare("INSERT INTO $tabela (id_cliente, nome, cpfcnpj, telefone, email, data_cadastro, ativo, endereco, data_nasc) VALUES (:id_cliente, :nome, :cpfcnpj, :telefone, :email, :data_cadastro, :ativo, :endereco, :data_nasc)");

	$query->bindParam(":id_cliente", $idixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
	$query->bindParam(":nome", $nomeixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
    $query->bindParam(":cpfcnpj", $cpfcnpj, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
	$query->bindParam(":telefone", $telefoneixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
	$query->bindParam(":email", $emailixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
	$query->bindParam(":data_cadastro", $datacadastroixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
    $query->bindParam(":ativo", $ativoixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
    $query->bindParam(":endereco", $enderecoixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados
    $query->bindParam(":data_nasc", $datanascixc, PDO::PARAM_STR); // Use PDO::PARAM_STR ou PDO::PARAM_INT, dependendo do tipo de dados

	$query->execute();

    //echo "Cliente $idixc inserido com sucesso<br>";
    }


}
if (empty($clientes)) {
    
	}
	//echo "Nenhum cliente novo";
}
//echo "Nenhum cliente novo";

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

<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $nome_sistema ?></title>
    <link rel="stylesheet" type="text/css" href="../../../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="../../../img/icone.png">

</head>
<body>
    <div class="login">     
        <div class="form">
            <img src="../../../img/logo.png" class="imagem">
            <form method="post" action="autenticar.php">
                <?php 
                    echo 'Atualizado com sucesso.';
                ?>  
            </form> 
        </div>
    </div>
</body>
</html>