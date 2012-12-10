<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->comment_id), array('view', 'id'=>$data->comment_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_id')); ?>:</b>
	<?php echo CHtml::encode($data->item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_text_id')); ?>:</b>
	<?php echo CHtml::encode($data->comment_text_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_head_id')); ?>:</b>
	<?php echo CHtml::encode($data->comment_head_id); ?>
	<br />


</div>