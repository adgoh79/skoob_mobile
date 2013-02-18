<?php
/* @var $this AreaOfInterestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Area Of Interest',
);

$this->menu=array(
	array('label'=>'Create Area Of Interest', 'url'=>array('create')),
	array('label'=>'Manage Area Of Interest', 'url'=>array('admin')),
);
?>

<h1>Area Of Interests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
