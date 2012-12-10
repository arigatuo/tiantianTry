<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('item_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->item_id), array('view', 'id'=>$data->item_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('special_price')); ?>:</b>
	<?php echo CHtml::encode($data->special_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('endtime')); ?>:</b>
	<?php echo CHtml::encode($data->endtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_free')); ?>:</b>
	<?php echo CHtml::encode($data->is_free); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('pieces')); ?>:</b>
	<?php echo CHtml::encode($data->pieces); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('share_time')); ?>:</b>
	<?php echo CHtml::encode($data->share_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fav_time')); ?>:</b>
	<?php echo CHtml::encode($data->fav_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('already_buy')); ?>:</b>
	<?php echo CHtml::encode($data->already_buy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('photo')); ?>:</b>
	<?php echo CHtml::encode($data->photo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_top')); ?>:</b>
	<?php echo CHtml::encode($data->is_top); ?>
	<br />

	*/ ?>

</div>