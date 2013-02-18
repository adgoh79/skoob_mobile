<?php
/* @var $this GiftCardController */
/* @var $model GiftCard */

$this->breadcrumbs=array(
	'Gift Cards'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create GiftCard', 'url'=>array('create')),
	array('label'=>'Manage GiftCard', 'url'=>array('admin')),
);
?>

<h1>Update GiftCard <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>