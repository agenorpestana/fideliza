<?php 
//$tabela = 'contatos';
require_once("../../../conexao.php");

// Dados de autenticação
require('WebserviceClient.php');


$host = 'https://ixc.itlfibra.com/webservice/v1';
$token = '75:b938ef38b4a4154c32248aaf79025b169bff1f2380a0163fb6109922c60d3ea9'; // Token gerado no cadastro do usuário (verificar permissões)
$selfSigned = true; // True para certificado auto assinado

// Crie uma instância da classe WebserviceClient
$api2 = new IXCsoft\WebserviceClient($host, $token, $selfSigned);

// Define a quantidade de registros por página
$registrosPorPaginaC = 10000;
$valorA = '1';
$valoresConsultaC = [$valorA];
$params = array(
    'qtype' => 'cliente.ativo', // Campo de filtro
    'query' => 'S', // Valor para consultar
    'oper' => '=', // Operador da consulta
    'page' => '1', // Página a ser mostrada
    'rp' => $registrosPorPaginaC, // Quantidade de registros por página
    'sortname' => 'cliente.ativo', // Campo para ordenar a consulta
    'sortorder' => 'desc' // Ordenação (asc= crescente | desc=decrescente)
);

// Faz a solicitação à API
$api2->get('cliente', $params);

// Obtém a resposta da API em formato JSON
$respostaJson = $api2->getRespostaConteudo(false);

// Decodifica a resposta JSON
$data = json_decode($respostaJson, true);

// Verifica se a resposta foi bem-sucedida
if ($data && isset($data['registros'])) {
    $clientes = $data['registros'];

    // Início da tabela HTML
echo <<<HTML
<small>
    <table class="table table-hover" id="tabela">
    <thead> 
    <tr>
    <th>ID Técnico</th>   
    <th class="esc">Data de Cadastro</th>
    <th class="esc">Telefone</th>
    <th class="esc">CPf / CNPJ</th>
    <th>Ação</th>
    </tr> 
    </thead> 
    <tbody> 
HTML;

    foreach ($clientes as $cliente) {
        $dataFormatada = date('d/m/Y', strtotime($cliente['data_cadastro']));
        $dataCadastro = $cliente['data_cadastro'];

        if ($dataCadastro > "2023-09-20") {
echo <<<HTML
<tr>
<td>
{$cliente['razao']}
</td>
<td class="esc">{$dataFormatada}</td>
<td class="esc">{$cliente['telefone_celular']}</td>
<td class="esc">{$cliente['cnpj_cpf']}</td>
<td>
    <big><a href="#" onclick="editar('{$cliente['id']}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

    <li class="dropdown head-dpdn2" style="display: inline-block;">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

        <ul class="dropdown-menu" style="margin-left:-230px;">
        <li>
        <div class="notification_desc2">
        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$cliente['id']}')"><span class="text-danger">Sim</span></a></p>
        </div>
        </li>                                       
        </ul>
</li>
<big><a href="#" onclick="mostrar('{$dataFormatada}','{$cliente['razao']}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>

</td>
</tr>
HTML;
        }
    }


} else {
    echo 'Nenhum Registro encontrado.';
}
// Fim da tabela HTML
echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;

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
