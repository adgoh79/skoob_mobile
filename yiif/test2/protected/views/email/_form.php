<?php
/* @var $this EmailController */
/* @var $model Email */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'email-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email_address'); ?>
		<?php echo $form->textField($model,'email_address',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'email_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id_fk'); ?>
		<?php echo $form->textField($model,'user_id_fk',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'user_id_fk'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ins_dt'); ?>
		<?php echo $form->textField($model,'ins_dt'); ?>
		<?php echo $form->error($model,'ins_dt'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->