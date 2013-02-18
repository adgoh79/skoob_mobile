<?php
/* @var $this GiftCardController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Gift Cards',
);

$this->menu=array(
	array('label'=>'Create GiftCard', 'url'=>array('create')),
	array('label'=>'Manage GiftCard', 'url'=>array('admin')),
);
?>

<h1>Gift Cards</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
