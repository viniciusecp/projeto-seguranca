<?php
session_start();

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Solicitar acesso</title>

    <link rel="shortcut icon" href="imagens/algar-icon.png" />

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- jquery -->
		<script src="js/jquery.js"></script>
		<!-- bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jquery.datetimepicker.css" rel="stylesheet">
    <link href="css/estilo.css" type="text/css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
      $(document).ready(function(){
        $('form input').on('keypress', function(e) {
          if(e.which == 13){
            $('#btn_pesquisar').click();
            this.blur();
          }
          return e.which !== 13;
        });

        $('#btn_pesquisar').click(function(){

          if ($('#input_pesquisar').val().length > 0) {
            $.ajax({
              url: 'get_sites.php',
              method: 'post',
              data: $('#formPesquisar').serialize(),
              success: function(data){
                $('#listSites').html(data);

                $('.link_estacao').click(function(){
                  var id_estacao = $(this).data('id_estacao');
                  var empresa = $(this).data('empresa');
                  var estacao = $(this).data('estacao');

                  $('.link_estacao').hide();
                  $('.link_estacao').off();
                  $('#id_estacao_'+id_estacao).show();

                  $.ajax({
                    url: 'get_dados.php',
                    success:function(data){

                      $('#listSites').append(data);
                      //$('form input').on('keypress', function(e) {
                        //return e.which !== 13;
                      //});
                      $('input').on('keypress', function(e) {
                        if(e.which == 13) this.blur();
                        return e.which !== 13;
                      });

                      $('#btn_solicitar').click(function(){
                        var matricula = $('#inputMatricula').val();
                        var nome = $('#inputNome').val();
                        var telefone = $('#inputTelefone').val();
                        var data = $('#inputDateTimePickerData').val();
                        var entrada = $('#inputDateTimePickerHoraEntrada').val()+":"+$('#inputDateTimePickerMinEntrada').val();
                        var saida = $('#inputDateTimePickerHoraSaida').val()+":"+$('#inputDateTimePickerMinSaida').val();
                        var numeroOS = $('#inputNumeroOS').val();
                        var atividade = $('#inputAtividade').val();
                        var descricaoAtividade = $('#inputDescricaoAtividade').val();

                        var campo_vazio = false;
              					if(matricula == '' || matricula <= 0){
              						$('#inputMatricula').css({'border-color': '#A94442'});
              						campo_vazio = true;
              					} else {
              						$('#inputMatricula').css({'border-color': '#CCC'});
              					}

              					if(nome == ''){
              						$('#inputNome').css({'border-color': '#A94442'});
              						campo_vazio = true;
              					} else {
              						$('#inputNome').css({'border-color': '#CCC'});
              					}

                        if(telefone == '' || telefone == '+55 '){
              						$('#inputTelefone').css({'border-color': '#A94442'});
              						campo_vazio = true;
              					} else {
              						$('#inputTelefone').css({'border-color': '#CCC'});
              					}
                        if(data == '__/__/____'){
                          $('#inputDateTimePickerData').css({'border-color': '#A94442'});
              						campo_vazio = true;
              					} else {
              						$('#inputDateTimePickerData').css({'border-color': '#CCC'});
              					}

                        if( $('#inputDateTimePickerHoraEntrada').val().match(/__/) ||  $('#inputDateTimePickerMinEntrada').val().match(/__/)
                        || $('#inputDateTimePickerHoraEntrada').val() == '' ||  $('#inputDateTimePickerMinEntrada').val() == ''){
              						$('#inputDateTimePickerHoraEntrada').css({'border-color': '#A94442'});
                          $('#inputDateTimePickerMinEntrada').css({'border-color': '#A94442'});
                          $('#spanEntrada').css({'border-color': '#A94442', 'color': '#A94442'});
              						campo_vazio = true;
              					} else {
                          $('#inputDateTimePickerHoraEntrada').css({'border-color': '#CCC'});
                          $('#inputDateTimePickerMinEntrada').css({'border-color': '#CCC'});
                          $('#spanEntrada').css({'border-color': '#CCC', 'color': '#CCC'});
              					}

                        if( $('#inputDateTimePickerHoraSaida').val().match(/__/) ||  $('#inputDateTimePickerMinSaida').val().match(/__/)
                        || $('#inputDateTimePickerHoraSaida').val() == '' ||  $('#inputDateTimePickerMinSaida').val() == ''){
              						$('#inputDateTimePickerHoraSaida').css({'border-color': '#A94442'});
                          $('#inputDateTimePickerMinSaida').css({'border-color': '#A94442'});
                          $('#spanSaida').css({'border-color': '#A94442', 'color': '#A94442'});
              						campo_vazio = true;
              					} else {
                          $('#inputDateTimePickerHoraSaida').css({'border-color': '#CCC'});
                          $('#inputDateTimePickerMinSaida').css({'border-color': '#CCC'});
                          $('#spanSaida').css({'border-color': '#CCC', 'color': '#CCC'});
              					}

                        if(numeroOS == '' || numeroOS <= 0){
              						$('#inputNumeroOS').css({'border-color': '#A94442'});
              						campo_vazio = true;
              					} else {
              						$('#inputNumeroOS').css({'border-color': '#CCC'});
              					}

                        if(atividade == '' || atividade <= 0){
              						$('#inputAtividade').css({'border-color': '#A94442'});
              						campo_vazio = true;
              					} else {
              						$('#inputAtividade').css({'border-color': '#CCC'});
              					}

              					if(campo_vazio) return false;

                        $.ajax({
                          url: 'enviar_solicitacao.php',
                          method: 'post',
                          data: {
                            matricula: matricula,
                            nome: nome,
                            telefone: telefone,
                            empresa: empresa,
                            estacao: estacao,
                            data: data,
                            entrada: entrada,
                            saida: saida,
                            numeroOS: numeroOS,
                            atividade: atividade,
                            descricaoAtividade: descricaoAtividade
                          },
                          success: function(data){
                            $('#resultado_solicitacao').html(data);
                            $('#janela_modal').modal('show');
                          }
                        });
                      });
                    }, // fim get_dados
                    beforeSend: function(){
                      $('#loader2').css({display:"block"});
                    },
                    complete: function(){
                      $('#loader2').css({display:"none"});
                    }
                  });
                });
              }, //success: get_sites
              beforeSend: function(){
                $('#loader').css({display:"block"});
              },
              complete: function(){
                $('#loader').css({display:"none"});
              }
            });
          }
        });
      });
    </script>

  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-heading" style="color:#31708f; background:#d9edf7;">
              <h2>Solicitar acesso
                <span style="float:right;">
                  <a href="../visualizacaoSolicitacoes/" class="glyphicon glyphicon-th-list"></a>
                </span>
              </h2>
            </div>
            <div class="panel-body">
                <form id="formPesquisar" class="input-group" action="" method="post">
                  <input id="input_pesquisar" name="input_pesquisar" type="text" class="form-control" placeholder="Informe uma parte do endereço..."></input>
                  <span id="btn_pesquisar" class="btn btn-default input-group-addon" style="background:#d9edf7;">
                    <span class="glyphicon glyphicon-search" style="color:#31708f;"></span>
                  </span>
                </form>
            </div>
          </div>
          <div class="list-group" id="listSites">
            <center> <img src="imagens/loader.gif" style="display:none" id="loader"> </center>
          </div>
          <center> <img src="imagens/loader.gif" style="display:none" id="loader2"> </center>
          <div id="resultado_solicitacao"></div>
        </div>
        <div class="col-md-2"></div>
      </div>
    </div>


    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.datetimepicker.full.min.js"></script>

  </body>
</html>
