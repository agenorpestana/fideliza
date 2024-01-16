<?php 
$tabela = 'funiconarios';
require("salvar-funcionarios.php");
require_once("../../../conexao.php");

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
    'qtype' => 'usuarios.id', // Campo de filtro
    'query' => '0', // Valor para consultar
    'oper' => '>=', // Operador da consulta
    'page' => '1', // Página a ser mostrada
    'rp' => $registrosPorPaginaU, // Quantidade de registros por página
    'sortname' => 'usuarios.id', // Campo para ordenar a consulta
    'sortorder' => 'desc' // Ordenação (asc= crescente | desc=decrescente)
);

// Faz a solicitação à API
$api3->get('usuarios', $params);

// Obtém a resposta da API em formato JSON
$respostaJsonU = $api3->getRespostaConteudo(false);
//var_dump($respostaJsonU);
// Decodifica a resposta JSON
$data = json_decode($respostaJsonU, true);

// Verifica se a resposta foi bem-sucedida
if ($data && isset($data['registros'])) {
    $usuariosixc = $data['registros'];

    // Início da tabela HTML
echo <<<HTML
<small>
    <table class="table table-hover" id="tabela">
    <thead> 
    <tr>
    <th>Nome do Técnico</th>   
    <th class="esc">Id do grupo</th>
    <th class="esc">Email</th>
    <th class="esc">Status</th>
    <th>Ação</th>
    </tr> 
    </thead> 
    <tbody> 
HTML;

    foreach ($usuariosixc as $usuario) {
    
echo <<<HTML
<tr>
<td>
{$usuario['nome']}
</td>
<td class="esc">{$usuario['id_grupo']}</td>
<td class="esc">{$usuario['email']}</td>
<td class="esc">{$usuario['status']}</td>
<td>
    <big><a href="#" onclick="editar('{$usuario['id']}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

    <li class="dropdown head-dpdn2" style="display: inline-block;">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

        <ul class="dropdown-menu" style="margin-left:-230px;">
        <li>
        <div class="notification_desc2">
        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$usuario['id']}')"><span class="text-danger">Sim</span></a></p>
        </div>
        </li>                                       
        </ul>
</li>
<big><a href="#" onclick="mostrar('{$usuario['nome']}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>

</td>
</tr>
HTML;
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
