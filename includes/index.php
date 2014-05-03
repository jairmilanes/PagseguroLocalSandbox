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
    <div class="jumbotron">
      <div class="container">
        <h1>PagSeguro Local SandBox</h1>
        <p>Test your PagSeguro integration in localhost</p>
      </div>
    </div>

    <div class="container">
	  

      <footer>
        <p>Created by Jair Milanes Junior &copy; LayoutzWeb 2014</p>
      </footer>
    </div>
    
    
    <!-- /container -->       
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/snipet.js"></script>
        <script src="js/main.js"></script>
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
		<div id="dialog" class="modal fade">
		  	<input id="hidden_code" name="code" value="" type="hidden"/>
		  <div class="modal-dialog">
		    <div class="modal-content">
		      
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
    </body>
</html>
