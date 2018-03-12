<?php
session_start();

if (!isset($_SESSION['usuario'])) {
  header('Location: index.php?erro=1');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Visualizar Solicitações</title>

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

        var telefoneSMS = '';

        if(Notification.permission !== 'granted')
		      Notification.requestPermission();

        function notifyMe(title, mensagem){
        	if(!Notification){
        		alert('O navegador que você está utilizando não possui o notifications.');
        		return;
        	}

        	if(Notification.permission !== "granted"){
        		Notification.requestPermission();
        	}else{
        		var notification = new Notification(title, {
        			icon: 'imagens/algar-icon.png',
        			body: mensagem
        		});

        		notification.onclick = function(){
        			window.focus('#');

        		};
        	}
        }

        function atualizaTable(dataSearch, inputEntradaSearch1, inputEntradaSearch2){
          $.ajax({
            url: 'get_solicitacoes.php',
            method: 'post',
            data: {
              dataSearch: dataSearch,
              inputEntradaSearch1: inputEntradaSearch1,
              inputEntradaSearch2: inputEntradaSearch2
            },
            success: function(data){
              $('tbody').html(data);
              $('.btn-visualizado').click(function() {
                var idRow = $(this).attr('id');
                var array = Array();
                array = idRow.split("_");
                idRow = array[1];
                clickVisualizar(idRow);
              });
              $('.btn-SMS').click(function(){
                telefoneSMS = $(this).data('telefone');
                $('#div_headermodal').html('Enviar SMS para '+telefoneSMS);
              });
            }
          });
        }

        function longPolling(timestamp){
      		var polling = {};
      		if(typeof timestamp != "undefined")
      			polling.timestamp = timestamp;

      		$.ajax({
      			type: "POST",
      			url: "longpolling.php",
      			data: polling,
      			success: function(res)
      			{
      				var obj = jQuery.parseJSON(res);
      				for (var i = 0; i < obj.solicitacoes.length; i++) {
      					var row = JSON.stringify(obj.solicitacoes[i]);
      					row = jQuery.parseJSON(row);
      					var matricula = atob(row.matricula);
      					var nome = atob(row.nome);
      					var telefone = atob(row.telefone);
                var empresa = atob(row.empresa);
                var regional_estacao = atob(row.regional_estacao);
                var data = row.data;
                var entrada = row.entrada;
                var saida = row.saida;
                var ordem_servico = atob(row.ordem_servico);
                var atividade = atob(row.atividade);
                var descricao_atividade = atob(row.descricao_atividade);
                var visualizado = row.visualizado;
                var idRow = row.id;
                if (visualizado) {
                  visualizado = '';
                  var mostrarBotao = "none";
                  var botaoSMS = "block";
                } else {
                  visualizado = 'danger';
                  var mostrarBotao = "block";
                  var botaoSMS = "none";
                }

                $('tbody').prepend(
                  "<tr id='row_"+idRow+"' class="+visualizado+">"+
                    "<td>"+matricula+"</td>"+
                    "<td>"+nome+"</td>"+
                    "<td>"+telefone+"</td>"+
                    "<td>"+empresa+"</td>"+
                    "<td>"+regional_estacao+"</td>"+
                    "<td>"+data+"</td>"+
                    "<td>"+entrada+"</td>"+
                    "<td>"+saida+"</td>"+
                    "<td>"+ordem_servico+"</td>"+
                    "<td>"+atividade+"</td>"+
                    "<td>"+descricao_atividade+"</td>"+
                    "<td>"+
                      "<button id='btn_"+idRow+"' class='btn btn-primary glyphicon glyphicon-ok btn-visualizado' style='display:"+mostrarBotao+"' ></button>"+
                      "<button id='btn_"+idRow+"' class='btn btn-info glyphicon glyphicon-envelope btn-SMS' style='display:"+botaoSMS+"' data-telefone='"+telefone+"' data-toggle='modal' data-target='#janela_modal'></button>"+
                    "</td>"+
                  "</tr>"
                );
                notifyMe('Solicitação de Acesso', nome+' deseja acessar '+regional_estacao+' as '+entrada+' no dia '+data);
      				}
              $('.btn-visualizado').click(function() {
                var idRow = $(this).attr('id');
                var array = Array();
                array = idRow.split("_");
                idRow = array[1];
                clickVisualizar(idRow);
              });
              $('.btn-SMS').click(function(){
                telefoneSMS = $(this).data('telefone');
                $('#div_headermodal').html('Enviar SMS para '+telefoneSMS);
              });
      				longPolling(res.timestamp);
      			}
      		});


      	}

        function clickVisualizar(idRow){
          $.ajax({
      			type: "POST",
      			url: "enviar_confirmacaoVisualizacao.php",
      			data: { idRow: idRow },
      			success: function(data)
      			{
              var idBtn = '#btn_'+idRow;
              $(idBtn).css({display:"none"});
              var idRow = '#row_'+idRow;
              $(idRow).removeClass("danger");
              atualizaTable();
            }
          });
        }

        var mensagem = '';

        $('#btn_msgReprovado').click(function(){
          mensagem = 'Solicitação de acesso negada!!!';
          sendSMS(mensagem);
        });
        $('#btn_msgAprovado').click(function(){
          mensagem = 'Solicitação de acesso aprovada!';
          sendSMS(mensagem);
        });
        $('#btn_msgEnviar').click(function(){
          mensagem = $('#inputSMS').val();
          $('#inputSMS').val('');
          sendSMS(mensagem);
        });

        function sendSMS(mensagem){
          alert('telefone: '+telefoneSMS+' mensagem: '+mensagem);
          // chamar pagina php via ajax para enviar o SMS
          $('#janela_modal').modal('hide');
        }

        $('#btnSearch').click(function(){
          var dataSearch = $('#inputDateSearch').val();
          var entradaSearch1 = $('#inputEntradaSearch1').val();
          var entradaSearch2 = $('#inputEntradaSearch2').val();

          if (dataSearch != '' && entradaSearch1 != '' && entradaSearch2 != '') {
            var valor = dataSearch.split('-');
            dataSearch = valor[2]+"/"+valor[1]+"/"+valor[0];
            atualizaTable(dataSearch, entradaSearch1, entradaSearch2);
          }

        });

        $('#btnRemoveSearch').click(function(){atualizaTable();});

        atualizaTable();
        longPolling();
        setInterval(atualizaTable, 900000); // 15 minutos
      });



    </script>

  </head>
  <body>
    <div class="container">
      <div class="row">

        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">

              <label> Bem vindo! </label>

              <span class="btn-group" role="group" style="float:right;">
                <button id="btnSearch" type="button" class="btn btn-default glyphicon glyphicon-filter" style="color:#31708f;background:#d9edf7;border:1px solid #31708f;"></button>
                <button id="btnRemoveSearch" type="button" class="btn btn-default glyphicon glyphicon-remove" style="color:#d9edf7;background:#31708f;border:1px solid #31708f;"></button>
              </span>

              <span class="input-group" style="float:right;width:15%;margin-right:20px;">
                <span class="input-group-addon" style="background:#d9edf7; width:120px;">
                  <span style="color:#31708f;"><strong>Intervalo de entrada:</strong></span>
                </span>
                <input id="inputEntradaSearch1" type="time" class="form-control" style="border-right:none;background:none;"></input>
                <span id="spanEntrada" class="input-group-addon" style="color:#31708f;width:0px;background:none;border-left:none;border-right:none;padding:0 30px 0 0;"><strong>às</strong></span>
                <input id="inputEntradaSearch2" type="time" class="form-control" style="border-left:none;background:none;"></input>
              </span>


              <span class="input-group" style="float:right;width:25%;margin-right:20px;">
                <span class="input-group-addon" style="background:#d9edf7; width:120px;">
                  <span style="color:#31708f;"><strong>Data:</strong></span>
                </span>
                <input id="inputDateSearch" type="date" class="form-control" ></input>
              </span>

            </div>
          </div>


          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover table-condensed">
              <thead style="background:#d9edf7;color:#31708f">
                <tr>
                  <th>Matricula</th>
                  <th>Nome</th>
                  <th>Telefone</th>
                  <th>Empresa</th>
                  <th>Regional - Estação</th>
                  <th>Data</th>
                  <th>Entrada</th>
                  <th>Saida</th>
                  <th>#OS</th>
                  <th>Atividade</th>
                  <th>Descrição</th>
                  <th>Ações</th>
                </tr>
              </thead>
                <tbody>
                  <!-- Inserir conteudo tabela -->
                </tbody>
              </table>
            </div>
            <!-- Janela Modal ---------------------------------------------------------------------------------------->
            <form class="modal fade" id="janela_modal">
              <div class="modal-dialog"  >
                <div class="modal-content">
                  <!-- cabecalho -->
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"> <span>&times;</span> </button>
                    <h3 id="div_headermodal"class="modal-title"></h3>
                  </div>
                  <!-- corpo -->
                  <div id="div_bodymodal" class="modal-body">
                    <textarea id="inputSMS" rows="3" class="form-control"></textarea>
                  </div>
                  <!-- rodape -->
                  <div class="modal-footer">
                    <button id="btn_msgReprovado" type="button" class="btn btn-danger glyphicon glyphicon-remove" style="float:left;" data-toggle="tooltip" data-placement="top" title="Mensagem default: Solicitação de acesso negada!!!"></button>
                    <button id="btn_msgAprovado" type="button" class="btn btn-success glyphicon glyphicon-ok" style="float:left;margin-left:5px;" data-toggle="tooltip" data-placement="top" title="Mensagem default: Solicitação de acesso aprovada!"></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btn_msgEnviar" type="button" class="btn btn-primary">Enviar</button>
                  </div>
                </div>
              </div>
            </form>
            <!-- Janela Modal ---------------------------------------------------------------------------------------->
        </div>

      </div>
    </div>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="js/jquery.js"></script>
    <script type="text/javascript">
      $(function () {
        $('[data-toggle="tooltip"]').tooltip();
      })
    </script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.datetimepicker.full.min.js"></script>

  </body>
</html>
