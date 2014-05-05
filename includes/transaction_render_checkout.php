<div id="checkout_process_form" style="margin: 10px; padding: 10px;" class="panel panel-success">
	<form name="checkout_process" action="<?php echo $this->url('checkout_process');?>" method="post">
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
							<li class="list-group-item"><h5><label>Status:</label> <span class='label<?php echo $this->getStatusClass($xml->status, 'label'); ?>'><?php echo $this->getStatusString($xml->status); ?></span></h5></li>
							<li class="list-group-item"><h5><label>Reference:</label><?php echo $xml->reference; ?></h5></li>
							
							<li class="list-group-item">
								<h5>
									<label>Tipo de pagamento:</label>
									<select name="paymentMethod[type]" data-selected="<?php echo $xml->paymentMethod->type;?>" class="form-control">
										<option value="1">(1) Cartão de crédito</option>
										<option value="2">(2) Boleto</option>
										<option value="3">(3) Débito online (TEF)</option>
										<option value="4">(4) Saldo PagSeguro</option>
										<option value="5">(5) Oi Paggo</option>
										<option value="7">(7) Depósito em conta</option>
									</select>
								</h5>
							</li>
							
							<li class="list-group-item">
								<h5>
									<label>Metodo de pagamento:</label>
									<select name="paymentMethod[code]" data-selected="<?php echo $xml->paymentMethod->code;?>" class="form-control">
										<option value="101">(101) Cartão de crédito Visa</option>
										<option value="102">(102) Cartão de crédito MasterCard</option>
										<option value="103">(103) Cartão de crédito American Express</option>
										<option value="104">(104) Cartão de crédito Diners</option>
										<option value="105">(105) Cartão de crédito Hipercard</option>
										<option value="106">(106) Cartão de crédito Aura</option>
										<option value="107">(107) Cartão de crédito Elo</option>
										<option value="108">(108) Cartão de crédito PLENOCard</option>
										<option value="109">(109) Cartão de crédito PersonalCard</option>
										<option value="110">(110) Cartão de crédito JCB</option>
										<option value="111">(111) Cartão de crédito Discover</option>
										<option value="112">(112) Cartão de crédito BrasilCard</option>
										<option value="113">(113) Cartão de crédito FORTBRASIL</option>
										<option value="114">(114) Cartão de crédito CARDBAN</option>
										<option value="115">(115) Cartão de crédito VALECARD</option>
										<option value="116">(116) Cartão de crédito Cabal</option>
										<option value="117">(117) Cartão de crédito Mais!</option>
										<option value="118">(118) Cartão de crédito Avista</option>
										<option value="119">(119) Cartão de crédito GRANDCARD</option>
										<option value="120">(120) Cartão de crédito Sorocred</option>
										<option value="202">(202) Boleto Santander</option>
										<option value="301">(301) Débito online Bradesco</option>
										<option value="302">(302) Débito online Itaú</option>
										<option value="304">(304) Débito online Banco do Brasil</option>
										<option value="306">(306) Débito online Banrisul</option>
										<option value="307">(307) Débito online HSBC</option>
										<option value="401">(401) Saldo PagSeguro</option>
										<option value="701">(701) Depósito em conta - Banco do Brasil</option>
										<option value="702">(702) Depósito em conta - HSBC</option>
									</select>
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
</div>