<?php
session_start();

$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Login - Segurança</title>

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
  </head>
  <body>

    <div class="container">
      <form class="form-signin" method="post" action="validar_acesso.php" style="background:#fff;">
        <img src="imagens/logo.png" class="img-responsive">
        <center><h2 class="form-signin-heading">Área restrita</h2></center>
        <?php
        if($erro == 1){?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Usuário e ou senha inválido(s)</strong>
          </div>
        <?php
        }
        if($erro == 2){?>
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Erro na execução da consulta, favor entrar em contato com o admin do site</strong>
          </div>
        <?php
        }
        ?>
        <label for="inputUsuario" class="sr-only">Usuário</label>
        <input type="text" id="inputUsuario" name="inputUsuario" class="form-control" placeholder="Usuário" required autofocus>
        <label for="inputSenha" class="sr-only">Senha</label>
        <input type="password" id="inputSenha" name="inputSenha" class="form-control" placeholder="Senha" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div> <!-- /container -->

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.datetimepicker.full.min.js"></script>
  </body>
</html>
