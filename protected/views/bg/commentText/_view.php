<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_text_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->comment_text_id), array('view', 'id'=>$data->comment_text_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_text')); ?>:</b>
	<?php echo CHtml::encode($data->comment_text); ?>
	<br />


</div>