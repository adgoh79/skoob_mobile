<div class="form">
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'checkout-form',
	'enableAjaxValidation'=>false,
)); ?>

<h1>Introducing skoob e-Gift Vouchers</h1>

Send skoob e-Gift Vouchers anytime, anywhere. 
<br>skoob e-Gift Vouchers are perfect for any occasion. 
<br>Your e-Gift Vouchers are sent by email and may be redeemed instantly. 

<br><b>It's simple:</b>
<ul>
<li>Choose from 8 beautiful eGift designs for your special occasion.</li>
<li>Customise your e-Gift with a personal message.</li>
<li>Pick the perfect amount - available from S$10-S$100 in denominations of S$10.</li>
<li>Send your gift now, or schedule it for delivery on a special day</li>
<li>Receive notifications once your recipient has received the eGift Voucher.</li>
</ul>

	<div class="row buttons">
		<?php echo CHtml::Button('Send an e-Gift now',array('submit'=>array('create')));?>
		<?php echo CHtml::Button('Request for e-Gift',array('submit'=>array('request_egift')));?>
	</div>
	
<a href="http://www.skoob.com.sg/eGiftvouchers">Terms of skoob e-Gift Vouchers</a>
<?php $this->endWidget(); ?>

</div><!-- form -->