<?php
/* @var $this CheckoutController */
/* @var $model Checkout */


?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'checkout-form',
	'enableAjaxValidation'=>false,
)); ?>

<div class="noSpan">
	<h1>Transaction Failed</h1>
	<br>
	<?php echo $model->failed_msg; ?>
	<br>
	Send another eGift Card
	<div class="row buttons">
		<?php echo CHtml::Button('Buy eGift Card',array('submit'=>array('back')));?>
	</div>
	Browse skoob now
	<div class="row buttons">
		<?php echo CHtml::Button('Shop skoob',array('submit'=>array('skoob_home')));?>
	</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->