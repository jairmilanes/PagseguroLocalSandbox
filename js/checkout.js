$(document).ready(function(){
	
	$('#checkout_proccess .order').on('token_set', function(e, data){
		var container = $(e.target);
		var code = data.value;
		var url = container.data('load')+'&'+code;
		$.get( url, function(html){
			
			$('#checkout_modal_trigger').trigger('click');
			
			container.find('.transaction').html(html);
		});
	});
	
	$('#checkout_modal').on('hidden.bs.modal',function(){
		window.parent.postMessage('{"value": true, "command": "hide"}', "*");
	});
	

	var alert_timeout = 0;
	$('#submit_checkout').on('click', function(){
		var form = $('#checkout_proccess form[name="checkout_process"]');
		
		var code = form.find('input[name="code"]').val();

		window.parent.postMessage('{"value": "'+code+'", "command": "setTransactionCode"}', "*");
			
		var data = form.serialize();
		
		$.post( form.attr('action'), data, function(response){
			
			var alert = $('<div class="alert alert-dismissable" style="display: none;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>');
			
			if( response !== '0' ){
				
				alert.addClass('alert-success').append('<p>Checkout finalizado, redirecionando aguarde...</p>');

			} else {
				alert.addClass('alert-danger').append('<p>Erro ao finalizar o checkout!</p>');
			}
			
			$('#checkout_proccess .order').prepend(alert);

			alert.slideDown('fast');
			
			alert_timeout = setTimeout(function(){
				//window.close();
				alert.slideUp('fast', function(){
					$(this).remove();
				});
			},1800);
			
			$('.close', alert ).on('click', function(){
				window.clearTimeout(alert_timeout);
			});
			
			if( response !== '0' ){
				
				setTimeout(function(){
					window.parent.postMessage('{"command": "hide"}', "*");
				},1000);
				
			}
			
			//$('#checkout_proccess .order').fadeTo(.3, 500).html(response).fadeTo(1,500);

		});
		
		return false;
	});
});