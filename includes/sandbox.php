<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <?php // <link rel="stylesheet" href="css/bootstrap-theme.min.css">?>
        <link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/snipet.css">
        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <style>
        #server_response {
        	margin-top: 20px;
        	border: 1px solid #ddd;
        	background: #eee;
        	padding: 15px;
        }
        #server_response h4 {
        	margin-top: 0;
        	border-bottom: 1px solid #ddd;
        	margin-bottom: 10px;
        }
        #transaction_view .tab-content .panel {
        	border-top: 0;
        }
		#transaction_view .tab-content label {
			display: block;
			float: left;
			width: 40%;
        }
        #transaction_view .tab-content li {
        	display: block;
        	overflow: hidden;
        }
        </style>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">PagSeguro Local Sandbox</a>
        </div>
        <a href="<?php echo $this->url('settings');?>" type="button" class="btn btn-info navbar-btn navbar-right" data-toggle="modal" data-target="#transaction_view"><span class="glyphicon glyphicon-cog"></span></a>
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container">
    	<div class="page-header">
	  		<h2>Transactions</h2>
		</div>
	  <div id="table_container" data-refresh="<?php $this->url('refresh'); ?>">
	  <?php require BASE_PATH.'includes/transactions_table.php'; ?>
	  </div>
      <hr>

      <footer>
      	<div class="col-md-5">
        <p>Created by Jair Milanes Junior &copy; LayoutzWeb 2014</p>
        </div>
        <div class="col-md-4 col-md-offset-3">
        	<div>
	        	<p style="text-align: right;">Se gostou da sandbox lembre-se de doar!</p>
	        	<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
				<form class="pull-right" action="https://pagseguro.uol.com.br/checkout/v2/donation.html" method="post">
					<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
					<input type="hidden" name="currency" value="BRL" />
					<input type="hidden" name="receiverEmail" value="web@layoutz.com.br" />
					<input type="image" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/doacoes/205x30-doar.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
				</form>
				<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
			</div>
        </div>
      </footer>
    </div> 
    
    <!-- /container -->        
    	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/snipet.js"></script>
        <script src="js/main.js"></script>
        
        <div id="transaction_notify" class="modal fade">
		  <form name="transaction_notify" action="<?php echo $this->url('notify');?>" method="post">
		  	<input id="hidden_code" name="code" value="" type="hidden"/>
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Escolha um status</h4>
		      </div>
		      <div class="modal-body">
			        <div class="row">
						  <div class="col-xs-10">
						    <div>
						       	<select class="form-control" name="status">
						       		<option value="1">Aguardando pagamento</option>
									<option value="2">Em análise</option>
									<option value="3">Paga</option>
									<option value="4">Disponível</option>
									<option value="5">Em disputa</option>
									<option value="6">Devolvida</option>
									<option value="7">Cancelada</option>
						       	</select>
						    </div>
						  </div>
						  <div class="col-xs-2">
						    <button type="button" class="btn btn-default clear_response">Limpar</button>
						  </div>
					</div>
		      
		      	
			    <div id="server_response">
			    	<h4>Resposta</h4>
			    	<pre></pre>
			    </div>
		      </div>
		      <div class="modal-footer">
		      
		        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
		        <button type="button" class="btn btn-default clear_response">Limpar</button>
		        <button id="transaction_notify_submit" type="button" class="btn btn-primary" data-loading-text="Enviando...">Enviar notificação</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		  </form>
		</div><!-- /.modal -->
		
		
		<div id="transaction_view" class="modal fade">
		  	<input id="hidden_code" name="code" value="" type="hidden"/>
		  <div class="modal-dialog">
		    <div class="modal-content">
		      
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

    </body>
</html>
