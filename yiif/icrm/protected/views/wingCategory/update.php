<?php
/* @var $this WingCategoryController */
/* @var $model WingCategory */

$this->breadcrumbs=array(
	'Wing Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Wing Category', 'url'=>array('index')),
	array('label'=>'Create Wing Category', 'url'=>array('create')),
	array('label'=>'View Wing Category', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Wing Category', 'url'=>array('admin')),
);
?>

<h1>Update Wing Category</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>