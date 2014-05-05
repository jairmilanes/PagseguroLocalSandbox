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

        <link rel="stylesheet" href="<?php echo BASE_URL.'css/bootstrap.min.css'?>">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="<?php echo BASE_URL.'css/main.css'?>">
		<link rel="stylesheet" href="<?php echo BASE_URL.'css/snipet.css'?>">
        <script src="<?php echo BASE_URL.'js/vendor/modernizr-2.6.2-respond-1.1.0.min.js'?>"></script>
        <style>
        	#checkout_proccess {
        		padding-top: 0;
        	}
        	#checkout_proccess a {
        		color: #5B8932;
        	}
        	#checkout_proccess  .header {
        		margin-bottom: 40px;
        		border-bottom: .3em solid #b8da99;
        	}
        	.page-header {
				padding: 3em 0 0;
        		margin: 0;
        	}
        	.page-header > h1 {
        		font-size: 1em;
				width: 27em;
				height: 5.625em;
				overflow: hidden;
				text-indent: -500000em;
				background-image: url(https://stc.pagseguro.uol.com.br/pagseguro/i/checkout-presentation/logo.svg);
				background-repeat: no-repeat;
				background-position: 0 0;
				background-size: 100% 100%;
        	}
        	.list-group li {
        		width: 100%;
        		float: left;
        	}
        	.list-group li label {
        		display: block;
        		width: 30%;
        		float: left;
        	}
        	#info li .form-control {
        		float: left;
        		width: 50%;
        	}
        </style>
        
    </head>
    <body id="checkout_proccess" class="<?php echo $this->config->checkout_complete;?>">
    
    	<div class="header">
    		<div class="container">
	    		<div class="row">
	    			<div class="page-header">
				  		<h1>Pagseguro</h1>
					</div>
	    		</div>
	    	</div>
    	</div>
    	
    	<div class="container order">
    		<div class="row">
    			<?php require BASE_PATH."includes/transaction_render_checkout.php"; ?>
			</div>
			<div class="row">
				<button id="submit_checkout" class="btn btn-success pull-right">Finalizar compra.</button>
			</div>
    	</div>

    	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo BASE_URL.'js/vendor/jquery-1.11.0.min.js'?>"><\/script>')</script>
        <script src="<?php echo BASE_URL.'js/vendor/bootstrap.min.js'?>"></script>
        <script src="<?php echo BASE_URL.'js/plugins.js'?>"></script>
        <script src="<?php echo BASE_URL.'js/checkout.js'?>"></script>
        
    </body>
</html>