<?php $config = ResponseHelper::getInstance()->getData('config'); 
$config = json_decode(json_encode($config)); 

?>
<form id="settings" name="settings" class="form-horizontal" role="form">
	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Configurações</h4>
      </div>
      <div class="modal-body" style="padding:0;">
      	<table class="table table-hover" id="checkout_process_form">
      		<tr>
      			<td>
				  <div class="form-group">
				    <label for="email" class="col-sm-4 col-md-4 control-label">Email</label>
				    <div class="col-sm-7 col-md-7">
				      <input type=email class="form-control" id="email" name="email" placeholder="youremail@host.com.br" value="<?php echo @$config->email;?>">
				    </div>
				    <div class="col-sm-1 col-md-1"><span class="glyphicon glyphicon-question-sign"></span></div>
				  </div>
			  </td>
			</tr>
      		<tr>
      			<td>
				  <div class="form-group">
				    <label for="new_token" class="col-sm-4 col-md-4 control-label">Token teste</label>
				    <div class="col-sm-7 col-md-7">
				      <p class="static-control"><strong class="label label-success" style="font-size:14px;"><?php echo @$config->token;?></strong></p>
				      
				      <div class="checkbox">
					      <label>
					      	<input type="checkbox" id="new_token" name="new_token">
					      	Novo token?
					      </label>
					  </div>
				    </div>
				    <div class="col-sm-1 col-md-1"><span class="glyphicon glyphicon-question-sign"></span></div>
				  </div>
			  </td>
			</tr>
      		<tr>
      			<td>
				  <div class="form-group">
				    <label for="domain" class="col-sm-4 col-md-4 control-label">Dominio</label>
				    <div class="col-sm-7 col-md-7">
				      <input type=text class="form-control" id="domain" name="domain" placeholder="localhost.com" value="<?php echo @$config->domain;?>">
				    </div>
				    <div class="col-sm-1 col-md-1"><span class="glyphicon glyphicon-question-sign"></span></div>
				  </div>
			  </td>
			</tr>
			<tr>
				<td>
				  <div class="form-group">
				    <label for="notificationUrl" class="col-sm-4 col-md-4 control-label">Url de notificação</label>
				    <div class="col-sm-7 col-md-7">
				      <input type="text" class="form-control" id="notificationUrl" name="notificationUrl"  placeholder="/notification.php" value="<?php echo @$config->notificationUrl;?>">
				    </div>
				    <div class="col-sm-1 col-md-1"><span class="glyphicon glyphicon-question-sign"></span></div>
				  </div>
			  	</td>
			</tr>
			<tr>
				<td>
				  <div class="form-group">
				    <label for="fixed_redirect" class="col-sm-4 col-md-4 control-label">Redirecionament fixo?</label>
				    <div class="col-sm-7 col-md-7">
				       <input type="checkbox" id="fixed_redirect" name="fixed_redirect" <?php echo ( ($config->fixed_redirect !== '1')? '' : 'checked=checked' );?>>
				    </div>
				    <div class="col-sm-1 col-md-1"><span class="glyphicon glyphicon-question-sign"></span></div>
				  </div>
				</td>
			 </tr>
			<tr id="fixed_redirect_depend">
				<td>
				  <div class="form-group">
				    <label for="redirectUrl" class="col-sm-4 col-md-4 control-label">Url de redirecionamento</label>
				    <div class="col-sm-7 col-md-7">
				      <input type="text" class="form-control" id="redirectUrl" name="redirectUrl" placeholder="/success.php" value="<?php echo @$config->redirectUrl;?>">
				    </div>
				    <div class="col-sm-1 col-md-1"><span class="glyphicon glyphicon-question-sign"></span></div>
				  </div>
				</td>
			 </tr>
			 <tr>
			 	<td>
				  <div class="form-group">
				    <label for="port" class="col-sm-4 col-md-4 control-label">Porta</label>
				    <div class="col-sm-7 col-md-7">
				      <input type="number" class="form-control" id="port" name="port" placeholder="80" value="<?php echo @$config->port;?>">
				    </div>
				    <div class="col-sm-1 col-md-1"><span class="glyphicon glyphicon-question-sign"></span></div>
				  </div>
			 	</td>
			</tr>
			<tr>
				<td>
				  <div class="form-group">
				    <label for="checkout_complete" class="col-sm-4 col-md-4 control-label">Após confirmação</label>
				    <div class="col-sm-7 col-md-7">
				    	<select id="checkout_complete" name="checkout_complete" class="form-control" data-selected="<?php echo @$config->checkout_complete;?>">
				    		<option value="redirect">Redicionar</options>
				    		<option value="append">Append</option>
				    	</select>
				    </div>
				    <div class="col-sm-1 col-md-1"><span class="glyphicon glyphicon-question-sign"></span></div>
				  </div>
				</td>
			</tr>
		  </table>
	</div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="settings_submit" type="button" class="btn btn-primary" data-loading-text="Processando...">Salvar</button>
    </div>
</form>
<script>
$('#fixed_redirect').on('change', function(){;
	if( $(this).prop('checked') ){
		$('#fixed_redirect_depend').slideDown('fast');
	} else {
		$('#fixed_redirect_depend').slideUp('fast');
	}
}).triggerHandler('change');

var alert_timeout = null;
$('#settings_submit').on('click', function(){
	var alert = $('<div class="alert alert-dismissable" style="display: none;"/>');
	alert.remove();
	var btn = $(this);
	btn.button('loading');
	var data = $('form[name="settings"]').serialize();
	var url = '<?php echo UtilsHelper::url('settings');?>';
	$.post(url, data, function(response){
		if( response == '1' ){
			alert.addClass('alert-success').html('<p>Configurações salvas com sucesso!</p>');
			$('form[name="settings"] .form-group').removeClass('has-error has-warning has-success')
		} else if(response == '0' ) {
			alert.addClass('alert-danger').html('<p>Erro durante atualização!</p>');
		} else {
			json = testJson(response);
			
			if( false !== json ){
				$.each(json, function(name, error){
					if( $('input[name="'+name+'"]').length > 0 ){
						var group = $('input[name="'+name+'"]').parents('.form-group');
						group.removeClass('has-error has-warning has-success').addClass('has-error');
					}
				});
			}
			alert.addClass('alert-danger').html('<p>Erro durante atualização!</p>').fadeIn('fast');
			$('form[name="settings"]').find('input').eq(0).focus();
		}
		$('#settings .modal-body').prepend(alert);
		alert.fadeIn('fast');
		alert_timeout = setTimeout(function(){
			alert.fadeOut('fast', function(){alert.remove();});
		},3000);
	}).fail(function(){
		btn.button('reset');
	}).done(function(){
		btn.button('reset');
	});
});
function testJson(json){
	try {
		return $.parseJSON(json);
	} catch(e){
		return false;
	}
}
</script>