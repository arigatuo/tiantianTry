<?php
/* @var $this ProductController */
/* @var $data Product */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('productId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->productId), array('view', 'id'=>$data->productId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('productName')); ?>:</b>
	<?php echo CHtml::encode($data->productName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('productPrice')); ?>:</b>
	<?php echo CHtml::encode($data->productPrice); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('productDesc')); ?>:</b>
	<?php echo CHtml::encode($data->productDesc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('productPhoto')); ?>:</b>
	<?php echo CHtml::encode($data->productPhoto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('productAvaDays')); ?>:</b>
	<?php echo CHtml::encode($data->productAvaDays); ?>
	<br />


</div>