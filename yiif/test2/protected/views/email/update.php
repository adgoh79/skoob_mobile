<?php
/* @var $this EmailController */
/* @var $model Email */

$this->breadcrumbs=array(
	'Emails'=>array('index'),
	$model->uid=>array('view','id'=>$model->uid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Email', 'url'=>array('index')),
	array('label'=>'Create Email', 'url'=>array('create')),
	array('label'=>'View Email', 'url'=>array('view', 'id'=>$model->uid)),
	array('label'=>'Manage Email', 'url'=>array('admin')),
);
?>

<h1>Update Email <?php echo $model->uid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>