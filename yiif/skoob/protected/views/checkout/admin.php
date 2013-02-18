<?php
/* @var $this CheckoutController */
/* @var $model Checkout */

$this->breadcrumbs=array(
	'Checkouts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Checkout', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('checkout-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Checkouts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'checkout-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'sender_email_add',
		'promotion_code',
		'card_type_id',
		'card_holder_name',
		'credit_card_no',
		/*
		'expiry_date',
		'egift_id',
		'ins_dt',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
