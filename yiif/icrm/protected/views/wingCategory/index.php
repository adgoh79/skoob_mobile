<?php
/* @var $this WingCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Wing Categories',
);

$this->menu=array(
	array('label'=>'Create Wing Category', 'url'=>array('create')),
	array('label'=>'Manage Wing Category', 'url'=>array('admin')),
);
?>

<h1>Wing Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
