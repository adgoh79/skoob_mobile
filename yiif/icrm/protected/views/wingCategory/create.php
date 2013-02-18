<?php
/* @var $this WingCategoryController */
/* @var $model WingCategory */

$this->breadcrumbs=array(
	'Wing Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Wing Category', 'url'=>array('index')),
	array('label'=>'Manage Wing Category', 'url'=>array('admin')),
);
?>

<h1>Create Wing Category</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>