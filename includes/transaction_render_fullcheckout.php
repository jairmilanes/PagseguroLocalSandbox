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
	<?php require BASE_PATH.'includes/transaction_render_checkout.php'; ?>
	<!-- /container -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">window.jQuery || document.write('<script src="<?php echo BASE_URL?>js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
	<script src="<?php echo BASE_URL?>js/vendor/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo BASE_URL?>js/plugins.js" type="text/javascript"></script>
	<script src="<?php echo BASE_URL?>js/snipet.js" type="text/javascript"></script>
	<script src="<?php echo BASE_URL?>js/main.js" type="text/javascript"></script>
	
	<div id="transaction_view" class="modal fade">
		<input id="hidden_code" name="code" value="" type="hidden" />
		<div class="modal-dialog">
			<div class="modal-content"></div>
		</div>
	</div>

</body>
</html>