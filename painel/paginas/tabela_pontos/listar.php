<?php 
$tabela = 'assunto_pontua';
require_once("../../../conexao.php");
$data_atual = date('Y-m-d');

$dataInicial = @$_POST['dataInicial'];
$dataFinal = @$_POST['dataFinal'];
$nomePesquisa = @$_POST['nomePesquisa'];


$query = $pdo->query("SELECT * from $tabela where nome_assunto LIKE '%$nomePesquisa%' order by id_assunto desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
    <table class="table table-hover" id="tabela">
    <thead> 
    <tr> 
    <th>Nome Assunto</th>   
    <th class="esc">Pontuação</th>
    <th class="esc">Pontuação Negativa</th>
    <th>Ações</th>
    </tr> 
    </thead> 
    <tbody> 
HTML;


for($i=0; $i<$linhas; $i++){
    $id = $res[$i]['id'];
    $id_assunto = $res[$i]['id_assunto'];
    $nome_assunto = $res[$i]['nome_assunto'];
    $pontos = $res[$i]['pontos'];
    $pontos_negativo = $res[$i]['pontos_negativo'];

echo <<<HTML
<tr>
<td>

{$nome_assunto}
</td>
<td class="esc">{$pontos}</td>
<td class="esc">{$pontos_negativo}</td>
<td>
    <big><a href="#" onclick="editar('{$id}','{$pontos}','{$pontos_negativo}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

    <!--<li class="dropdown head-dpdn2" style="display: inline-block;">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

        <ul class="dropdown-menu" style="margin-left:-230px;">
        <li>
        <div class="notification_desc2">
        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
        </div>
        </li>                                       
        </ul>
</li>-->

<big><a href="#" onclick="mostrar('{$id}','{$id_assunto}','{$nome_assunto}','{$pontos}','{$pontos_negativo}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>


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
    function editar(id, pontos, pontos_negativo){
        $('#mensagem').text('');
        $('#titulo_inserir').text('Adicionar Pontuação');

        $('#id').val(id);
        $('#pontos').val(pontos);
        $('#pontos_negativo').val(pontos_negativo);
        $('#modalForm').modal('show');
       
    }


    function mostrar(id_assunto, nome_assunto, pontos, pontos_negativo){

        $('#titulo_dados').text(id_assunto);
        $('#nome_assunto').text(nome_assunto);
        $('#pontos').text(pontos);
        $('#pontos_negativo').text(pontos_negativo);
        
        $('#modalDados').modal('show');
    }

    function limparCampos(){
        $('#id').val('');
        $('#id_assunto').val('');
        $('#nome_assunto').val('');
        $('#pontos').val('');
        $('#pontos_negativo').val('');
        

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

