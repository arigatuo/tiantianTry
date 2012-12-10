<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_head_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->comment_head_id), array('view', 'id'=>$data->comment_head_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_head')); ?>:</b>
	<?php echo CHtml::encode($data->comment_head); ?>
	<br />


</div>