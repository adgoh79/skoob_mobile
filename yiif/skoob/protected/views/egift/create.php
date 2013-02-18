<?php
/* @var $this EgiftController */
/* @var $model Egift */

/*
$this->menu=array(
	//array('label'=>'List Egift', 'url'=>array('index')),
	array('label'=>'Manage Egift', 'url'=>array('admin')),
);*/	

$this->side_content='<div class="boxed_summary">
		Your order summary:
		<hr/>
		<span id="card_img">';
			
		if(isset($model->gift_card_img) && $model->gift_card_img!="" )
		{
			$this->side_content.='<img src="'.Yii::app()->request->baseUrl.$model->gift_card_img.'" width="50%" height="50%"/>';
		}
		else
		{
			$this->side_content.='No card chosen';
		}
			
		$this->side_content.='</span>
		<br><br>
		skoob eGift card
		<hr/>
		Value: .'.Yii::app()->globaldef->CURRENCY_SYM.'<span id="card_val">';
		if(isset($model->amount) && $model->amount!="" )
		{
			$this->side_content.=$model->amount;
		}
		else
			$this->side_content.='0.00';

		$this->side_content.='</span></div>';

?>

<h1>Create Egift</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
