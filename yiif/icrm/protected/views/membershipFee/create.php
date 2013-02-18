<?php
/* @var $this MembershipFeeController */
/* @var $model MembershipFee */

$this->breadcrumbs=array(
	'Membership Fees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MembershipFee', 'url'=>array('index')),
	array('label'=>'Manage MembershipFee', 'url'=>array('admin')),
);
?>

<h1>Create MembershipFee</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>