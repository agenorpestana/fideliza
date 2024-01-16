<?php 
$tabela = 'indicacoes';
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from $tabela order by data_cadastro desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
    <table class="table table-hover" id="tabela">
    <thead> 
    <tr> 
    <th>Nome do Indicador</th>
    <th class="esc">Nome do Indicado</th>   
    <th class="esc">Telefone do Indicado</th>
    <th class="esc">Cidade do Indicado</th>
    <th class="esc">Status</th>
    <th>Ações</th>
    </tr> 
    </thead> 
    <tbody> 
HTML;


for($i=0; $i<$linhas; $i++){
    $id = $res[$i]['id'];
    $nome_cli = $res[$i]['nome_cli'];
    $telefone_cli = $res[$i]['telefone_cli'];
    $nome_ind = $res[$i]['nome_ind'];
    $telefone_ind = $res[$i]['telefone_ind'];
    $cidade_ind = $res[$i]['cidade_ind'];
    $data_cadastro = $res[$i]['data_cadastro'];
    $status = $res[$i]['status'];
    $obs = $res[$i]['obs'];
    
    if($status == 'Cancelado'){
        $excluir = '';
        $icone = 'fa-square';       
        $classe_square = 'text-danger';
        $classe_nome = 'azul';
        $ocultar_aulas = '';
        $ocultar_pagar = '';
        $classe_progress = '';
        $icones_finalizados = 'ocultar';
    }else if($status == 'Aprovado'){
        $excluir = 'ocultar';
        $icone = 'fa-square';       
        $classe_square = 'verde';
        $classe_nome = 'text-muted';
        $ocultar_aulas = '';
        $ocultar_pagar = 'ocultar';
        $classe_progress = '#015e23';
        $icones_finalizados = '';
    }
    else{
        $excluir = 'ocultar';
        $icone = 'fa-square';       
        $classe_square = 'laranja';
        $classe_nome = 'azul';
        $ocultar_aulas = '';
        $ocultar_pagar = 'ocultar';
        $classe_progress = '';
        $icones_finalizados = 'ocultar';
    }


    $data_cadastro_F = implode('/', array_reverse(explode('-', $data_cadastro)));
    $data_formatada_F = date('d/m/Y H:i', strtotime($data_cadastro_F));
    
    if ($status != 'Aguardando') {
  


if ($status == 'Aprovado') {
    


   
echo <<<HTML
<tr>
<td>
<i class="fa fa-square $classe_square"></i>
<!--<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">-->
<a href="#" onclick="abrirAulasFinalizadas('{$id}','{$nome_cli}','{$telefone_cli}','{$status}','{$usuario}')" class="{$nome_ind} $ocultar_aulas">  
        {$nome_cli}
        <small><i class="fa fa-commenting text-dark" class="text-danger"></i> </small>
        </a>

</td>
<td class="esc">{$nome_ind}</td>
<td class="esc">{$telefone_ind}</td>
<td class="esc">{$cidade_ind}</td>
<td class="esc">{$status}</td>
<td>
    <!--<big><a href="#" onclick="editar('{$id}','{$nome_ind}','{$status}','{$obs}')" title="Aprovar Indicação"><i class="fa fa-check-square verde"></i></a></big>

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

<big><a href="#" onclick="mostrar('{$id}','{$nome_ind}','{$telefone_ind}','{$cidade_ind}','{$nome_cli}','{$telefone_cli}','{$data_formatada_F}','{$status}','{$obs}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>


</td>
</tr>
HTML;

}elseif ($status == 'Cancelado') {
echo <<<HTML
<tr>
<td>
<i class="fa fa-square $classe_square"></i>
<!--<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">-->
<a href="#" onclick="abrirAulas('{$id}','{$nome_cli}','{$telefone_cli}','{$status}','{$usuario}')" class="{$nome_ind} $ocultar_aulas">  
        {$nome_cli}
        <small><i class="fa fa-commenting text-dark" class="text-danger"></i> </small>
        </a>

</td>
<td class="esc">{$nome_ind}</td>
<td class="esc">{$telefone_ind}</td>
<td class="esc">{$cidade_ind}</td>
<td class="esc">{$status}</td>
<td>
    <!--<big><a href="#" onclick="editar('{$id}','{$nome_ind}','{$status}','{$obs}')" title="Aprovar Indicação"><i class="fa fa-check-square verde"></i></a></big>

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

<big><a href="#" onclick="mostrar('{$id}','{$nome_ind}','{$telefone_ind}','{$cidade_ind}','{$nome_cli}','{$telefone_cli}','{$data_formatada_F}','{$status}','{$obs}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>


</td>
</tr>
HTML;
}

 }
}
echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;
}else{
    echo '<small>Nenhum Registro Encontrado!</small>';
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
    function editar(id, nome_cli, status, obs){
        $('#mensagem').text('');
        $('#titulo_inserir').text('Editar Registro');

        $('#id').val(id);
        $('#nome_indicado').text(nome_ind);
        $('#status').val(status);
        $('#obs').val(obs);

        $('#modalForm').modal('show');
    }


    function mostrar(id, nome_ind, telefone_ind, cidade_ind, nome_cli, telefone_cli, data_cadastro, status, obs){

        $('#titulo_dados').text(id);
        $('#nome_ind').text(nome_ind);
        $('#telefone_ind').text(telefone_ind);
        $('#cidade_ind').text(cidade_ind);
        $('#nome_cli').text(nome_cli);
        $('#telefone_cli').text(telefone_cli);
        $('#data_cadastro').text(data_cadastro);
        $('#status').text(status);
        $('#obs_indicacao').text(obs);
        $('#modalDados').modal('show');
    }

    function limparCampos(){
        $('#id').val('');
        $('#nome_ind').val('');
        $('#telefone_ind').val('');
        $('#cidade_ind').val('');
        $('#nome_cli').val('');
        $('#telefone_cli').val('');
        $('#status').val('');
        $('#obs').val('');

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

    function aprovar(id, nome_ind, status){

        $('#id_ind').val(id);
        $('#nome_indicado').text(nome_ind);
        $('#obs_ind').val(obs_ind);


                    
        $('#tituloModal').text('Editar Registro');
        $('#modalAprovar').modal('show');
        $('#mensagem').text('');
    }


    
</script>

