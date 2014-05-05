<?php $transactions = $this->getTransactions(); ?>
<table id="transactions_table" class="table table-striped table-bordered table-hover">
 	<tr>
 		<th>Code</th>
 		<th>Items</th>
 		<th>Amount</th>
 		<th>Status</th>
 		<th>Date</th>
 		<th>#</th>
 		<th>#</th>
 	</tr>
 	<?php 
 	
 	if( count((array)$transactions) == 0 ){ ?>
	<tr class="transaction empty">
	 	<td colspan="7">
	 		<span class="glyphicon glyphicon-warning-sign"></span>
	 		<h3>Nenhuma transação encontrada!</h3>
	 		<p>Se está tendo problemas na configuração da SandBox, por favor veja a 
	 		documentação no <a href="https://github.com/layoutzweb/PagseguroLocalSandbox">github</a>,
	 		caso precise de ajuda visite nosso forum.</p>
	 	</td>
	</tr>
<?php 	} else {
	 	foreach( $transactions as $trans ){ 
	 			$xml = simplexml_load_string($trans->xml);?>
	 		<tr class="transaction">
	 			<td><?php echo $xml->code; ?></td>
	 			<td><?php echo ( count( $xml->items ) ); ?></td>
	 			<td><?php echo $xml->netAmount; ?></td>
	 			<td class="status">
	 				<a href="#" data-code="<?php echo $xml->code; ?>" class="btn <?php echo ( empty($xml->status)? '' : $this->getStatusClass($xml->status) ); ?> btn-xs" data-toggle="modal" data-target="#transaction_notify">
	 					<?php echo ( empty($xml->status)? '...' : $this->getStatusString($xml->status) ); ?>
	 					&nbsp;&nbsp;
	 					<span class="glyphicon glyphicon-refresh"></span>
	 				</a>
	 			</td>
	 			<td><?php echo date('d/m/Y H:i:s', strtotime($xml->date) ); ?></td>
	 			
	 			<td class="view">
	 				<a data-toggle="modal" data-target="#transaction_view" href="<?php echo $this->url('view').'&code='.$xml->code;?>" class="btn btn-default btn-xs">
	 					<span class="glyphicon glyphicon-eye-open"></span>
	 				</a>
	 			</td>
	 			<td class="delete">
	 				<a data-toggle="modal" data-target="#transaction_view" href="<?php echo $this->url('delete').'&code='.$xml->code;?>" class="btn btn-danger btn-xs">
	 					<span class="glyphicon glyphicon-remove"></span>
	 				</a>
	 			</td>
	 		</tr>
	 	<?php } 
	 }?>
</table>