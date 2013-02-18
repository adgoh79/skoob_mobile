<?php
/* @var $this CheckoutController */
/* @var $model Checkout */



$this->side_content='<div class="boxed_summary">
		Your order summary:
		<hr/>
		<img src="'.Yii::app()->request->baseUrl.$model->egift->gift_card_img.'" width="50%" height="50%"/>
		<br>
		Value: '.Yii::app()->globaldef->CURRENCY_SYM.'<span id="card_val">'.$model->egift->amount.'</span>
		<hr/>
		Gift Details
		<br>
		To:'.$model->egift->recipient_name.'<br>
		'.$model->egift->recipient_email.'
		<br>
		From:'.$model->egift->sender_name.'
		<br>
		Delivery date:'.$model->egift->delivery_date.'
		<br>
		Message:'.$model->egift->message.'
		<br><br>
		'.CHtml::link('Change Details',array('egift/create','id'=>$model->egift_id)).'
		
		<hr/>
		Price:'.Yii::app()->globaldef->CURRENCY_SYM.$model->egift->amount.'
		<br>';
		
		if($model->promotion_discount>0.00)
			$this->side_content.='Promo discount:'.Yii::app()->globaldef->CURRENCY_SYM.$model->promotion_discount.'<hr/>';
		
		$this->side_content.='Grand Total:'.Yii::app()->globaldef->CURRENCY_SYM.$model->total.'
		<hr/>
		Your credit card card will be charged '.Yii::app()->globaldef->CURRENCY_SYM.$model->total.'
		</div>';
?>

<h1>Checkout</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>