<?php
/* @var $this AreaOfInterestController */
/* @var $model AreaOfInterest */

$this->breadcrumbs=array(
	'Area Of Interests'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Area Of Interest', 'url'=>array('index')),
	array('label'=>'Manage Area Of Interest', 'url'=>array('admin')),
);
?>

<h1>Create Area Of Interest</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>