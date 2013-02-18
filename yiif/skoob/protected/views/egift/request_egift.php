<script language="javascript">
  $(document).ready(function(){ 
		//ensure user does not copy and paste
		$('#Egift_sender_email').bind('paste', function(e){ 
			alert('Copy and pasting is not allowed. Please re-type the email address.');
			return false;
		});
		$('#Egift_sender_email_repeat').bind('paste', function(e){ 
			alert('Copy and pasting is not allowed. Please re-type the email address.');
			return false;
		});
		
		$('#Egift_recipient_email').bind('paste', function(e){ 
			alert('Copy and pasting is not allowed. Please re-type the email address.');
			return false;
		});
		$('#Egift_recipient_email_repeat').bind('paste', function(e){ 
			alert('Copy and pasting is not allowed. Please re-type the email address.');
			return false;
		});
	});
	
</script>

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
<?php echo $form->errorSummary($model); ?>
<h1>Request for skoob e-Gift Vouchers</h1>

Send a request to your friend for a skoob e-Gift Voucher
<br/>


	<div class="row">
		<?php echo $form->labelEx($model,'sender_name'); ?>
		<?php echo $form->textField($model,'sender_name',array('size'=>45,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'sender_name'); ?>
	</div>
	<div class="row">
		<?php echo CHtml::activeLabel($model, 'sender_email', array('required' => true)); ?>
		<?php echo $form->textField($model,'sender_email',array('size'=>45,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'sender_email'); ?>
	</div>
	<div class="row">
		<?php echo CHtml::activeLabel($model, 'sender_email_repeat'); ?>
		<?php echo $form->textField($model,'sender_email_repeat',array('size'=>45,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'sender_email_repeat'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'recipient_name'); ?>
		<?php echo $form->textField($model,'recipient_name',array('size'=>45,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'recipient_name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'recipient_email'); ?>
		<?php echo $form->textField($model,'recipient_email',array('size'=>45,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'recipient_email'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'recipient_email_repeat'); ?>
		<?php echo $form->textField($model,'recipient_email_repeat',array('size'=>45,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'recipient_email_repeat'); ?>
	</div>
	<div class="row buttons">
		
		<?php echo CHtml::Button('Request for e-Gift',array('submit'=>array('submit_egift_request')));?>
	</div>
	
<a href="http://www.skoob.com.sg/eGiftvouchers">Terms of skoob e-Gift Vouchers</a>
<?php $this->endWidget(); ?>

</div><!-- form -->