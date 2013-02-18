<?php
/* @var $this TblProjectController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tbl Projects',
);

$this->menu=array(
	array('label'=>'Create TblProject', 'url'=>array('create')),
	array('label'=>'Manage TblProject', 'url'=>array('admin')),
);
?>

<h1>Tbl Projects</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
