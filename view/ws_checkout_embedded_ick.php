<?php
/*
 *************************************************************************
* The MIT License (MIT)
*
* Copyright (c) [2014] [Jair Milanes Junior]

* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
************************************************************************
*/
?>
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
        	html, iframe,
        	#checkout_proccess {
        		padding-top: 0;
        		background: none !important;
        	}
        	#checkout_proccess a {
        		color: #5B8932;
        	}
        	.modal-header {
        		border-bottom: .3em solid #b8da99;
        	}
        	.modal-header .modal-title {
        		font-size: 1em;
				width: 27em;
				height: 3.625em;
				overflow: hidden;
				text-indent: -500000em;
				background-image: url(https://stc.pagseguro.uol.com.br/pagseguro/i/checkout-presentation/logo.svg);
				background-repeat: no-repeat;
				background-position: -60px 0;
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
   
    <body id="checkout_proccess" class="<?php echo ConfigHelper::getInstance()->get('checkout_complete');?>">
    	<a href="#" id="checkout_modal_trigger" data-toggle="modal" data-target="#checkout_modal"></a>
 
    	<div id="checkout_modal" class="modal fade">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Pagseguro</h4>
		      </div>
		      <div class="modal-body order" data-load="<?php echo UtilsHelper::url('checkout_process');?>">
		        <div class="row transaction"></div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button id="submit_checkout" class="btn btn-success pull-right">Finalizar compra.</button>
		      </div>
		    </div>
		  </div>
		</div>
 
    	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo BASE_URL.'js/vendor/jquery-1.11.0.min.js'?>"><\/script>')</script>
        <script src="<?php echo BASE_URL.'js/vendor/bootstrap.min.js'?>"></script>
        <script src="<?php echo BASE_URL.'js/plugins.js'?>"></script>
        <script src="<?php echo BASE_URL.'js/checkout.js'?>"></script>
        <script type="text/javascript">
	    	window.parent.postMessage('{"status": true, "value": true, "isMobile": false, "command": "ready"}', "*");

	    	// Listens to postMessages from parent window
	    	function listenMessage(event) {
	    		var data = JSON.parse(event.data);
	    		
	    		if( data.command == 'setToken' ){
	    			$('#checkout_proccess .order').trigger( 'token_set', data );
	    		}
	    		if( data.command == 'setToken' ){
	    			$('#checkout_proccess .order').trigger( 'token_set', data );
	    		}
	    	}
	    	if (window.addEventListener) {
	    	    window.addEventListener("message", listenMessage, false);
	    	} else {
	    	    window.attachEvent("onmessage", listenMessage);
	    	}
		</script>
    </body>
</html>