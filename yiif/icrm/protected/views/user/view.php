<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'View'
	//$model->id,
);
$hasAdminAccess=Yii::app()->user->checkAccess('admin');
$attrUserRole=array();
if($hasAdminAccess)
{
	//get user role as row for attributes in display
	$attrUserRole=array(
		'name'=>'user_role',
		'value'=>CHtml::encode($model->getUserRoleText())
		);
}
else
{
	$attrUserRole='marital_status';
}
if($hasAdminAccess)
{
	$this->menu=array(
		array('label'=>'List User', 'url'=>array('index')),
		array('label'=>'Create User', 'url'=>array('create')),
		array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
		array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		array('label'=>'Manage User', 'url'=>array('admin')),
	);
}
else
{
	$this->menu=array(
		array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
	);
}
?>

<h1>View User</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'username',
		//'password',
		//'sex',
		'dob',
		'nationality',
		array(
		'name'=>'sex',
		'value'=>CHtml::encode($model->getSexText())
		),
		'email',
		'address',
		$attrUserRole				
		,
		
	),
)); ?>
