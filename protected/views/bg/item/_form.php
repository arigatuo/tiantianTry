<div class="form">
<style>
    .qq-upload-success{display:none}
</style>
<script type="text/javascript">
    var preview_image = function(){
        jQuery('#Item_photo').imgPreview({
            containerID: 'imgPreviewWithStyles',
            srcAttr:'value',
            imgCSS:{}
        });
    }
    <?php if(!empty($model->photo)){
        echo "jQuery(function(){preview_image();})";
    }?>
</script>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'url'); ?>
        <?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'url'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'photo'); ?>
        <?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
				array(
				        'id'=>'uploadpic',
				        'config'=>array(
				               'action'=>Yii::app()->createUrl('main/Ajax/Uploadimg'),
				               'allowedExtensions'=>array("jpg"),//array("jpg","jpeg","gif","exe","mov" and etc...
				               'sizeLimit'=>1*1024*1024,// maximum file size in bytes
				               'onComplete'=>"js:function(id, fileName, responseJSON){
				                    photoUrl = baseUrl + '/' + responseJSON.folder+responseJSON .filename;
									jQuery('#Item_photo').val(photoUrl);
									jQuery('#adPic').attr('src', photoUrl);
									jQuery('#adPic').show();
									preview_image();
                                }",
				              )
				));
		?>
        <?php echo $form->textField($model,'photo',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'photo'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'category_id'); ?>
        <?php //echo $form->textField($model,'category_id',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo CHtml::dropDownList('Item[category_id]', $model->category_id, CHtml::listData(Category::model()->findAll(), 'category_id', 'category_name') ); ?>
        <?php echo $form->error($model,'category_id'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'type_id'); ?>
        <?php //echo $form->textField($model,'category_id',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo CHtml::dropDownList('Item[type_id]', $model->type_id, CHtml::listData(Type::model()->findAll(), 'typeid', 'typename') ); ?>
        <?php echo $form->error($model,'type_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'is_top'); ?>
        <?php //echo $form->textField($model,'is_top'); ?>
        <?php echo CHtml::dropDownList('Item[is_top]', $model->is_top, array('1'=>'是', '0'=>'否') ); ?>
        <?php echo $form->error($model,'is_top'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'free_trans'); ?>
        <?php echo CHtml::dropDownList('Item[free_trans]', $model->free_trans, array(0=>'不包邮', 1=>'包邮') );?>
        <?php echo $form->error($model,'free_trans'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'special_price'); ?>
		<?php echo $form->textField($model,'special_price'); ?>
		<?php echo $form->error($model,'special_price'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'endtime'); ?>
		<?php /*echo $form->textField($model,'endtime',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'endtime'); */ ?>
        <?php
            $this->widget('ext.timepicker.timepicker',
                array(
                    'model'=> $model,
                    'name' => 'endtime',
                    'options' => array(
                    ),
                )
            );
        ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'fixDate'); ?>
        <?php
        $this->widget('ext.timepicker.timepicker',
            array(
                'model'=> $model,
                'name' => 'fixDate',
                'options' => array(
                    'dateFormat'=>'yy-mm-dd',
                    'showSecond'=>false,
                ),
            )
        );
        ?>
    </div>

	<div class="row">
		<?php //echo $form->labelEx($model,'is_free'); ?>
		<?php //echo $form->textField($model,'is_free',array('size'=>1,'maxlength'=>1)); ?>
        <?php //echo CHtml::dropDownList('Item[is_free]', $model->is_free, array('1'=>'是', '0'=>'否') ); ?>
		<?php //echo $form->error($model,'is_free'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pieces'); ?>
		<?php echo $form->textField($model,'pieces',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'pieces'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'already_buy'); ?>
        <?php echo $form->textField($model,'already_buy',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo $form->error($model,'already_buy'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
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


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->