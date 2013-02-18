<?php
/* @var $this TblProjectController */
/* @var $model TblProject */

$this->breadcrumbs=array(
	'Tbl Projects'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List TblProject', 'url'=>array('index')),
	array('label'=>'Create TblProject', 'url'=>array('create')),
	array('label'=>'Update TblProject', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TblProject', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TblProject', 'url'=>array('admin')),
);
?>

<h1>View TblProject #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'create_time',
		'create_user_id',
		'update_time',
		'update_user_id',
	),
)); ?>
