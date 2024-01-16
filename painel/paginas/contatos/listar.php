<?php 
$tabela = 'ixclientes';
require_once("../../../conexao.php");

$dataInicial = @$_POST['dataInicial'];
$dataFinal = @$_POST['dataFinal'];
$nomePesquisa = @$_POST['nomePesquisa'];

if ($nomePesquisa == "") {

$query = $pdo->query("SELECT * from $tabela where data_cadastro >= '$dataInicial' and data_cadastro <= '$dataFinal' order by data_cadastro desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){

    // Início da tabela HTML
echo <<<HTML
<small>
    <table class="table table-hover" id="tabela">
    <thead> 
    <tr>
    <th>Cliente</th>   
    <th class="esc">Telefone</th>
    <th class="esc">Cpf</th>
    <th class="esc">Data de Cadastro</th>
    <th>Ação</th>
    </tr> 
    </thead> 
    <tbody> 
HTML;

    for($i=0; $i<$linhas; $i++){
    $id = $res[$i]['id'];
    $id_cliente = $res[$i]['id_cliente'];
    $nome = $res[$i]['nome'];
    $cpfcnpj = $res[$i]['cpfcnpj'];
    $telefone = $res[$i]['telefone'];
    $email = $res[$i]['email'];
    $data_cadastro = $res[$i]['data_cadastro'];
    $ativo = $res[$i]['ativo'];
    $endereco = $res[$i]['endereco'];
    $data_nasc = $res[$i]['data_nasc'];
    
    $data_cadastro_Form = date('d/m/Y', strtotime($data_cadastro));
    $data_nasc_Form = date('d/m/Y', strtotime($data_nasc));
    

echo <<<HTML
<tr>
<td>
{$nome}
</td>
<td class="esc">{$telefone}</td>
<td class="esc">{$cpfcnpj}</td>
<td class="esc">{$data_cadastro_Form}</td>
<td>

<big><a href="#" onclick="mostrar('{$id}','{$nome}','{$id_cliente}','{$telefone}','{$data_cadastro_Form}','{$ativo}','{$endereco}','{$cpfcnpj}','{$data_nasc_Form}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>

</td>
</tr>
HTML;
        
    }
    } else {
    echo 'Nenhum Registro encontrado.';
}
}else {
 

$query = $pdo->query("SELECT * from $tabela where nome LIKE '%$nomePesquisa%' order by data_cadastro desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){

    // Início da tabela HTML
echo <<<HTML
<small>
    <table class="table table-hover" id="tabela">
    <thead> 
    <tr>
    <th>Cliente</th>   
    <th class="esc">Telefone</th>
    <th class="esc">Cpf</th>
    <th class="esc">Data de Cadastro</th>
    <th>Ação</th>
    </tr> 
    </thead> 
    <tbody> 
HTML;

    for($i=0; $i<$linhas; $i++){
    $id = $res[$i]['id'];
    $id_cliente = $res[$i]['id_cliente'];
    $nome = $res[$i]['nome'];
    $cpfcnpj = $res[$i]['cpfcnpj'];
    $telefone = $res[$i]['telefone'];
    $email = $res[$i]['email'];
    $data_cadastro = $res[$i]['data_cadastro'];
    $ativo = $res[$i]['ativo'];
    $endereco = $res[$i]['endereco'];
    $data_nasc = $res[$i]['data_nasc'];
    
    $data_cadastro_Form = date('d/m/Y', strtotime($data_cadastro));
    $data_nasc_Form = date('d/m/Y', strtotime($data_nasc));
    


    
echo <<<HTML
<tr>
<td>
{$nome}
</td>
<td class="esc">{$telefone}</td>
<td class="esc">{$cpfcnpj}</td>
<td class="esc">{$data_cadastro_Form}</td>
<td>

<big><a href="#" onclick="mostrar('{$id}','{$nome}','{$id_cliente}','{$telefone}','{$data_cadastro_Form}','{$ativo}','{$endereco}','{$cpfcnpj}','{$data_nasc_Form}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>

</td>
</tr>
HTML;
        
    }
    } else {
    echo 'Nenhum Registro encontrado.';
}

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
        "stateSave": true,
        
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

    function mostrar(id, nome, id_cliente, telefone, data_cadastro, ativo, endereco, cpfcnpj, data_nasc){


        $('#titulo_dados').text(nome);
        $('#id_cliente').text(id_cliente);
        $('#telefone').text(telefone);
        $('#data_cadastro').text(data_cadastro);
        $('#ativo').text(ativo);
        $('#endereco').text(endereco);
        $('#cpfcnpj').text(cpfcnpj);
        $('#data_nascimento').text(data_nasc);
        $('#id').text(id);
        
        

        $('#modalDados').modal('show');
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
