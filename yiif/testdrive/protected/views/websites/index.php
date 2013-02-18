<?php
/* @var $this WebsitesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Websites',
);

$this->menu=array(
	array('label'=>'Create Websites', 'url'=>array('create')),
	array('label'=>'Manage Websites', 'url'=>array('admin')),
);
?>

<h1>Websites</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
