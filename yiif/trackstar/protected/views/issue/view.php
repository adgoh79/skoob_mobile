<?php
/* @var $this IssueController */
/* @var $model Issue */

$this->breadcrumbs=array(
	'Issues'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Issue', 'url'=>array('index', 'pid'=>$model->project->id)),
	array('label'=>'Create Issue', 'url'=>array('create','pid'=>$model->project->id)),
	//array('label'=>'List Issue', 'url'=>array('index')),
	//array('label'=>'Create Issue', 'url'=>array('create')),
	array('label'=>'Update Issue', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Issue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage Issue', 'url'=>array('admin')),
	array('label'=>'Manage Issue', 'url'=>array('admin', 'pid'=>$model->project->id)),
	array('label'=>'Create Issue', 'url'=>array('issue/create','pid'=>$model->id)),
);
?>

<h1>View Issue #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'project_id',
		//'type_id',
		array(
		'name'=>'type_id',
		'value'=>CHtml::encode($model->getTypeText())
		),
		//'status_id',
		array(
		'name'=>'status_id',
		'value'=>CHtml::encode($model->getStatusText())
		),
		
		//'owner_id',
		//'requester_id',
		array(
		'name'=>'owner_id',
		'value'=>CHtml::encode($model->owner->username)
		),
		array(
		'name'=>'requester_id',
		'value'=>CHtml::encode($model->requester->username)
		),
		/*
		'create_time',
		'create_user_id',
		'update_time',
		'update_user_id',*/
	),
)); ?>
