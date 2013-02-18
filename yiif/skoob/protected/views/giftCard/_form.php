<?php
/* @var $this GiftCardController */
/* @var $model GiftCard */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'gift-card-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<?php if(!$model->isNewRecord){ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'img_url'); ?>
		<?php echo CHtml::image(Yii::app()->request->baseUrl.$model->img_url,'card image'); ?>
		<?php echo $form->error($model,'img_url'); ?>
	</div>
	<?php } ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'new_image'); ?>
		<?php echo $form->fileField($model, 'new_image'); ?>
		<?php echo $form->error($model, 'new_image'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->