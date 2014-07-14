<?php 
$xml = ResponseHelper::getInstance()->getData('xml');
$history = ResponseHelper::getInstance()->getData('history');
?>
<div id="checkout_process_form" style="margin: 10px; padding: 10px;" class="panel panel-success">
	<form name="checkout_process" action="<?php echo UtilsHelper::url('checkout_process');?>" method="post">
		<input name="code" type="hidden" value="<?php echo $xml->code;?>">
		
		<ul class="nav nav-tabs">
			<li class="active"><a href="#info" data-toggle="tab"><span class='glyphicon glyphicon-question-sign'></span>&nbsp;&nbsp;Info</a></li>
			<li><a href="#sender" data-toggle="tab"><span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Sender</a></li>
			<li><a href="#items" data-toggle="tab"><span class='glyphicon glyphicon-shopping-cart'></span>&nbsp;&nbsp;Items</a></li>
			<li><a href="#shipping" data-toggle="tab"><span class='glyphicon glyphicon-plane'></span>&nbsp;&nbsp;Shipping</a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="info">
				<div class="panel panel-default">
					<div class="panel-body">
						<ul class="list-group">
							<li class="list-group-item"><h5><label>Code:</label><?php echo $xml->code; ?></h5></li>
							<li class="list-group-item"><h5><label>Status:</label> <span class='label<?php echo UtilsHelper::getStatusClass($xml->status, 'label'); ?>'><?php echo UtilsHelper::getStatusString($xml->status); ?></span></h5></li>
							<li class="list-group-item"><h5><label>Reference:</label><?php echo $xml->reference; ?></h5></li>
							
							<li class="list-group-item">
								<h5>
									<label>Tipo de pagamento:</label>
									<select name="paymentMethod[type]" data-selected="<?php echo $xml->paymentMethod->type;?>" class="form-control">
										<option data-action="card" value="1">(1) Cartão de crédito</option>
										<option data-action="boleto" value="2">(2) Boleto</option>
										<option data-action="debit" value="3">(3) Débito online (TEF)</option>
										<option data-action="credit" value="4">(4) Saldo PagSeguro</option>
										<option data-action="paggo" value="5">(5) Oi Paggo</option>
										<option data-action="account" value="7">(7) Depósito em conta</option>
									</select>
								</h5>
							</li>
							
							<li class="list-group-item">
								<h5>
									<label>Metodo de pagamento:</label>
									<select name="paymentMethod[code]" data-selected="<?php echo $xml->paymentMethod->code;?>" class="form-control"></select>
								</h5>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			
			<div class="tab-pane" id="sender">
				<div class="panel panel-default">
					<!-- <div class="panel-heading">Sender data:</div>  -->
					<div class="panel-body">
						<ul class="list-group">
							<li class="list-group-item"><label>Name:</label><?php echo $xml->sender->name; ?></li>
							<li class="list-group-item"><label>Email:</label><?php echo $xml->sender->email; ?></li>
							<?php if ($xml->sender->phone) { ?>
								<li class="list-group-item"><label>Phone:</label><?php echo $xml->sender->phone->areaCode . " - " .
										$xml->sender->phone->number; ?></li>
							<?php }?>
						</ul>
					</div>
				</div>
			</div>

			
			<div class="tab-pane" id="items">
				<div class="panel panel-default">
					<!-- <div class="panel-heading">Items data:</div> -->
						<div class="panel-body">
						<?php if (is_array((array)$xml->items)) {
							foreach ((array)$xml->items as $key => $item) {?>
								<ul class="list-group">
								<li class="list-group-item"><label>Id:</label><?php echo $item->id; ?></li>
								<li class="list-group-item"><label>Description:</label><?php echo $item->description; ?></li>
								<li class="list-group-item"><label>Quantidade:</label><?php echo $item->quantity; ?></li>
								<li class="list-group-item"><label>Amount:</label><?php echo $item->amount; ?></li>
								</ul>
							<?php }?>
						<?php }?>
					</div>
				</div>
			</div>
			
			
			<div class="tab-pane" id="shipping">
				<div class="panel panel-default">
					<!-- <div class="panel-heading">Shipping data:</div> -->
					<div class="panel-body">
						<ul class="list-group">
							<?php if ($xml->shipping->address) {?>
								<li class="list-group-item"><label>Postal code:</label><?php echo $xml->shipping->address->postalCode; ?></li>
								<li class="list-group-item"><label>Street:</label><?php echo $xml->shipping->address->street; ?></li>
								<li class="list-group-item"><label>Number:</label><?php echo $xml->shipping->address->number; ?></li>
								<li class="list-group-item"><label>Complement:</label><?php echo $xml->shipping->address->complement; ?></li>
								<li class="list-group-item"><label>District:</label><?php echo $xml->shipping->address->getDistrict; ?></li>
								<li class="list-group-item"><label>City:</label><?php echo $xml->shipping->address->city; ?></li>
								<li class="list-group-item"><label>State:</label><?php echo $xml->shipping->address->state; ?></li>
								<li class="list-group-item"><label>Country:</label><?php echo $xml->shipping->address->country; ?></li>
							<?php }?>
							<li class="list-group-item"><label>Shipping type:</label><?php echo $xml->shipping->type; ?></li>
							<li class="list-group-item"><label>Shipping cost:</label><?php echo $xml->shipping->cost; ?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="footer">
		
		</div>
	</form>
	<p class="clearfix"></p>
	<div id="history">
		<div class="panel panel-default">
			<ul class="list-group">
				<?php foreach($history as $entry){?>
			  		<li class="list-group-item">
			  			<span><?php echo $entry->date;?></span>
			  			<span class="label"><?php echo $entry->status;?></span>
			  		</li>
			  	<?php } ?>
			</ul>
		</div>
	</div>
</div>