<?php
/* @var $this EgiftController */
/* @var $model Egift */
/* @var $form CActiveForm */
	
?>
	<!-- have to be here. if placed in main page, it will clash with jquery of yii -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.1_8_2.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquerypp.custom.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.elastislide.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/general.js"></script>
	
<script language="javascript">
  $(document).ready(function(){ 
		//ensure user does not copy and paste
		$('#Egift_recipient_email_repeat').bind('paste', function(e){ 
			alert('Copy and pasting is not allowed. Please re-type the email address.');
			return false;
		});
		$('#Egift_recipient_email').bind('paste', function(e){ 
			alert('Copy and pasting is not allowed. Please re-type the email address.');
			return false;
		});
		
		//portion to check text area remaining words - START
		
		maxLength = $("textarea#Egift_message").attr("maxlength");
        $("textarea#Egift_message").after("<div><span id='remainingLengthTempId'>" 
                  + maxLength + "</span> remaining</div>");
		
		//on load if textarea is not empty, do check
		if($("textarea#Egift_message").val().length>0)
		{
			checkMaxLength('Egift_message',maxLength);	
		}
		
        $("textarea#Egift_message").bind("keyup change", function(){checkMaxLength(this.id,  maxLength); } )
		
		function checkMaxLength(textareaID, maxLength){
 
			currentLengthInTextarea = $("#"+textareaID).val().length;
			$(remainingLengthTempId).text(parseInt(maxLength) - parseInt(currentLengthInTextarea));
	 
			if (currentLengthInTextarea > (maxLength)) { 
	 
				// Trim the field current length over the maxlength.
				$("textarea#Egift_message").val($("textarea#Egift_message").val().slice(0, maxLength));
				$(remainingLengthTempId).text(0);
	 
			}
		}
		//end of portion to check text area remaining words
		
		//carousel jquery codes
		//$( '#carousel' ).elastislide();
		var defaultItems=3;
		if(jQuery.browser.mobile)
			defaultItems=1;
		$( '#carousel' ).elastislide({
			onClick : function( el, pos, evt ) {
				changeImage( el, pos );
				
				evt.preventDefault();
			},
			minItems : defaultItems,
		});
		
		function changeImage( el, pos ) {
				$carouselEl = $( '#carousel' );
				$carouselItems = $carouselEl.children();
				
				$carouselItems.removeClass( 'current-img' );
				el.addClass( 'current-img' );
				//get the image src
				var chosen = el.find('img:first').attr('src');
				$('#card_img').html('<img src="'+chosen+'" width="50%" height="50%"></img>');
				//carousel.setCurrent( pos );
				//set hidden field for current chosen card
				$('#Egift_gift_card_id').val(el.attr('id'));

		}
		
		$('#Egift_amount_opts').change(function() {
			//populate value
			var selOpt=$("#Egift_amount_opts").val();
			if(selOpt==0)
			{
				$('#card_val').text('0.00');
			}
			else
			{
				var amt=$("#Egift_amount_opts option:selected").text();
				$('#card_val').text(amt);
				$('#Egift_amount').val(amt);
			}
		});
		


  });
  </script>
  
<div class="form">


	
	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'egift-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php   
		foreach(Yii::app()->user->getFlashes() as $key => $message) {
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
		}
	?>
	<ul id="carousel" class="elastislide-list">
		<?php 
			$gift_cards=$model->gift_cards;
			if(isset($gift_cards))
			{
				foreach($gift_cards as $gc)
				{
					echo '<li id="'.$gc->id.'" >'
						.'<a href="javascript:void(0);"><img src="'.Yii::app()->request->baseUrl.$gc->img_url.'" alt="egift card image"></a></li>';
						
				}
			}
		?>		
		
	</ul>
	
	<?php echo $form->hiddenField($model, 'gift_card_id') ; ?>
	<?php echo $form->hiddenField($model, 'amount') ; ?>
	<?php echo $form->hiddenField($model, 'id'); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->dropDownList($model,'amount_opts', $model->getAmtOptions(),array('options'=> array($model->getSelectedAmtId()=>array('selected'=>true)))); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	
	<div class="row">
		<?php echo $form->labelEx($model,'recipient_email'); ?>
		<?php echo $form->textField($model,'recipient_email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'recipient_email'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'recipient_email_repeat'); ?>
		<?php echo $form->textField($model,'recipient_email_repeat',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'recipient_email_repeat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recipient_name'); ?>
		<?php echo $form->textField($model,'recipient_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'recipient_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sender_name'); ?>
		<?php echo $form->textField($model,'sender_name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'sender_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		
		<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'delivery_date'); ?>
		
		<?php
			$img=Yii::app()->baseUrl;
			
			if(Yii::app()->detectMobileBrowser->getIsMobile())
				$img.='/images/common/calendar.gif';
			else
				$img.='/images/common/calendar_small.gif';
		
			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'delivery_date',
			'options' => array(
				
				'dateFormat' => 'yy-mm-dd',
				'showOn' => 'both',
				'buttonImage' => $img,
				 'buttonImageOnly' => true,
				'showButtonPanel' => true,
			),
			'htmlOptions' => array(
				'class'=>'custom-datetext',
				'size' => '10',         // textField size
				'maxlength' => '10',    // textField maxlength
			),
		));
		?>
		<?php echo $form->error($model,'delivery_date'); ?>
	</div>

	<div class="row buttons">
		
		<?php 
			if(Yii::app()->detectMobileBrowser->getIsMobile())
				
				echo CHtml::submitButton('Preview and proceed to next step',array('submit'=>'preview','name'=>'preview'));
			else
				echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');
		?>
	</div>
	
<?php $this->endWidget(); ?>
</div><!-- form -->
