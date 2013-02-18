<?php
/* @var $this AreaOfInterestController */
/* @var $model AreaOfInterest */

$this->breadcrumbs=array(
	'Area Of Interests'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Area Of Interest', 'url'=>array('index')),
	array('label'=>'Create Area Of Interest', 'url'=>array('create')),
	array('label'=>'View Area Of Interest', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Area Of Interest', 'url'=>array('admin')),
);
?>

<h1>Update Area Of Interest</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>