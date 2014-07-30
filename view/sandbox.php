<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="css/bootstrap.min.css">
<style type="text/css">
body {
	padding-top: 50px;
	padding-bottom: 20px;
}
</style>
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/snipet.css">
<link rel="stylesheet" href="js/vendor/switch/css/bootstrap3/bootstrap-switch.min.css">
<script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
</head>


<body id="sandbox">
	<!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
	<div id="nav-bar" class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">PagSeguro Local Sandbox</a>
			</div>
			<a href="<?php echo UtilsHelper::url('help');?>"
				type="button"
				class="btn btn-warning btn-help navbar-btn navbar-right"
				data-toggle="modal"
				data-target="#transaction_view"
				style="margin-left: 10px;">
					<span class="glyphicon glyphicon-question-sign"></span>
			</a>
			
			<a href="<?php echo UtilsHelper::url('settings');?>"
				type="button"
				class="btn btn-success navbar-btn navbar-right"
				data-toggle="modal"
				data-target="#transaction_view">
					<span class="glyphicon glyphicon-cog"></span>
			</a>
			
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<div id="page-header" class="page-header col-md-12 pull-left">
				<h2 class="pull-left">Transações</h2>
				<?php
				$transactions = ResponseHelper::getInstance()->getData('transactions');
				$class="";
				if( count($transactions) > 0 ){
					$class = 'active';
				}?>
				<a href="<?php echo UtilsHelper::url('wipe');?>" id="remove_all"
					data-toggle="modal" data-target="#transaction_view"
					class="btn btn-danger pull-right <?php echo $class;?>">Limpar transações</a>
			</div>
		</div>
		
		<div class="row">
			<div id="table_container" class="col-md-12" data-refresh="<?php echo UtilsHelper::url('refresh'); ?>">
				<?php require BASE_PATH.'view/transactions_table.php'; ?>
			</div>
		</div>

		<hr>

		<footer class="row">
			<div class="col-md-5">
				<p>Created by Jair Milanes Junior &copy; LayoutzWeb 2014</p>
			</div>
			<div class="col-md-4 col-md-offset-3">
				<div>
					<p style="text-align: right;">Se gostou da sandbox lembre-se de
						doar!</p>
					<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
					<form class="pull-right"
						action="https://pagseguro.uol.com.br/checkout/v2/donation.html"
						method="post">
						<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
						<input type="hidden" name="currency" value="BRL" /> <input
							type="hidden" name="receiverEmail" value="web@layoutz.com.br" />
						<input type="image"
							src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/doacoes/205x30-doar.gif"
							name="submit"
							alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
					</form>
					<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
				</div>
			</div>
		</footer>
	</div>

	<!-- /container -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
	<script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
	<script src="js/plugins.js" type="text/javascript"></script>
	<script src="js/snipet.js" type="text/javascript"></script>
	<script src="js/vendor/loading.js" type="text/javascript"></script>
	<script src="js/vendor/switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
	<script src="js/vendor/zero_clipboard/ZeroClipboard.js" type="text/javascript"></script>
	<script src="js/main.js" type="text/javascript"></script>

	<?php require_once BASE_PATH.'view/modal_transaction_notify.php'; ?>

	<div id="transaction_view" class="modal fade">
		<input id="hidden_code" name="code" value="" type="hidden" />
		<div class="modal-dialog">
			<div class="modal-content"></div>
		</div>
	</div>
	<div id="loading">
		<div class="backdrop"></div>
	</div>
</body>
</html>
