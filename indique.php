<html lang="pt-BR">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/styles.css">
  <link rel="stylesheet" href="./css/mobile.css">
  <!-- Adicione isso ao cabeçalho do seu HTML -->
 




  <title>Indique uma Pessoa e Ganhe no PIX!</title>
  <style>
    .tipoConsulta { text-align:center;margin-top:30px;display:flex}
    .showVoce { display:none } 
  </style>
</head>
<body class="BodyBackground">
  <div class="container-fluid">
   <div class="row">
    <div class="col-10 offset-1 box-inicial">
      <div align="center" class="col-12 h1 indique-um-amigo">Indique uma Pessoa e Ganhe!</div>
    </div>
  </div>
  <div class="row box-img-form">
    <div class="col-lg-5 offset-1 col-10 padding-zero img-side">
      <div class="img-left">
        <img class="w-100" src="img/background-inicial.png">
      </div>
    </div>
    <div class="col-lg-5 col-10 offset-lg-0 offset-1 box-darkblue darkblue-overlay">
      <form id="frmSearch" name="frmSearch" autocomplete="off" method="post" onsubmit="return consultarDados()">>
        <div class="row" id="this-form">
          <div class="col-12">
            <h1 align="center" class="voce">Cliente ITLFibra</h1> <!-- VOCÊ -->
          </div>

        </div>
        <div class="row">

          <div class="col-12 col-lg-8 offset-lg-2">
            <form action="./painel/paginas/buscar_dados.php" method="POST">
              <div class="form-group text-center">
               <div class="tipoConsulta">
                 <input type="radio" id="cpf" checked name="tipo" value="1" style="display: none;">
                 <label for="cpf" class="labels" style="margin-top:-5px; margin-left: 0px;width:100px">CPF/CNPJ</label>
               </div>
               <div class="col-12">
                <div class="row showVoce">
                  <input type="text" class="form-control pinky-nobg col-8 boxcpf" style="float:left" placeholder="CPF ou CNPJ" name="cpfcnpj" id="cpfcnpj" onkeypress="chama_mascara(cpfcnpj)" onblur="ValidarCPFCNPJ(this);" maxlength="18">
                  <button type="submit" class="btn btn-primary BotaoConsulta col-4" id="searchClient">Consultar</button>
                </div>
              </div>
              <div class="col-12 text-center InformacoesConfirmadas" id="resultSearch">
              

              </form>
            </div>
            
          </div>
        </div>
      </form>
    </div>

    <div class="row">
      <div class="col-12">
        <h1 align="center" class="voce">Pessoa Indicada</h1> <!-- SEU INDICADO -->
      </div>
    </div>
    <div class="col-12 text-center InformacoesConfirmadas" id="resultIndique" style="display:none">

    </div>
    <div id="showForm">
      <form id="frmIndique" name="frmIndique" autocomplete="off" method="post" action="./painel/paginas/salvar_indica.php">
        <!-- Adicione este campo oculto para armazenar o nome do cliente -->
        <input type="hidden" name="idCliente" id="idCliente" value="" required>
        
        <div class="row">
          <div class="col-12 col-lg-8 offset-lg-2">
            <div class="form-group">
              <label for="nomeIndicado" class="labels">Nome do Indicado</label>
              <input type="text" class="form-control pinky-nobg" placeholder="Nome" name="nomeIndicado" id="nomeIndicado" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-8 offset-lg-2">
            <div class="form-group">
              <label for="telefoneIndicado" class="labels">Telefone do Indicado</label>
              <input type="text" class="form-control pinky-nobg" placeholder="Telefone" name="telefoneIndicado" id="telefoneIndicado" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-8 offset-lg-2">
            <div class="form-group">
              <label for="cidadeIndicado" class="labels">Cidade do Indicado</label>
              <select class="form-control pinky-nobg" placeholder="Cidade" name="cidadeIndicado" id="cidadeIndicado" required>
                <option value=""></option>
                <option value="Itamaraju">Itamaraju</option>
                <option value="Prado">Prado</option>
                <option value="Guarani - Prado">Guarani - Prado</option>
                <option value="Alcobaça">Alcobaça</option>
                <option value="Caravelas">Caravelas</option>
                <option value="Cumuruxatiba">Cumuruxatiba</option>
                <option value="Teixeira de Freitas">Teixeira de Freitas</option>
                <option value="Itagimirim">Itagimirim</option>
                <option value="Itapebi">Itapebi</option>
                
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-8 offset-lg-2">
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-enviar col-6 offset-3" id="addIndicacao">Enviar</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>
<div class="row">
  <div class="col-10 offset-1 box-down">
    <div class="asteriscos" align="center">
      <p class="top">* Somente clientes ITLFIBRA poderá indicar uma pessoa.<p>
        <p>* O cliente que indicar uma pessoa ganhará R$ 50,00 no PIX.</p>

     </div>
      <div class="col-12">
        <a href="./regulamento_indique_amigo.pdf" type="button" class="col-lg-6 offset-lg-3 btn btn-primary btn-regulamento" target="_blank">CONSULTE O REGULAMENTO</a>
      </div>
      <img class="offset-lg-3 col-lg-6 col-10 offset-1 logo-down">
    </div>
  </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<!--<script src="https://www.dstech.com.br/js/mensagens.js"></script>-->
<script src="./js/cpfcnpj.js" type="text/javascript"></script>
<script src="./js/javascript.js"></script>

</body>
</html>

<script>
  jQuery("#telefoneIndicado")
  .mask("(99) 9999-9999?9")
  .focusout(function (event) {  
    var target, phone, element;  
    target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
    phone = target.value.replace(/\D/g, '');
    element = $(target);  
    element.unmask();  
    if(phone.length > 10) {  
      element.mask("(99) 99999-999?9");  
    } else {  
      element.mask("(99) 9999-9999?9");  
    }  
  });

  $(document).ready(function(){
   $('.showVoce').show();
   $('.boxlogin').hide();
   $('.boxcpf').show();
   $('[name=tipo').click(function (){
     let tipo = $(this).val();
     $('.showVoce').show();
     if (parseInt(tipo) === 1) {
       $('.boxlogin').hide();
       $('.boxcpf').show();
     }

     if (parseInt(tipo) === 2) {
       $('.boxcpf').hide();
       $('.boxlogin').show();
     }

   });

 });

</script>

<script>






  function consultarDados() {
    event.preventDefault(); // Impede o envio padrão do formulário

    // Recolha os dados do formulário
    
    var cpfcnpj = document.getElementById('cpfcnpj').value;
    
    // Crie uma solicitação AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './painel/paginas/buscar_dados.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Defina a função de callback para manipular a resposta
    xhr.onload = function() {
      if (xhr.status === 200) {
            // Atualize a área de resultados com os dados retornados
        document.getElementById('resultSearch').innerHTML = xhr.responseText;
        document.getElementById('idCliente').value = cleanString(xhr.responseText);

        function cleanString(input) {
          var div = document.createElement("div");
          div.innerHTML = input;
          var text = div.textContent || div.innerText || "";
          return text;
        }
      }
    };

    
    // Envie a solicitação AJAX com os dados do formulário
    xhr.send('&cpfcnpj=' + cpfcnpj);


    return false; // Evita a submissão padrão do formulário
  }


</script>
