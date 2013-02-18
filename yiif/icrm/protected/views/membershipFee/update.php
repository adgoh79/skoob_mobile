<?php
/* @var $this MembershipFeeController */
/* @var $model MembershipFee */

$this->breadcrumbs=array(
	//'Membership Fees'=>array('index'),
	'Manage'=>array('membershipFee/admin'),
	//$model->user_id=>array('view','id'=>$model->user_id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List MembershipFee', 'url'=>array('index')),
//	array('label'=>'Create MembershipFee', 'url'=>array('create')),
//	array('label'=>'View MembershipFee', 'url'=>array('view', 'id'=>$model->user_id)),
	array('label'=>'Manage Membership Fee', 'url'=>array('admin')),
);
?>

<h1>Update Membership Fee </h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>