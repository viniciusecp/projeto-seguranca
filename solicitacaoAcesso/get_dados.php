<?php

session_start();

?>

<div class="panel panel-default" style="margin-top: 10px;">
  <div class="panel-body">

    <div class="input-group" style="width:100%;">
      <span class="input-group-addon" style="background:#d9edf7; width:120px;">
        <span style="color:#31708f;"><strong>Matricula:</strong></span>
      </span>
      <input id="inputMatricula" type="number" class="form-control" placeholder="Informe sua matricula"></input>
    </div>
    <br>

    <div class="input-group" style="width:100%;">
      <span class="input-group-addon" style="background:#d9edf7; width:120px;">
        <span style="color:#31708f;"><strong>Nome:</strong></span>
      </span>
      <input id="inputNome" type="text" class="form-control" placeholder="Informe seu nome"></input>
    </div>
    <br>

    <div class="input-group" style="width:100%;">
      <span class="input-group-addon" style="background:#d9edf7; width:120px;">
        <span style="color:#31708f;"><strong>Fone:</strong></span>
      </span>
      <form>
          <input id="inputTelefone" type="text" class="form-control bfh-phone" data-format="+55 (dd) d dddd-dddd">
      </form>
      <!-- <input id="inputTelefone" type="number" class="form-control">-->
    </div>
    <br>

    <div class="input-group" style="width:100%;">
      <span class="input-group-addon" style="background:#d9edf7; width:120px;">
        <span style="color:#31708f;"><strong>Data:</strong></span>
      </span>
      <input readonly id="inputDateTimePickerData" style="width:93px;padding-left:9px;padding-right:0;background:none" type="text" class="form-control"></input>
    </div>
    <br>

    <div class="input-group">
      <span class="input-group-addon" style="background:#d9edf7; width:120px;">
        <span style="color:#31708f;"><strong>Hora entrada:</strong></span>
      </span>
      <input readonly id="inputDateTimePickerHoraEntrada" style="width:45px;border-right:none;background:none;" type="text" class="form-control"></input>
      <span id="spanEntrada" class="input-group-addon" style="width:0px;background:none;border-left:none;border-right:none;padding:0;"><strong>:</strong></span>
      <input readonly id="inputDateTimePickerMinEntrada" style="width:45px;border-left:none;background:none;" type="text" class="form-control"></input>
    </div>
    <br>

    <div class="input-group">
      <span class="input-group-addon" style="background:#d9edf7; width:120px;">
        <span style="color:#31708f;"><strong>Hora saida:</strong></span>
      </span>
      <input readonly id="inputDateTimePickerHoraSaida" style="width:45px;border-right:none;background:none;" type="text" class="form-control"></input>
      <span id="spanSaida" class="input-group-addon span_hora" style="width:0px;background:none;border-left:none;border-right:none;padding:0;"><strong>:</strong></span>
      <input readonly id="inputDateTimePickerMinSaida" style="width:45px;border-left:none;background:none;" type="text" class="form-control"></input>
    </div>
    <br>

    <div class="input-group" style="width:100%;">
      <span class="input-group-addon" style="background:#d9edf7; width:120px;">
        <span style="color:#31708f;"><strong>#OS:</strong></span>
      </span>
      <input id="inputNumeroOS" type="number" class="form-control" placeholder="Informe o número da OS"></input>
    </div>
    <br>

    <div class="input-group" style="width:100%;">
      <span class="input-group-addon" style="background:#d9edf7; width:120px;">
        <span style="color:#31708f;"><strong>Atividade:</strong></span>
      </span>
      <input id="inputAtividade" type="text" class="form-control" maxlength="50"></input>
    </div>
    <br>

    <div class="input-group" style="width:100%;">
      <span class="input-group-addon" style="background:#d9edf7; width:120px;">
        <span style="color:#31708f;"><strong>Descrição:</strong></span>
      </span>
      <textarea id="inputDescricaoAtividade" type="text" class="form-control custom-control" rows="2" maxlength="300" placeholder="Informe a descrição da atividade"></textarea>
    </div>
    <br>

    <button id="btn_solicitar" type="button" class="btn btn-default btn-block" style="background:#d9edf7;color:#31708f;border:2px solid #d9edf7"><strong>Solicitar Acesso</strong></button>

    <script type="text/javascript" src="js/bootstrap-formhelpers.min.js"></script>
    <script>
    // https://xdsoft.net/jqplugins/datetimepicker/
    jQuery.datetimepicker.setLocale('pt-BR');
    jQuery('#inputDateTimePickerData').datetimepicker({
      format:'d/m/Y',
      minDate:0,
      mask:true,
      timepicker:false
    });
    jQuery('#inputDateTimePickerHoraEntrada').datetimepicker({
      format:'H',
      formatTime:'H',
      mask:true,
      datepicker:false
    });
    jQuery('#inputDateTimePickerMinEntrada').datetimepicker({
      format:'i',
      formatTime:'i',
      mask:true,
      datepicker:false,
      allowTimes:['00','05','10','15','20','25','30','35','40','45','50','55']
    });
    jQuery('#inputDateTimePickerHoraSaida').datetimepicker({
      format:'H',
      formatTime:'H',
      mask:true,
      datepicker:false
    });
    jQuery('#inputDateTimePickerMinSaida').datetimepicker({
      format:'i',
      formatTime:'i',
      mask:true,
      datepicker:false,
      allowTimes:['00','05','10','15','20','25','30','35','40','45','50','55']
    });
    </script>


  </div>
</div>
