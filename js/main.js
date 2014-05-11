$(document).ready(function(){

	$('#transaction_notify_submit').on('click', function(){
		var btn = $(this);
		btn.button('loading');
		var form = $(this).parents('form[name="transaction_notify"]');
		var data = form.serialize();
		$.post( form.attr('action'), data, function(html){
			refreshResponse(html);
			btn.button('reset');
			reloadTable();
		},'html')
		.success(function(){
			btn.button('reset');
		})
		.done(function() {
		    btn.button('reset');
		})
		.fail(function() {
		    alert( "error" );
		    btn.button('reset');
		});
	});
	
	$('#transaction_notify').on('hidden.bs.modal', function(e){	
		refreshResponse('');
		$(e.target).removeData('bs.modal');
		$('#transactions_table tr').removeClass('danger active success warning info');
	});
	
	$('#transaction_view').on('hidden.bs.modal', function(e){
		$('#transaction_view .modal-content').html('');
		$(e.target).removeData('bs.modal');
		$('#transactions_table tr').removeClass('danger active success warning info');
	});
	
	$('.clear_response').on('click', function(){
		refreshResponse('');
	});

	transactionsInit();

});

function refreshResponse(html){
	$('#server_response .snippet-container').remove();
	$('#server_response pre').remove();
	$('#server_response').append('<pre>'+html+'</pre>');
	$('#server_response pre').snippet("php",{style:"whitengrey"});
}

function transactionsInit(){
	$('td.status a').on('click', function(){
		$('input#hidden_code').val($(this).data('code'));
		$(this).parents('tr').addClass('warning');
	});
	
	$('td.view a').on('click', function(){
		$(this).parents('tr').addClass('info');
	});
	
	$('td.delete a').on('click', function(){
		$(this).parents('tr').addClass('danger');
	});

}

function reloadTable(){
	$('#table_container').load( $('#table_container').data('refresh'), function(){
		if( $('#transactions_table').find('tr.transaction').length > 0 ){
			$('#sandbox .page-header a').addClass('active');	
		} else {
			$('#sandbox .page-header a').removeClass('active');	
		}
		transactionsInit();
	});
}