<?php
/* @var $this CheckoutController */
/* @var $model Checkout */

$this->breadcrumbs=array(
	'Checkouts'=>array('index'),
	'Thank You',
);
/*
$place='Singapore';
//$data = Yii::app()->CURL->run('http://www.google.com/ig/calculator?hl=en&q=1GBP=?USD');
$url = Yii::app()->globaldef->MIGS_SERVER.'makepaymentwithreceipt';
$data = Yii::app()->CURL->run($url,FALSE,array());
 */
//$xml = new SimplexmlElement($data);
//Yii::log('xml data=='.$data,'info','debug.thankyou');

$this->side_content='<div class="boxed_summary">
		Your order summary:
		<hr/>
		<img src="'.Yii::app()->request->baseUrl.$model->egift->gift_card_img.'" width="50%" height="50%"/>
		<br>
		skoob eGift card
		<br>
		Value: $<span id="card_val">'.$model->egift->amount.'</span>
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
		
		<hr/>
		Price:'.Yii::app()->globaldef->CURRENCY_SYM.$model->egift->amount.'<br>';
		
		if($model->promotion_discount>0.00){
			$this->side_content.='Promo discount:'.Yii::app()->globaldef->CURRENCY_SYM.$model->promotion_discount;
		}
		$this->side_content.='<hr/>
		Grand Total:'.Yii::app()->globaldef->CURRENCY_SYM.$model->total.'
		<hr/>
		Your credit card card will be charged '.Yii::app()->globaldef->CURRENCY_SYM.$model->total.'
		</div>';

?>

<div class="noSpan">
	<h1>Purchase Complete</h1>
	<br>
	Thank you for your purchase. We will deliver your e-Gift Voucher on <?php echo $model->egift->delivery_date; ?> 
	<br>to <?php echo $model->egift->recipient_name; ?> at <?php echo $model->egift->recipient_email; ?>. You will receive an email confirmation shortly.
	<br>
	What's next?
	<br><br>
	Send another eGift Card
	<div class="row buttons">
		<?php echo CHtml::Button('Buy eGift Card',array('submit'=>array('back')));?>
	</div>
	Browse skoob now
	<div class="row buttons">
		<?php echo CHtml::Button('Shop skoob',array('submit'=>array('skoob_home')));?>
	</div>
</div>
