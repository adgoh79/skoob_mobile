<?php
/* @var $this WebsitesController */
/* @var $model Websites */

$this->breadcrumbs=array(
	'Websites'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Websites', 'url'=>array('index')),
	array('label'=>'Create Websites', 'url'=>array('create')),
	array('label'=>'Update Websites', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Websites', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Websites', 'url'=>array('admin')),
);
?>

<h1>View Websites #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'ins_dt',
	),
)); ?>
