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
<?php $transactions = ResponseHelper::getInstance()->getData('transactions');?>
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
	 				<a href="#" data-code="<?php echo $xml->code; ?>" class="btn <?php echo ( empty($xml->status)? '' : UtilsHelper::getStatusClass($xml->status) ); ?> btn-xs" data-toggle="modal" data-target="#transaction_notify">
	 					<?php echo ( empty($xml->status)? '...' : UtilsHelper::getStatusString($xml->status) ); ?>
	 					&nbsp;&nbsp;
	 					<span class="glyphicon glyphicon-refresh"></span>
	 				</a>
	 			</td>
	 			<td><?php echo date('d/m/Y H:i:s', strtotime($xml->date) ); ?></td>
	 			
	 			<td class="view">
	 				<a data-toggle="modal" data-target="#transaction_view" href="<?php echo UtilsHelper::url('view').'&code='.$xml->code;?>" class="btn btn-default btn-xs">
	 					<span class="glyphicon glyphicon-eye-open"></span>
	 				</a>
	 			</td>
	 			<td class="delete">
	 				<a data-toggle="modal" data-target="#transaction_view" href="<?php echo UtilsHelper::url('delete').'&code='.$xml->code;?>" class="btn btn-danger btn-xs">
	 					<span class="glyphicon glyphicon-remove"></span>
	 				</a>
	 			</td>
	 		</tr>
	 	<?php }
	 }?>
</table>