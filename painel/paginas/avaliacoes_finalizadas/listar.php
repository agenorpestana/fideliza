<?php 
$tabela = 'formulario';
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * FROM $tabela ORDER BY 
    CASE 
        WHEN status = 'Aguardando' THEN 1
        ELSE 2
    END, id");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
   


echo <<<HTML
<small>
    <table class="table table-hover" id="tabela">
    <thead> 
    <tr> 
    <th>Cliente</th>   
    <th class="esc">Atendimento</th>
    <th class="esc">Instalação / Suporte</th>
    <th class="esc">Recomendar Serviço</th>
    <th class="esc">Satisfação</th>
    <th class="esc">Status</th>
    <th>Ações</th>
    </tr> 
    </thead> 
    <tbody> 
HTML;


for($i=0; $i<$linhas; $i++){
   
    $id = $res[$i]['id'];
    $perg1 = $res[$i]['perg1'];
    $perg2 = $res[$i]['perg2'];
    $perg3 = $res[$i]['perg3'];
    $perg4 = $res[$i]['perg4'];
    $id_cliente = $res[$i]['id_cliente'];
    $id_os = $res[$i]['id_os'];
    $nome_cliente = $res[$i]['nome_cliente'];
    $telefone_cliente = $res[$i]['telefone_cliente'];
    $status = $res[$i]['status'];
    $data_resposta = $res[$i]['data_resposta'];


    if($status == 'Aguardando'){
        $excluir = '';
        $icone = 'fa-square';       
        $classe_square = 'text-danger';
        $classe_nome = 'azul';
        $ocultar_aulas = '';
        $ocultar_pagar = '';
        $classe_progress = '';
        $icones_finalizados = 'ocultar';
    }else if($status == 'Finalizado'){
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

    //$data_resposta_F = implode('/', array_reverse(explode('-', $data_resposta)));
    $data_resposta_Form = date('d/m/Y H:i', strtotime($data_resposta));
    //var_dump($nome_cliente);
    if ($status == 'Finalizado') {
        
    
echo <<<HTML
<tr>
<td>
<!--<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">-->
<a href="#" onclick="abrirAulas('{$id}','{$nome_cliente}','{$status}','{$usuario}')" class="{$classe_nome} $ocultar_aulas">  
        {$nome_cliente}
        <small><i class="fa fa-commenting text-dark" class="text-danger"></i> </small>
        </a>
</td>
<td class="esc">{$perg1}</td>
<td class="esc">{$perg2}</td>
<td class="esc">{$perg3}</td>
<td class="esc">{$perg4}</td>
<td class="esc"><i class="fa {$icone} $classe_square"></i></td> 
<td>
    <!-- <big><a href="#" onclick="editar('{$id_os}','{$perg1}','{$perg2}','{$perg3}','{$perg4}','{$id_cliente}', '{$nome_cliente}', '{$telefone_cliente}', '{$data_resposta_Form}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>-->

    <!-- <li class="dropdown head-dpdn2" style="display: inline-block;">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a> -->

        <ul class="dropdown-menu" style="margin-left:-230px;">
        <li>
        <div class="notification_desc2">
        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
        </div>
        </li>                                       
        </ul>
</li>

<big><a href="#" onclick="mostrar('{$id_os}','{$perg1}','{$perg2}','{$perg3}','{$perg4}','{$id_cliente}','{$nome_cliente}','{$telefone_cliente}','{$data_resposta_Form}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>


</td>
</tr>
HTML;
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
    function editar(id_os, perg1, perg2, perg3, perg4, id_cliente, nome_cliente, telefone_cliente, data_resposta){
        $('#mensagem').text('');
        $('#titulo_inserir').text('Editar Registro');

        $('#id_os').val(id_os);
        $('#perg1').val(perg1);
        $('#perg2').val(perg2);
        $('#perg3').val(perg3);
        $('#perg4').val(perg4);
        $('#id_cliente').val(id_cliente);
        $('#nome_cliente').val(nome_cliente);
        $('#telefone_cliente').val(telefone_cliente);
        $('#data_resposta').val(data_resposta);


        $('#modalForm').modal('show');
    }


    function mostrar(id_os, perg1, perg2, perg3, perg4, id_cliente, nome_cliente, telefone_cliente, data_resposta){

        $('#titulo_dados').text(id_os);
        $('#perg1').text(perg1);
        $('#perg2').text(perg2);
        $('#perg3').text(perg3);
        $('#perg4').text(perg4);
        $('#id_cliente').text(id_cliente);
        $('#nome_cliente').text(nome_cliente);
        $('#telefone_cliente').text(telefone_cliente);
        $('#data_resposta').text(data_resposta);
        
        

        $('#modalDados').modal('show');
    }


    /*function abrirAulas(id, nome, status, usuario, id_curso, link){

        if(link == ""){
            document.getElementById('link-drive').style.display = 'none';
        }else{
            document.getElementById('link-drive').style.display = 'block';
        }

        $('#nome_do_cliente').text(nome);
        $('#aulas_aula').text(status);       
        $('#modalAulas').modal('show');
        $('#id_da_matricula').val(id);
        $('#id_do_curso').val(id_curso);
        $('#link_drive_curso').attr('href', link);
        //listarAulas(id_curso, id);
        //listarPerguntas(id);      
        listarPerguntas(id);

        $('#nome_do_cleinte_comentario').text(nome);
        $('#id_curso_pergunta').val(id_curso);
        $('#id_curso_resposta').val(id_curso);

        


    }*/


    function limparCampos(){
        $('#id').val('');
        $('#id_os').val('');
        $('#perg1').val('');
        $('#perg2').val('');
        $('#perg3').val('');
        $('#perg4').val('');
        $('#id_cliente').val('');
        $('#nome_cliente').val('');
        $('#telefone_cliente').val('');
        $('#aulas_aula').val('');
        $('#data_resposta').val('');
       

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

<!-- <script type="text/javascript">
    
$("#form-perguntas").submit(function () {
    var id_curso = $('#id_os_comentario').val();
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/inserir-pergunta.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-pergunta').text('');
            $('#mensagem-pergunta').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") { 
                     $('#pergunta').val('')
                      $('#num_aula').val('')                   
                    $('#btn-fechar-pergunta').click();
                    listarPerguntas(id_os);
                    
                } else {
                    $('#mensagem-pergunta').addClass('text-danger')
                    $('#mensagem-pergunta').text(mensagem)
                }

            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

});
</script>



<script type="text/javascript">  
    function listarPerguntas(id){
    $.ajax({
        url: 'paginas/' + pag + "/listar-perguntas.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){
            $("#listar-perguntas").html(result);

           
        }
    });
}

</script>


<script type="text/javascript">
function excluirPergunta(id){
    var id_curso = $('#id_curso_pergunta').val();
    $.ajax({
        url: 'paginas/' + pag + "/excluir-pergunta.php",
        method: 'POST',
        data: {id},
        dataType: "text",

        success: function (mensagem) {            
            if (mensagem.trim() == "Excluído com Sucesso") {                
                listarPerguntas(id_curso);                
            } else {
                    $('#mensagem-excluir').addClass('text-danger')
                    $('#mensagem-excluir').text(mensagem)
                }

        },      

    });
}

</script>



<script type="text/javascript">
    function modalResposta(id_pergunta, pergunta){
        $('#pergunta_resposta').text(pergunta);
        $('#id_pergunta_resposta').val(id_pergunta);        
        $('#modalResposta').modal('show');
        listarRespostas(id_pergunta);
    }
</script>


<script type="text/javascript">
    
$("#form-respostas").submit(function () {
    var id_pergunta = $('#id_pergunta_resposta').val();
    var id_curso = $('#id_curso_pergunta').val();
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/inserir-resposta.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-resposta').text('');
            $('#mensagem-resposta').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") { 
                     $('#resposta').val('')                                  
                     //$('#btn-fechar-resposta').click();
                     listarRespostas(id_pergunta)
                     listarPerguntas(id_curso)
                    
                } else {
                    $('#mensagem-resposta').addClass('text-danger')
                    $('#mensagem-resposta').text(mensagem)
                }

            },

            cache: false,
            contentType: false,
            processData: false,
            
        });

});
</script>




<script type="text/javascript">  
    function listarRespostas(id){
    $.ajax({
        url: 'paginas/' + pag + "/listar-respostas.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){
            $("#listar-respostas").html(result);
           
        }
    });
}

</script>




<script type="text/javascript">
    

function excluirResposta(id){
    var id_pergunta = $('#id_pergunta_resposta').val();
    $.ajax({
        url: 'paginas/' + pag + "/excluir-resposta.php",
        method: 'POST',
        data: {id},
        dataType: "text",

        success: function (mensagem) {            
            if (mensagem.trim() == "Excluído com Sucesso") {                
                listarRespostas(id_pergunta);                
            } else {
                    $('#mensagem-resposta').addClass('text-danger')
                    $('#mensagem-resposta').text(mensagem)
                }

        },      

    });
}

</script> -->