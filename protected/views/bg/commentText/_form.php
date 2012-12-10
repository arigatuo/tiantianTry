<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-text-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_text'); ?>
		<?php echo $form->textField($model,'comment_text',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'comment_text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->