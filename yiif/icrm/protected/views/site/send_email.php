<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Send Email';
$this->breadcrumbs=array(
	'Send Email',

	);

	$baseURL=Yii::app()->baseUrl;
	Yii::app()->clientScript->registerScriptFile(
		$baseURL.'/js/general.js'
	);

?>
<script type="text/javascript">
    //alert('my script');
	function popData()
	{
		//alert('my script');
		var emailElem = document.getElementById("email_content");
		var elemInput = document.getElementById("SendEmailForm_email_content");
		//elemInput.value=emailElem.value;
		//console.log('vals'+elemInput.value);
		var myIFrame = document.getElementById('xhe0_iframe');
		var content = myIFrame.contentWindow.document.body.innerHTML;
		//assign wysiwyg content to hidden element
		elemInput.value=content;
		
	}
</script>


<h1>Send Email</h1>

<?php if(Yii::app()->user->hasFlash('send_email')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('send_email'); ?>
</div>

<?php else: ?>

<p>
This page will enable you to send emails to users from different groups
</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); 

?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->labelEx($model,'member_types'); ?>
	<div class="member_types">
	<?php echo $form->checkboxList($model,'member_types', $model->getMemberCategoryOpt(),
		array('template'=>'{input}&nbsp;{label}','labelOptions'=>array('style'=>'display:inline'),'class'=>'member_types')); ?>
	<?php echo $form->error($model,'member_types').'<br><br>'; ?>
	</div>
	<?php echo $form->checkBox($model,'filter_wing_category',  array('class'=>'filter_wing'));  ?>
	<?php echo $form->labelEx($model,'filter_wing_category',array('style'=>'display:inline')); ?>
	<?php echo "<br>".'(Tick this checkbox to add filtering by wing category)'."<br><br>";
				
	?>		
	
	<div class="crow">
		
	
		<?php echo $form->labelEx($model,'wing_category'); ?>
		<?php
			$wcs=WingCategory::model()->findAll();
			//add ALL option to the front
			$obj=new WingCategory;
			$obj->attributes=array('id'=>'0','name'=>'All Wing Categories');
			array_unshift($wcs, $obj);
			
			$i=0;
			foreach($wcs as $wc)
			{
				//hack to indicate first value as 0
				$ident=($i==0)?$i:$wc->id;
				
				echo '<input id="SendEmailForm_wing_category_'.$i.'" value="'.$ident.'" type="checkbox" name="SendEmailForm[wing_category][]"  class="checkall_'.$wc['name'].'" >'
				.'&nbsp;'.$form->labelEx($wc,$wc['name'],array('style'=>'display:inline'))."<br>"
				;
				$i++;
				
				$subs=WingSubCategory::model()->findAllByAttributes(array('wing_category_id'=>$wc->id));
				
				
				$j=0;
				foreach($subs as $sub)
				{
					echo '<input style="margin-left: 20px;" id="SendEmailForm_wing_subcategory_'.$j.'" value="'.$sub->id.'" type="checkbox" name="SendEmailForm[wing_subcategory][]" class="checkall_'.$wc['name'].'_subcat" >'
					.'&nbsp;'.$form->labelEx($sub,$sub['name'],array('style'=>'display:inline'))."<br>"
					;	
					$j++;
				}
			
			}
		?>
		
		<?php echo $form->error($model,'wing_category'); ?>
	
	</div>
	<br/>
	<?php echo $form->checkBox($model,'filter_area_of_interest',  array('class'=>'filter_interest'));  ?>
	<?php echo $form->labelEx($model,'filter_area_of_interest',array('style'=>'display:inline')); ?>
	
	<?php echo "<br>".'(Tick this checkbox to add filtering by area of interest)'."<br><br>";	?>		

	<div class="crow_1" >
		<?php echo $form->labelEx($model,'area_of_interest'); ?>
		<?php echo $form->checkboxList($model,'area_of_interest', $model->getAreaOfInterest(),
		array('template'=>'{input}&nbsp;{label}','labelOptions'=>array('style'=>'display:inline'),'class'=>'checkall_area_of_interest')); ?>
		<?php echo $form->error($model,'area_of_interest'); ?>
	
	</div>
	<br/>
	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>80,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model,'email_content'); ?>
		<?php echo $form->hiddenField($model,'email_content'); ?>
	<?php
		
		//add widget for wysiwyg editor
		$this->widget('ext.widgets.xheditor.XHeditor',array(
		'model'=>$model,
		'language'=>'en', // en, zh-cn, zh-tw, ru
		'showModelAttributeValue'=>true, // defaults to true, displays the value of $modelInstance->attribute in the textarea
		'config'=>array(
			'id'=>'email_content',
			'name'=>'email_content',
			'skin'=>'o2007silver', // default, nostyle, o2007blue, o2007silver, vista
			'tools'=>'full', // mini, simple, mfull, full or from XHeditor::$_tools, tool names are case sensitive
			'width'=>'100%',
			//see XHeditor::$_configurableAttributes for more
		),
		'contentValue'=>'', // default value displayed in textarea/wysiwyg editor field
		'htmlOptions'=>array('rows'=>5, 'cols'=>10), // to be applied to textarea
		));
	?>
		<?php echo $form->error($model,'email_content'); ?>
	</div>
		

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit',array('onclick'=>'popData()')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>