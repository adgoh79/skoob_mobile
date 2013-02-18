<?php
/* @var $this CheckoutController */
/* @var $model Checkout */
/* @var $form CActiveForm */
?>
<script language="javascript">
  $(document).ready(function(){ 
    
	$('#Checkout_sender_email_add_repeat').bind('paste', function(e){ 
		alert('Copy and pasting is not allowed. Please re-type the email address.');
		return false;
		});
	$('#Checkout_sender_email_add').bind('paste', function(e){ 
			alert('Copy and pasting is not allowed. Please re-type the email address.');
			return false;
		});
		
		$('#Checkout_card_type_id').change(function() {
			
			var card_name=$("#Checkout_card_type_id option:selected").text();
			$('#Checkout_credit_card_name').val(card_name);
		});
  });
 </script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'checkout-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
	<div class="row">
		<?php echo $form->labelEx($model,'sender_email_add'); ?>
		<?php echo $form->textField($model,'sender_email_add',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'sender_email_add'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sender_email_add_repeat'); ?>
		<?php echo $form->textField($model,'sender_email_add_repeat',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'sender_email_add_repeat'); ?>
	</div>

	
	<div class="row">
		<?php echo $form->labelEx($model,'promotion_code'); ?>
		<?php echo $form->textField($model,'promotion_code',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'promotion_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'card_type_id'); ?>
		
		<?php echo $form->dropDownList($model,'card_type_id', $model->getCreditCards()); ?>
		<?php echo $form->error($model,'card_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'card_holder_name'); ?>
		<?php echo $form->textField($model,'card_holder_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'card_holder_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'credit_card_no'); ?>
		<?php echo $form->textField($model,'credit_card_no',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'credit_card_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'security_code'); ?>
		<?php echo $form->textField($model,'security_code',array('size'=>10,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'security_code'); ?>
	</div>

	<div class="row">
		<label class="required">Expiry Date (MMYYYY)
		<span class="required">*</span>
		</label>
		<?php echo $form->textField($model,'expiry_date'); ?>
		<?php echo $form->error($model,'expiry_date'); ?>
	</div>
	<input type="hidden" id="egift_id" value="<?php echo $model->egift_id; ?>"></input>
	<?php echo $form->hiddenField($model, 'credit_card_name') ; ?>
	<div class="row">
	<?php echo $form->checkBox($model,'check_agree') ?>
		By clicking Buy Now, I agree to skoob's <a href="#">Terms of Sale</a>
	</div>
	<div class="row buttons">
		<?php echo CHtml::Button('Back',array('submit'=>array('back')));?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Buy Now' : 'Save'); ?>
		
		
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->