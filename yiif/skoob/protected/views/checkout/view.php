<?php
/* @var $this CheckoutController */
/* @var $model Checkout */

$this->breadcrumbs=array(
	'Checkouts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Checkout', 'url'=>array('index')),
	array('label'=>'Create Checkout', 'url'=>array('create')),
	array('label'=>'Update Checkout', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Checkout', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Checkout', 'url'=>array('admin')),
);
?>

<h1>View Checkout #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sender_email_add',
		'promotion_code',
		'card_type_id',
		'card_holder_name',
		'credit_card_no',
		'expiry_date',
		'egift_id',
		'ins_dt',
	),
)); ?>
