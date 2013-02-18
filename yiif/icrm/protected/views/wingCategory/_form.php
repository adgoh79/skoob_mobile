<?php
/* @var $this WingCategoryController */
/* @var $model WingCategory */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'wing-category-form',
	'enableAjaxValidation'=>false,
)); 

	$baseURL=Yii::app()->baseUrl;
	Yii::app()->clientScript->registerScriptFile(
		$baseURL.'/js/jquery.format.js'
	);
	
	Yii::app()->clientScript->registerScriptFile(
		$baseURL.'/js/template.js'
	);

?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="complex">
        <span class="label">
            <?php echo Yii::t('ui', 'Sub Category'); ?>
        </span>
     
		<div class="panel">
			<table class="templateFrame grid" cellspacing="0">
				<thead class="templateHead" style="display: none;">
					<tr>
						<td>
							<?php echo $form->labelEx(WingSubCategory::model(),'name');?>
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
										<?php echo '<input id="WingCategory_subcategory_name_{0}" name="WingCategory[subcategory_name][]" style="width:300px;"></input>'; ?>

                                    </td>
									<td>
										<div class="remove"><?php echo Yii::t('ui','Remove');?>
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
					if(isset($model->subcategories))
					foreach($model->subcategories as $subcategory): 
					
				?>
                    <tr class="templateContent">
                        <td>
						<?php echo '<input id="WingCategory_subcategory_name_'.$i.'" name="WingCategory[subcategory_name][]" value="'.$subcategory['subcategory_name'].'" style="width:300px;"></input>'; ?>
                            
                        </td>
                        
                        <td>
                            <div class="remove"><?php echo Yii::t('ui','Remove');?>
                        </td>
                    </tr>
                <?php $i++;	endforeach; ?>
                </tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<?php //echo $form->labelEx($model,'create_dt'); ?>
		<?php //echo $form->textField($model,'create_dt'); ?>
		<?php //echo $form->error($model,'create_dt'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'create_user_id'); ?>
		<?php //echo $form->textField($model,'create_user_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php //echo $form->error($model,'create_user_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'update_dt'); ?>
		<?php //echo $form->textField($model,'update_dt'); ?>
		<?php //echo $form->error($model,'update_dt'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'update_user_id'); ?>
		<?php //echo $form->textField($model,'update_user_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php //echo $form->error($model,'update_user_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		<?php echo CHtml::Button('Cancel',array('submit'=>array('cancel')));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->