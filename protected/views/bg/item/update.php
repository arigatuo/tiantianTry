<?php
$this->breadcrumbs=array(
	'Items'=>array('index'),
	$model->title=>array('view','id'=>$model->item_id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('bg','List'), 'url'=>array('index')),
	array('label'=>Yii::t('bg','Create'), 'url'=>array('create')),
	array('label'=>Yii::t('bg','View'), 'url'=>array('view', 'id'=>$model->item_id)),
	array('label'=>Yii::t('bg','Manage'), 'url'=>array('admin')),
);
?>

<h1>Update Item <?php echo $model->item_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>