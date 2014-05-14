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
<div id="confirm_transaction_wipe">
	  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Deseja remover todas as transações?</h4>
      </div>
      <div class="modal-body">
      	<p>Esta ação não é reversível!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
        <button id="transactions_wipe" data-action="<?php echo UtilsHelper::url('wipe');?>" type="button" class="btn btn-danger" data-loading-text="Removento...">Limpar</button>
    </div>
    </div>
<script>
var modal = $('#transaction_view');
$('#transactions_wipe').on('click', function(e){
	var url = $(this).data('action');
	$.post(url, function(response){
		if( response == '1' ){
			reloadTable();
		} else {
			alert('Erro durante a execução!');
		}
		modal.modal('hide');
		return false;
	});
});
</script>