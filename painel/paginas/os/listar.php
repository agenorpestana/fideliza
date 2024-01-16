<?php 
$tabela = 'os';
require_once("../../../conexao.php");
$data_atual = date('Y-m-d');

$dataInicial = @$_POST['dataInicial'];
$dataFinal = @$_POST['dataFinal'];
$selecao = @$_POST['selecao'];
$selecaoData = @$_POST['selecaoData'];


if ($selecao === '') {
    

    
$query = $pdo->query("SELECT * from $tabela WHERE $selecaoData >= '$dataInicial' and data_fechamento <= '$dataFinal 23:59:59' order by data_abertura desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
    <table class="table table-hover" id="tabela">
    <thead> 
    <tr> 
    <th>Nome do Técnico</th>   
    <th class="esc">Data de Abertura</th>
    <th class="esc">Data de Fechamento</th>
    <th class="esc">Assunto</th>
    <th class="esc">Cidade</th>
    <th class="esc">Nome Cliente</th>  
    <th>Ações</th>
    </tr> 
    </thead> 
    <tbody> 
HTML;


for($i=0; $i<$linhas; $i++){
    $id = $res[$i]['id'];
    $id_os = $res[$i]['id_os'];
    $id_tecnico = $res[$i]['id_tecnico'];
    $funcionario = $res[$i]['funcionario'];
    $data_abertura = $res[$i]['data_abertura'];
    $data_fechamento = $res[$i]['data_fechamento'];
    $assunto = $res[$i]['assunto'];
    $id_assunto = $res[$i]['id_assunto'];
    $cidade = $res[$i]['cidade'];
    $id_cidade = $res[$i]['id_cidade'];
    $id_cliente = $res[$i]['id_cliente'];
    $nome_cliente = $res[$i]['nome_cliente'];
    $whatsapp_cli = $res[$i]['whatsapp_cli'];
    $status = $res[$i]['status'];

    $data_abertura_F = implode('/', array_reverse(explode('-', $data_abertura)));
    $data_fechamento_F = implode('/', array_reverse(explode('-', $data_fechamento)));
    $data_formatada_F = date('d/m/Y H:i', strtotime($data_fechamento_F));
    $data_formatada_A = date('d/m/Y H:i', strtotime($data_abertura_F));
    
    $data_fechamento_F = $res[$i]['data_fechamento'];
        if (empty($data_fechamento_F) || $data_fechamento_F == "0000-00-00 00:00:00") {
            $data_fechamento_F = 'Aberto';
        } else {
            $data_fechamento_F = date('d/m/Y H:i', strtotime($data_fechamento_F));
        }

    $data_abertura_F = $res[$i]['data_abertura'];
        if (!empty($data_abertura_F)) {
     
            $data_abertura_F = date('d/m/Y H:i', strtotime($data_abertura_F));
        }
    /*if($ativo == 'Sim'){
    $icone = 'fa-check-square';
    $titulo_link = 'Desativar Usuário';
    $acao = 'Não';
    $classe_ativo = '';
    }else{
        $icone = 'fa-square-o';
        $titulo_link = 'Ativar Usuário';
        $acao = 'Sim';
        $classe_ativo = '#c4c4c4';
    }

    $mostrar_adm = '';
    if($nivel == 'Administrador'){
        $senha = '******';
        $mostrar_adm = 'ocultar';
    }*/

    

echo <<<HTML
<tr>
<td>
<!--<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">-->
{$funcionario}
</td>
<td class="esc">{$data_abertura_F}</td>
<td class="esc">{$data_fechamento_F}</td>
<td class="esc">{$assunto}</td>
<td class="esc">{$cidade}</td>
<td class="esc">{$nome_cliente}</td>
<td>
    <!--<big><a href="#" onclick="editar('{$id}','{$funcionario}','{$nome_cliente}','{$assunto}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

    <li class="dropdown head-dpdn2" style="display: inline-block;">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

        <ul class="dropdown-menu" style="margin-left:-230px;">
        <li>
        <div class="notification_desc2">
        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
        </div>
        </li>                                       
        </ul>
</li>-->

<big><a href="#" onclick="mostrar('{$id_os}','{$funcionario}','{$data_abertura_F}','{$data_fechamento_F}','{$assunto}','{$cidade}','{$nome_cliente}','{$whatsapp_cli}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary" ></i></a></big>


</td>
</tr>
HTML;

        
    }

}else{
    echo '<small>Nenhum Registro Encontrado!</small>';
}


echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;
}else{
    $query = $pdo->query("SELECT * from $tabela WHERE $selecaoData >= '$dataInicial' and data_fechamento <= '$dataFinal 23:59:59' and status = '$selecao' order by data_abertura desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
    <table class="table table-hover" id="tabela">
    <thead> 
    <tr> 
    <th>Nome do Técnico</th>   
    <th class="esc">Data de Abertura</th>
    <th class="esc">Data de Fechamento</th>
    <th class="esc">Assunto</th>
    <th class="esc">Cidade</th>
    <th class="esc">Nome Cliente</th>  
    <th>Ações</th>
    </tr> 
    </thead> 
    <tbody> 
HTML;


for($i=0; $i<$linhas; $i++){
    $id = $res[$i]['id'];
    $id_os = $res[$i]['id_os'];
    $id_tecnico = $res[$i]['id_tecnico'];
    $funcionario = $res[$i]['funcionario'];
    $data_abertura = $res[$i]['data_abertura'];
    $data_fechamento = $res[$i]['data_fechamento'];
    $assunto = $res[$i]['assunto'];
    $id_assunto = $res[$i]['id_assunto'];
    $cidade = $res[$i]['cidade'];
    $id_cidade = $res[$i]['id_cidade'];
    $id_cliente = $res[$i]['id_cliente'];
    $nome_cliente = $res[$i]['nome_cliente'];
    $whatsapp_cli = $res[$i]['whatsapp_cli'];
    $status = $res[$i]['status'];

    $data_abertura_F = implode('/', array_reverse(explode('-', $data_abertura)));
    $data_fechamento_F = implode('/', array_reverse(explode('-', $data_fechamento)));
    $data_formatada_F = date('d/m/Y H:i', strtotime($data_fechamento_F));
    $data_formatada_A = date('d/m/Y H:i', strtotime($data_abertura_F));
    
    $data_fechamento_F = $res[$i]['data_fechamento'];
        if (empty($data_fechamento_F) || $data_fechamento_F == "0000-00-00 00:00:00") {
            $data_fechamento_F = 'Aberto';
        } else {
            $data_fechamento_F = date('d/m/Y H:i', strtotime($data_fechamento_F));
        }

    $data_abertura_F = $res[$i]['data_abertura'];
        if (!empty($data_abertura_F)) {
     
            $data_abertura_F = date('d/m/Y H:i', strtotime($data_abertura_F));
        }
    /*if($ativo == 'Sim'){
    $icone = 'fa-check-square';
    $titulo_link = 'Desativar Usuário';
    $acao = 'Não';
    $classe_ativo = '';
    }else{
        $icone = 'fa-square-o';
        $titulo_link = 'Ativar Usuário';
        $acao = 'Sim';
        $classe_ativo = '#c4c4c4';
    }

    $mostrar_adm = '';
    if($nivel == 'Administrador'){
        $senha = '******';
        $mostrar_adm = 'ocultar';
    }*/

    

echo <<<HTML
<tr>
<td>
<!--<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">-->
{$funcionario}
</td>
<td class="esc">{$data_abertura_F}</td>
<td class="esc">{$data_fechamento_F}</td>
<td class="esc">{$assunto}</td>
<td class="esc">{$cidade}</td>
<td class="esc">{$nome_cliente}</td>
<td>
    <!--<big><a href="#" onclick="editar('{$id}','{$funcionario}','{$nome_cliente}','{$assunto}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

    <li class="dropdown head-dpdn2" style="display: inline-block;">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

        <ul class="dropdown-menu" style="margin-left:-230px;">
        <li>
        <div class="notification_desc2">
        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
        </div>
        </li>                                       
        </ul>
</li>-->

<big><a href="#" onclick="mostrar('{$id_os}','{$funcionario}','{$data_abertura_F}','{$data_fechamento_F}','{$assunto}','{$cidade}','{$nome_cliente}','{$whatsapp_cli}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary" ></i></a></big>


</td>
</tr>
HTML;

        
    }

}else{
    echo '<small>Nenhum Registro Encontrado!</small>';
}


echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;
}

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
    function editar(id, funcionario, nome_cliente, assunto){
        $('#mensagem').text('');
        $('#titulo_inserir').text('Editar Registro');

        $('#id').val(id);
        $('#nome').val(funcionario);
        $('#nome_cliente').val(nome_cliente);
        $('#assunto').val(assunto);
        $('#modalForm').modal('show');
    }


    function mostrar(id_os, funcionario, data_abertura_F, data_fechamento_F, assunto, cidade , nome_cliente, whatsapp_cli){

        $('#titulo_dados').text(id_os);
        $('#funcionario').text(funcionario);
        $('#data_abertura').text(data_abertura_F);
        $('#data_fechamento').text(data_fechamento_F);
        $('#assunto').text(assunto);
        $('#cidade').text(cidade);
        $('#nome_cliente').text(nome_cliente);  
        $('#whatsapp_cli').text(whatsapp_cli); 
        $('#modalDados').modal('show');
    }

    function limparCampos(){
        $('#id').val('');
        $('#nome').val('');
        $('#email').val('');
        $('#telefone').val('');
        $('#endereco').val('');

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


    function permissoes(id, nome){
                
        $('#id_permissoes').val(id);
        $('#nome_permissoes').text(nome);       

        $('#modalPermissoes').modal('show');
        listarPermissoes(id);
    }

    


    
</script>

