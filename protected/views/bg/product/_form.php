<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>
<script type="text/javascript">
    var preview_image = function(){
        jQuery('#Product_productPhoto').imgPreview({
            containerID: 'imgPreviewWithStyles',
            srcAttr:'value',
            imgCSS:{}
        });
    }
    <?php if(!empty($model->productPhoto)){
        echo "jQuery(function(){preview_image();})";
    }?>
</script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'productName'); ?>
		<?php echo $form->textField($model,'productName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'productName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'productPrice'); ?>
		<?php echo $form->textField($model,'productPrice',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'productPrice'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'productDesc'); ?>
		<?php echo $form->textField($model,'productDesc',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'productDesc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'productPhoto'); ?>
        <?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
        array(
            'id'=>'uploadpic',
            'config'=>array(
                'action'=>Yii::app()->createUrl('main/Ajax/Uploadimg'),
                'allowedExtensions'=>array("jpg", "jpeg", "gif"),//array("jpg","jpeg","gif","exe","mov" and etc...
                'sizeLimit'=>1*1024*1024,// maximum file size in bytes
                'onComplete'=>"js:function(id, fileName, responseJSON){
				                    photoUrl = baseUrl + '/' + responseJSON.folder+responseJSON .filename;
									jQuery('#Product_productPhoto').val(photoUrl);
									preview_image();
                                }",
            )
        ));
        ?>
		<?php echo $form->textField($model,'productPhoto',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'productPhoto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'productAvaDays'); ?>
		<?php echo $form->textField($model,'productAvaDays',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'productAvaDays'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->