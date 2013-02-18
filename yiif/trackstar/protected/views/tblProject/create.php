<?php
/* @var $this TblProjectController */
/* @var $model TblProject */

$this->breadcrumbs=array(
	'Tbl Projects'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TblProject', 'url'=>array('index')),
	array('label'=>'Manage TblProject', 'url'=>array('admin')),
);
?>

<h1>Create TblProject</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>