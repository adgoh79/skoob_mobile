<?php
/* @var $this EgiftController */
/* @var $data Egift */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recipient_email')); ?>:</b>
	<?php echo CHtml::encode($data->recipient_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recipient_name')); ?>:</b>
	<?php echo CHtml::encode($data->recipient_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sender_name')); ?>:</b>
	<?php echo CHtml::encode($data->sender_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_date')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ins_dt')); ?>:</b>
	<?php echo CHtml::encode($data->ins_dt); ?>
	<br />

	*/ ?>

</div>