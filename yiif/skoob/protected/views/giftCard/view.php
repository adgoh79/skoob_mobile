<?php
/* @var $this GiftCardController */
/* @var $model GiftCard */

$this->breadcrumbs=array(
	'Gift Cards'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List GiftCard', 'url'=>array('index')),
	array('label'=>'Create GiftCard', 'url'=>array('create')),
	array('label'=>'Update GiftCard', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GiftCard', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GiftCard', 'url'=>array('admin')),
);
?>

<h1>View GiftCard #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'img_url',
		'ins_dt',
	),
)); ?>
