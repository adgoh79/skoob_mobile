<?php
/* @var $this EmailController */
/* @var $data Email */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('uid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->uid), array('view', 'id'=>$data->uid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email_address')); ?>:</b>
	<?php echo CHtml::encode($data->email_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id_fk')); ?>:</b>
	<?php echo CHtml::encode($data->user_id_fk); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ins_dt')); ?>:</b>
	<?php echo CHtml::encode($data->ins_dt); ?>
	<br />


</div>