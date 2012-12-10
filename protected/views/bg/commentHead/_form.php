<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-head-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_head'); ?>
		<?php echo $form->textField($model,'comment_head',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'comment_head'); ?>
	</div>

    <div class="row">
        <?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
        array(
            'id'=>'uploadpic',
            'config'=>array(
                'action'=>Yii::app()->createUrl('main/Ajax/Uploadimg'),
                'allowedExtensions'=>array("jpg"),//array("jpg","jpeg","gif","exe","mov" and etc...
                'sizeLimit'=>1*1024*1024,// maximum file size in bytes
                'onComplete'=>"js:function(id, fileName, responseJSON){
                                    var picUrl = responseJSON.folder+responseJSON.filename;
									jQuery('#CommentHead_comment_head' ).val(picUrl);
									jQuery('#previewImg').attr('src',baseUrl + '/' + picUrl);
									jQuery('#previewImg').show();
                                }",
            )
        ));
        ?>
    </div>

    <div class="row">
        <img src="" style="display:none" id="previewImg" height="200"/>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->