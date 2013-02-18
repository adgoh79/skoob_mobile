<?php
/* @var $this CheckoutController */
/* @var $model Checkout */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sender_email_add'); ?>
		<?php echo $form->textField($model,'sender_email_add',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'promotion_code'); ?>
		<?php echo $form->textField($model,'promotion_code',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'card_type_id'); ?>
		<?php echo $form->textField($model,'card_type_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'card_holder_name'); ?>
		<?php echo $form->textField($model,'card_holder_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'credit_card_no'); ?>
		<?php echo $form->textField($model,'credit_card_no',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'expiry_date'); ?>
		<?php echo $form->textField($model,'expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'egift_id'); ?>
		<?php echo $form->textField($model,'egift_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ins_dt'); ?>
		<?php echo $form->textField($model,'ins_dt'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->