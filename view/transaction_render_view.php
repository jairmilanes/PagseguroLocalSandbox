<?php $xml = ResponseHelper::getInstance()->getData('xml');?>
<div style="margin: 10px; padding: 10px;" class="panel panel-info">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
				<li class="list-group-item"><h5><label>Payment Type:</label><?php echo UtilsHelper::translatePaymentType($xml->paymentMethod->type->__toString()); ?></h5></li>
				<li class="list-group-item"><h5><label>Payment Method:</label><?php echo UtilsHelper::translatePaymentMethod($xml->paymentMethod->code->__toString()); ?></h5></li>
			</ul>
			</div>
			</div>
			</div>
			
			
			<div class="tab-pane" id="sender">
				<div class="panel panel-default">
				<!--  <div class="panel-heading">Sender data:</div> -->
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
				<!--  <div class="panel-heading">Items data:</div> -->
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
				<!--  <div class="panel-heading">Shipping data:</div> -->
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
		</div>