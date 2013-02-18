<?php
/* @var $this MembershipFeeController */
/* @var $data MembershipFee */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->username), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_paid_dt')); ?>:</b>
	<?php echo CHtml::encode($data->last_paid_dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('next_paid_dt')); ?>:</b>
	<?php echo CHtml::encode($data->next_paid_dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('has_paid')); ?>:</b>
	<?php echo CHtml::encode($data->getYesNoText()); ?>
	<br />

	
	

</div>