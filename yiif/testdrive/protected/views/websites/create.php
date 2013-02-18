<?php
/* @var $this WebsitesController */
/* @var $model Websites */

$this->breadcrumbs=array(
	'Websites'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Websites', 'url'=>array('index')),
	array('label'=>'Manage Websites', 'url'=>array('admin')),
);
?>

<h1>Create Websites</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>