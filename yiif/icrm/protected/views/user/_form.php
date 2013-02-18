<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); 
	$hasAdminAccess=Yii::app()->user->checkAccess('admin');
	$baseURL=Yii::app()->baseUrl;
	Yii::app()->clientScript->registerScriptFile(
		$baseURL.'/js/jquery.format.js'
	);
	
	Yii::app()->clientScript->registerScriptFile(
		$baseURL.'/js/template.js'
	);
	
	Yii::app()->clientScript->registerScriptFile(
		$baseURL.'/js/general.js'
	);

?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password')?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); 
		
		?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div class="row">
	<?php echo $form->label($model,'password_repeat'); ?>
	<?php echo $form->passwordField($model,'password_repeat',array('size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->error($model,'password_repeat'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'sex'); ?>
		<?php echo $form->dropDownList($model,'sex', $model->getSexTypeOptions()); ?>
		<?php echo $form->error($model,'sex'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>100,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>
	<div class="dob">
		<?php echo $form->labelEx($model,'dob') .' Please enter in (dd-mm-yyyy) format'; 
		?>
		<br/>
		<?php echo $form->textField($model,'dob',array('size'=>60,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'dob'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'nationality'); ?>
		<?php echo $form->textField($model,'nationality',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'nationality'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'marital_status'); ?>
		<?php echo $form->dropDownList($model,'marital_status', $model->getMaritalStatusOpt()); ?>
		<?php echo $form->error($model,'marital_status'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'spouse_name'); ?>
		<?php echo $form->textField($model,'spouse_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'spouse_name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'spouse_gender'); ?>
		<?php echo $form->dropDownList($model,'spouse_gender', $model->getOptSexTypeOptions()); ?>
		<?php echo $form->error($model,'spouse_gender'); ?>
	</div>
	 <div class="complex">
        <span class="label">
            <?php echo Yii::t('ui', 'Children Particulars'); ?>
        </span>
        <div class="panel">
            <table class="templateFrame grid" cellspacing="0">
                <thead class="templateHead" style="display: none;">
                    <tr>
                        <td>
                            <?php echo $form->labelEx(Child::model(),'first_name');?>
                        </td>
                        <td>
                            <?php echo $form->labelEx(Child::model(),'last_name');?>
                        </td>
                        <td colspan="2">
                            <?php echo $form->labelEx(Child::model(),'dob');?>
                        </td>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <div class="add"><?php echo Yii::t('ui','New');?></div>
                            <textarea class="template" rows="0" cols="0">
                                <tr class="templateContent">
                                    <td>
										<?php echo '<input id="User_child_first_name_{0}" name="User[child_first_name][]" style="width:100px;"></input>'; ?>

                                    </td>
                                    <td>
										<?php echo '<input id="User_child_last_name_{0}" name="User[child_last_name][]" style="width:100px;"></input>'; ?>
                                        
                                    </td>
                                    <td>
										<?php echo '<input id="User_child_dob_{0}" name="User[child_dob][]" style="width:100px;"></input>'; ?>
                                        
                                    </td>
                                    <td>
                                        <div class="remove"><?php echo Yii::t('ui','Remove');?></div>
                                        <input type="hidden" class="rowIndex" value="{0}" />
                                    </td>
                                </tr>
                            </textarea>
                        </td>
                    </tr>
                </tfoot>
                <tbody class="templateTarget">
                <?php 
					//$model->getChildren($model->id);
					$i=0;
					foreach($model->children as $child): 
					
				?>
                    <tr class="templateContent">
                        <td>
						<?php echo '<input id="User_child_first_name_'.$i.'" name="User[child_first_name][]" value="'.$child['child_first_name'].'" style="width:100px;"></input>'; ?>
                            <?php //echo $form->textField($child,"[$i]child_first_name",array('style'=>'width:100px')); ?>
                        </td>
                        <td>
							<?php echo '<input id="User_child_last_name_'.$i.'" name="User[child_last_name][]" value="'.$child['child_last_name'].'" style="width:100px;"></input>'; ?>
                            <?php //echo $form->textField($child,"[$i]child_last_name",array('style'=>'width:100px')); ?>
                        </td>
                        <td>
							<?php echo '<input id="User_child_dob_'.$i.'" name="User[child_dob][]" value="'.$child['child_dob'].'" style="width:100px;"></input>'; ?>
                            <?php //echo $form->textField($child,"[$i]child_dob",array('style'=>'width:100px')); ?>
                        </td>
                        <td>
                            <div class="remove"><?php echo Yii::t('ui','Remove');?>
                        </td>
                    </tr>
                <?php $i++;	endforeach; ?>
                </tbody>
            </table>
        </div><!--panel-->
    </div><!--complex-->
	<div class="row">
		<?php echo $form->labelEx($model,'residential_number'); ?>
		<?php echo $form->textField($model,'residential_number',array('size'=>60,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'residential_number'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'mobile_phone'); ?>
		<?php echo $form->textField($model,'mobile_phone',array('size'=>60,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'mobile_phone'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'work_phone'); ?>
		<?php echo $form->textField($model,'work_phone',array('size'=>60,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'work_phone'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'fax_number'); ?>
		<?php echo $form->textField($model,'fax_number',array('size'=>60,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'fax_number'); ?>
	</div>
	<?php if($hasAdminAccess) { ?>
	<div class="row">
		<?php echo $form->labelEx($model,'member_type'); ?>
		<?php echo $form->dropDownList($model,'member_type', $model->getMemberTypeOptions()); ?>
		<?php echo $form->error($model,'member_type'); ?>
	</div>
	<?php } ?>
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	
	<?php if($hasAdminAccess) { ?>
	<div class="crow">
		<?php echo $form->labelEx($model,'wing_category'); ?>
		<br/>
		     
		<?php 
			
			$wcs=WingCategory::model()->findAll();
			if(!$model->isNewRecord)
			{
				$ua=$model->getUserWingCat();
			
				$usa=$model->getUserWingSubCat();
			}
			$i=0;
			
			foreach($wcs as $wc)
			{
				
				if(isset($ua) && in_array($wc->id,$ua))
					$checked_str='checked="checked"';
				else
					$checked_str='';
				echo '<input id="User_wing_category_'.$i.'" value="'.$wc->id.'" type="checkbox" name="User[wing_category][]" '.$checked_str.' class="checkall_'.$wc['name'].'" >'
				.'&nbsp;'.$form->labelEx($wc,$wc['name'],array('style'=>'display:inline'))."<br>"
				;
				
				$subs=WingSubCategory::model()->findAllByAttributes(array('wing_category_id'=>$wc->id));
				$j=0;	
				//Yii::log('going to tfind '.sizeof($subs),'info','asdaasd');
				foreach($subs as $sub)
				{
					if(isset($usa) && in_array($sub->id,$usa))
						$checked_str='checked="checked"';
					else
						$checked_str='';
				
				//Yii::log('the sub id==='.$sub->id,'info','asdaasd');
					echo '<input style="margin-left: 20px;" id="User_wing_subcategory_'.$j.'" value="'.$sub->id.'" type="checkbox" name="User[wing_subcategory][]" '.$checked_str.' class="checkall_'.$wc['name'].'_subcat" >'
					.'&nbsp;'.$form->labelEx($sub,$sub['name'],array('style'=>'display:inline'))."<br>"				;	
					$j++;
				}
				//echo $form->checkBox($model,"wing_category",Chtml::listData($wc,'id','name'))
				//.'&nbsp;'.$form->labelEx($wc,$wc['name'],array('style'=>'display:inline'))."<br>";
				
				$i++;
			}
		?>
		
	</div>
	<br/>
	
	<div class="crow">
		<?php echo $form->labelEx($model,'area_of_interest'); ?>
		<br/>
		<?php 
		
		
		echo $form->checkBoxList($model,'area_of_interest',Chtml::listData(AreaOfInterest::model()->findAll(),'id','name'),
		array('template'=>'{input}&nbsp;{label}','labelOptions'=>array('style'=>'display:inline'))); 
		
		?>
		<?php echo $form->error($model,'area_of_interest'); ?>
	</div>
	
	<br/>
	<div class="row">
		<?php echo $form->labelEx($model,'user_role'); ?>
		<?php echo $form->dropDownList($model,'user_role', $model->getUserRoleOptions()); ?>
		<?php echo $form->error($model,'user_role'); ?>
	</div>
	<?php } ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		<?php echo CHtml::Button('Cancel',array('submit'=>array('cancel')));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->