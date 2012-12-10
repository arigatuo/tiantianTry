<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'item_id'); ?>
		<?php echo $form->textField($model,'item_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_text_id'); ?>
		<?php echo $form->textField($model,'comment_text_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'comment_text_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_head_id'); ?>
		<?php echo $form->textField($model,'comment_head_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'comment_head_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->