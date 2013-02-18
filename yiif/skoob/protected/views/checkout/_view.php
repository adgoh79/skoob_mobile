<?php
/* @var $this CheckoutController */
/* @var $data Checkout */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sender_email_add')); ?>:</b>
	<?php echo CHtml::encode($data->sender_email_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('promotion_code')); ?>:</b>
	<?php echo CHtml::encode($data->promotion_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('card_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->card_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('card_holder_name')); ?>:</b>
	<?php echo CHtml::encode($data->card_holder_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('credit_card_no')); ?>:</b>
	<?php echo CHtml::encode($data->credit_card_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expiry_date')); ?>:</b>
	<?php echo CHtml::encode($data->expiry_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('egift_id')); ?>:</b>
	<?php echo CHtml::encode($data->egift_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ins_dt')); ?>:</b>
	<?php echo CHtml::encode($data->ins_dt); ?>
	<br />

	*/ ?>

</div>