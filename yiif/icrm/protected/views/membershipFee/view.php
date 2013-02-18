<?php
/* @var $this MembershipFeeController */
/* @var $model MembershipFee */

$this->breadcrumbs=array(
	'Manage'=>array('membershipFee/admin'),
	'Membership Fee',
	
);

$this->menu=array(
	//array('label'=>'List MembershipFee', 'url'=>array('index')),
	//array('label'=>'Create MembershipFee', 'url'=>array('create')),
	array('label'=>'Update Membership Fee', 'url'=>array('update', 'id'=>$model->user_id)),
	array('label'=>'Manage Membership Fee', 'url'=>array('admin')),
);
?>

<h1>View Membership Fee</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'user_id',
		array(
		'name'=>'user_id',
		'value'=>CHtml::encode($model->getUserName($model->user_id))
		),
		//'last_paid_dt',
		//'next_paid_dt',
		array(
			'name'=>'membership_availability',
			'value'=>CHtml::encode($model->getAvailabilityText())
		),
		
		//'create_dt',
		//'create_user_id',
		//'update_dt',
		//'update_user_id',
	),
)); ?>
