<?php
/* @var $this CheckoutController */
/* @var $model Checkout */



?>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<div class="boxed_summary content_div">
		<span class="attn">Your order summary:</span>
		<hr/>
		<img src="<?php echo Yii::app()->request->baseUrl.$model->egift->gift_card_img; ?>" width="100%" height="100%"/>
		<br>
		<span class="attn-right">Value: <span id="card_val"><?php echo Yii::app()->globaldef->CURRENCY_SYM.$model->egift->amount; ?></span></span>
		<hr/>
		
		
		<table class="summary">
			<tr>
				<th colspan="3">
					<u>Gift Details</u>&nbsp;<sup>[<?php echo CHtml::link('Change Details',array('egift/create','id'=>$model->egift->id),array('class'=>'change-details')); ?>]</sup>
				
				</th>			
				
			</tr>
			<tr>
				<td width="20%">
					<span class="attn-norm">To</span>
				</td>	
				<td align="left"><span class="attn-norm">:</span></td>	
				<td>
					<?php echo $model->egift->recipient_name; ?><br>
				<?php echo $model->egift->recipient_email; ?>
				</td>	
			</tr>
		
			<tr>
				<td>
					<span class="attn-norm">From
				</td>	
				<td><span class="attn-norm">:</span></td>	
				<td>
					</span><?php echo $model->egift->sender_name; ?>
				</td>
			</tr>
			<tr>
				<td>
					<span class="attn-norm">Delivery date
				</td>	
				<td><span class="attn-norm">:</span></td>	
				<td>
					
					</span><?php echo $model->egift->delivery_date ?>
				</td>
			</tr>
			<tr>
				<td>
					<span class="attn-norm">Message</span>
				</td>	
				<td><span class="attn-norm">:</span></td>	
				<td>
					<?php echo $model->egift->message ?>
				</td>
			</tr>
			<tr>
				<td colspan="3"><br><hr/></td>
		
			<tr>
				<th colspan="3">
					<u>Your Payment summary</u>
				</th>			
			</tr>
			
			<tr>
				<td>
					<span class="attn-norm">Price</span>
				</td>	
				<td><span class="attn-norm">:</span></td>	
				<td>
					<?php echo Yii::app()->globaldef->CURRENCY_SYM.$model->egift->amount ?>
				</td>
			</tr>
			
		<?php if($model->promotion_discount>0.00){ ?>
			<tr>
				<td>
					<span class="attn-norm">Promo discount</span>
				</td>	
				<td><span class="attn-norm">:</span></td>	
				<td>	
					<?php echo Yii::app()->globaldef->CURRENCY_SYM.$model->promotion_discount; ?>
				</td>
			</tr>	
		<?php } ?>
			<tr>
				<td>
					<span class="attn-norm">Grand Total</span>
				</td>	
				<td><span class="attn-norm">:</span></td>	
				<td>	
					<?php echo Yii::app()->globaldef->CURRENCY_SYM.$model->total; ?>
				</td>
			</tr>		
		</table>
		<hr/>
		<span class="attn-norm">Your credit card card will be charged <?php echo Yii::app()->globaldef->CURRENCY_SYM.$model->total; ?></span>
</div>
	<br><br>
	<div class="row buttons">
		<?php echo CHtml::Button('Cancel',array('submit'=>array('cancel','id'=>$model->id)));?>
		<?php echo CHtml::Button('Buy Now',array('submit'=>array('buy_gift','id'=>$model->id)));?>
	</div>
	