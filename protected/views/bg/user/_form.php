<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'openid'); ?>
		<?php echo $form->textField($model,'openid',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'openid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nickname'); ?>
		<?php echo $form->textField($model,'nickname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'nickname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ctime'); ?>
		<?php echo $form->textField($model,'ctime',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'ctime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'score'); ?>
		<?php echo $form->textField($model,'score',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'score'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'head'); ?>
		<?php echo $form->textField($model,'head',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'head'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'share_time'); ?>
		<?php echo $form->textField($model,'share_time',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'share_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fav_time'); ?>
		<?php echo $form->textField($model,'fav_time',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'fav_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->textField($model,'gender'); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_follow'); ?>
		<?php echo $form->textField($model,'is_follow'); ?>
		<?php echo $form->error($model,'is_follow'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->