<?php
/* @var $this MembershipFeeController */
/* @var $model MembershipFee */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'membership-fee-form',
	'enableAjaxValidation'=>false,
)); 


?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php 
		
			echo $form->errorSummary($model); 
	?>
	<?php
		$memberType=$model->getMemberTypeText();
		if($memberType=="Non Member" || $memberType=="Life Member")
			echo '<div class="errorSummary">User is a '.$memberType.'. Update not required.</div>'; 
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $model->username; ?>
		<?php echo $form->hiddenField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>
	</br>
	<div class="row">
		<?php echo $form->labelEx($model,'member_type_id'); ?>
		<?php echo $memberType;
			$disabled_attr=($memberType=="Non Member" || $memberType=="Life Member")?"'disabled'=>true":"";
		?>
		<?php echo $form->hiddenField($model,'member_type_id'); ?>
		<?php echo $form->error($model,'member_type_id'); ?>
	</div>
	</br>
	<div class="row">
		<?php //echo $form->labelEx($model,'last_paid_dt'); ?>
		<?php //echo $form->textField($model,'last_paid_dt'); 
		/*
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'publishDate',
			'model' => $model,
			'attribute'=>'last_paid_dt',
			'value'=>$model->last_paid_dt,
			// additional javascript options for the date picker plugin
			'options'=>array(
				'defaultDate'=>$model->last_paid_dt,
				'dateFormat'=>'yy-mm-dd',
				'showAnim'=>'fold',
			),
			'htmlOptions'=>array(
				'style'=>'height:20px;'
			),
		));
		*/
		?>
		<?php //echo $form->error($model,'last_paid_dt'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'membership_availability'); ?>
		<?php echo $form->dropDownList($model,'membership_availability', $model->getAvailabilityOpt()); ?>
		<?php echo $form->error($model,'membership_availability'); ?>
	
	</div>	
	
	<div class="row buttons">
		<?php 
			if($memberType=="Non Member" || $memberType=="Life Member")
				echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array("disabled"=>true));
			else
				echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); 
		?>
		<?php echo CHtml::Button('Cancel',array('submit'=>array('cancel')));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->