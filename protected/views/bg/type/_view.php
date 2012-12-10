<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('typeid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->typeid), array('view', 'id'=>$data->typeid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('typename')); ?>:</b>
	<?php echo CHtml::encode($data->typename); ?>
	<br />


</div>