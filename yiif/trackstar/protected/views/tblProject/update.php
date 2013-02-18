<?php
/* @var $this TblProjectController */
/* @var $model TblProject */

$this->breadcrumbs=array(
	'Tbl Projects'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TblProject', 'url'=>array('index')),
	array('label'=>'Create TblProject', 'url'=>array('create')),
	array('label'=>'View TblProject', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TblProject', 'url'=>array('admin')),
);
?>

<h1>Update TblProject <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>