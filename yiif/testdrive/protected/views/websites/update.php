<?php
/* @var $this WebsitesController */
/* @var $model Websites */

$this->breadcrumbs=array(
	'Websites'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Websites', 'url'=>array('index')),
	array('label'=>'Create Websites', 'url'=>array('create')),
	array('label'=>'View Websites', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Websites', 'url'=>array('admin')),
);
?>

<h1>Update Websites <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>