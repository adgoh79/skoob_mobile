<?php
?>
<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'egift-form',
	'enableAjaxValidation'=>false,
	)); ?>
		<?php echo CHtml::hiddenField('id',$model->id); ?>
		<div class="boxed_summary">
			<div class="row">
				<label>Preview your eGift Card</label>
			</div>
			<div class="row">
			<span id="card_img">
				<img class="scale-with-grid" src="<?php echo Yii::app()->request->baseUrl.$model->gift_card_img ?>"/>
			</span>
			</div>
			<br/>
			<div class="row">
				<label>
					Gift Details:
				</label>
			</div>
			<div class="row">
				To:&nbsp;<font class="inline"><?php echo $model->recipient_name; ?></font>
			</div>
			<div class="row">
				Email:&nbsp;<font class="inline"><?php echo $model->recipient_email; ?></font>
			</div>
			<div class="row">
			From:&nbsp;<font class="inline"><?php echo $model->sender_name; ?></font>
			</div>
			<div class="row">
			Amount:&nbsp;<font class="inline"><?php echo Yii::app()->globaldef->CURRENCY_SYM.$model->amount; ?></font>
			</div>
			<div class="row">
			Delivery date:&nbsp;<font class="inline"><?php echo $model->delivery_date; ?></font>
			</div>
			<div class="row">
			Message:&nbsp;<font class="inline"><?php echo $model->message; ?></font>
			</div>
			
			
		</div>
		<div class="row buttons">
		<?php 
			//if(Yii::app()->detectMobileBrowser->getIsMobile())
				echo CHtml::submitButton('Ok, proceed to checkout',array('submit'=>array('proceed')));
			//else
				echo CHtml::Button('Wait, make further edits',array('submit'=>array('create')));
		?>
		</div>
	<?php $this->endWidget(); ?>
</div>