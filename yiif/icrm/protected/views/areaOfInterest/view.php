<?php
/* @var $this AreaOfInterestController */
/* @var $model AreaOfInterest */

$this->breadcrumbs=array(
	'Area Of Interests'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Area Of Interest', 'url'=>array('index')),
	array('label'=>'Create Area Of Interest', 'url'=>array('create')),
	array('label'=>'Update Area Of Interest', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Area Of Interest', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Area Of Interest', 'url'=>array('admin')),
);
?>

<h1>View Area Of Interest</h1>

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
