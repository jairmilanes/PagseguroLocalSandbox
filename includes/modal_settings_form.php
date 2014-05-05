<div id="transaction_notify" class="modal fade">
  <form name="transaction_notify" action="<?php echo $this->url('notify');?>" method="post">
  	<input id="hidden_code" name="code" value="" type="hidden"/>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Escolha um status</h4>
      </div>
      <div class="modal-body">
	        <div class="row">
				  <div class="col-xs-10">
				    <div>
				       	<select class="form-control" name="status">
				       		<option value="1">Aguardando pagamento</option>
							<option value="2">Em análise</option>
							<option value="3">Paga</option>
							<option value="4">Disponível</option>
							<option value="5">Em disputa</option>
							<option value="6">Devolvida</option>
							<option value="7">Cancelada</option>
				       	</select>
				    </div>
				  </div>
				  <div class="col-xs-2">
				    <button type="button" class="btn btn-default clear_response">Limpar</button>
				  </div>
			</div>
	    <div id="server_response">
	    	<h4>Resposta</h4>
	    	<pre></pre>
	    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
        <button type="button" class="btn btn-default clear_response">Limpar</button>
        <button id="transaction_notify_submit" type="button" class="btn btn-primary" data-loading-text="Enviando...">Enviar notificação</button>
      </div>
    </div>
  </div>
  </form>
</div>