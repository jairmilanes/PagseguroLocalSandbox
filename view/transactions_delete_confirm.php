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
<?php $code = ResponseHelper::getInstance()->getData('code');?>
<div id="confirm_transaction_delete">
	  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Deseja remover esta transação?</h4>
      </div>
      <div class="modal-body">
      	<h3 style="text-align: center;"><?php echo $code; ?></h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
        <button id="transaction_delete" type="button" class="btn btn-danger" data-loading-text="Removendo...">Remover</button>
    </div>
    </div>
<script>
var modal = $('#transaction_view');
$('#transaction_delete').on('click', function(){
	
	var btn = $(this);
	btn.button('loading');
	var url = '<?php echo UtilsHelper::url('delete');?>';
	var data = { code: "<?php echo $code; ?>" };

	var alert = $('<div class="alert alert-dismissable" style="display: none;"/>');
	
	$.post(url, data, function(response){
		if (response == '1'){
			reloadTable();
			alert.addClass('alert-success').html('<p>Transação removida com succeso!</p>');
		} else {
			alert.addClass('alert-success').html('<p>Erro durante a remoção do registro!</p>');
		}
		$('#confirm_transaction_delete .modal-body').prepend(alert);
		alert.fadeIn('fast');
		alert_timeout = setTimeout(function(){
			alert.fadeOut('fast', function(){alert.remove();});
			modal.modal('hide');
		},700);
	})
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
</script>