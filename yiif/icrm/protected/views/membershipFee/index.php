<?php
/* @var $this MembershipFeeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Membership Fees',
);

$this->menu=array(
	//array('label'=>'Create MembershipFee', 'url'=>array('create')),
	array('label'=>'Manage MembershipFee', 'url'=>array('admin')),
);
?>

<h1>Membership Fees</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
