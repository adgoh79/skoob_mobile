<?php
/* @var $this UserController */
/* @var $model User */

$hasAdminAccess=Yii::app()->user->checkAccess('admin');

$this->breadcrumbs=array(
	'Users'=>array('index'),
	//'Manage'=>array('user/admin'),
	$model->username=>array('view','id'=>$model->id),
	'Update',
);
$this->menu=array();
if($hasAdminAccess)
{
	$this->menu=array(
		array('label'=>'List User', 'url'=>array('index')),
		array('label'=>'Create User', 'url'=>array('create')),
		array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
		array('label'=>'Manage User', 'url'=>array('admin')),
	);
}

//checking for member, if the passed userid not equals user's own id
//throw 403 exception
	if( !$hasAdminAccess && Yii::app()->user->id != $model->id )
	{
		throw new CHttpException(403, 'You are not authorized to perform this action.');
	}

?>

<h1>Update User</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>