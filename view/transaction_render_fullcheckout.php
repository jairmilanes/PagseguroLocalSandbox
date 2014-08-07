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

<link rel="stylesheet" href="<?php echo BASE_URL?>css/bootstrap.min.css">
<style type="text/css">
body {
	padding-top: 50px;
	padding-bottom: 20px;
}
</style>
<?php // <link rel="stylesheet" href="css/bootstrap-theme.min.css">?>
<link rel="stylesheet" href="<?php echo BASE_URL?>css/main.css">
<link rel="stylesheet" href="<?php echo BASE_URL?>css/snipet.css">
<script src="<?php echo BASE_URL?>js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
</head>
<body id="sandbox">
	<div id="nav-bar" class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">PagSeguro Local Sandbox</a>
				<strong>Fluxo de pagamento</strong>
			</div>
		</div>
	</div>
	<p>&nbsp;</p>
	<div class="container">
		<h4><span class="glyphicon glyphicon-ok-circle"></span> Aqui você vê o pedido gerado a partir das informações enviadas à API do PagSeguro, assim você pode conferir se os dados do pagamento estão de acordo com as specificações da api.</h4>
	</div>
	<p>&nbsp;</p>
	<div class="container">
		<div class="row">
			<div class="col-md-7">
				<?php require BASE_PATH.'view/transaction_render_checkout.php'; ?>
				<p>Clique aqui para ver a <a target="_blank" href="https://pagseguro.uol.com.br/v2/guia-de-integracao/api-de-pagamentos.html">documentação do PagSeguro</a>
			</div>
			<div class="col-md-5">
				<div class="panel panel-success panel-default">
					<div id="api" class="panel-body">
						<?php //require "params_info_table.php";?>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
				    <button id="transaction_submit" class="btn btn-success btn-lg pull-right">Finalizar transação <span class="glyphicon glyphicon-ok"></span></button>
				</div>
			</div>
		</div>
	</div>
	<!-- /container -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">window.jQuery || document.write('<script src="<?php echo BASE_URL?>js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
	<script src="<?php echo BASE_URL?>js/vendor/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo BASE_URL?>js/plugins.js" type="text/javascript"></script>
	<script src="<?php echo BASE_URL?>js/snipet.js" type="text/javascript"></script>
	<script src="<?php echo BASE_URL?>js/main.js" type="text/javascript"></script>
	<script>
	$(document).ready(function(){
		
		var json = [];
		var format_param = function(param){
			var par = param.split('</strong>');
			return par[1].trim();
		}

		transaction_method_select();
		
		/*
		$('#api table tbody > tr').each(function(i, elem){

			var self = $(elem);
			var params = $('td:eq(1) > p', self).eq(2).html();


			console.log(params);

			
			if( params ){

				params = params.split('<br>');
				var item = {};
				
				if( $('td:first-child', self).find('.tab1').length > 0 ){
					var tabs = $('td:first-child div[class^="tab"]', self);
					var base = {};
					
					for(var i=0; i<tabs.length; i++){
						//var tabs.eq(i).text() = {}
						
					}
						
					json = { 
						checkout: {
							item: {

							}
						}
					}
					
				} else {
					item.param 			= $('td:first-child', self).html().trim();
				}

					item.title 			= $('td:eq(1) > p', self).eq(0).text().trim();
					item.description 	= $('td:eq(1) > p', self).eq(1).html().trim();
					item.presence 		= format_param(params[0]);
					item.type 			= format_param(params[1]);
					item.format 		= format_param(params[2]);

					json.push(item);
			}
			self = null;
			params = null;

		});
		*/ 

		
		$('#transaction_submit').on('click', function(){
			var btn = $(this);
			btn.button('loading');
			var data = $('form[name="checkout_process"]').serialize();
			var url = '<?php echo UtilsHelper::url('checkout_process')?>';
			<?php 
			$redirect = '//'.ConfigHelper::getInstance()->get('domain').ConfigHelper::getInstance()->get('redirectUrl');
			if( preg_match('/\?/', $redirect) ){
				$redirect .= '&transaction_id=';
			} else {
				$redirect .= '?transaction_id=';
			}?>
			$.post(url, data, function(data, textStatus, jqXHR){
				if( jqXHR.status === 200 ){
					window.location.href = "<?php echo $redirect;?>"+data;
				} else {
					console.log(data);
					console.log(textStatus);
					alert('Erro durante a finalização da transação.');
				}		
				btn.button('reset');
				return false;
			});
		});
	});
	</script>
</body>
</html>