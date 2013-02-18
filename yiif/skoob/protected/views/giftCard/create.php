<?php
/* @var $this GiftCardController */
/* @var $model GiftCard */

$this->breadcrumbs=array(
	'Gift Cards'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage GiftCard', 'url'=>array('admin')),
);
?>

<h1>Create GiftCard</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>