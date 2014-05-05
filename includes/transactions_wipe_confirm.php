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
        <button id="transactions_wipe" data-action="<?php echo $this->url('wipe');?>" type="button" class="btn btn-danger" data-loading-text="Removento...">Limpar</button>
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