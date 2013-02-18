<?php
/* @var $this WingCategoryController */
/* @var $model WingCategory */

$this->breadcrumbs=array(
	'Wing Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Wing Category', 'url'=>array('index')),
	array('label'=>'Create Wing Category', 'url'=>array('create')),
	array('label'=>'Update Wing Category', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Wing Category', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Wing Category', 'url'=>array('admin')),
);
?>

<h1>View Wing Category</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'create_dt',
		//'create_user_id',
		//'update_dt',
		//'update_user_id',
	),
)); ?>
