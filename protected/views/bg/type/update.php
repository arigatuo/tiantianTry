<?php
$this->breadcrumbs=array(
	'Types'=>array('index'),
	$model->typeid=>array('view','id'=>$model->typeid),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('bg','List'), 'url'=>array('index')),
	array('label'=>Yii::t('bg','Create'), 'url'=>array('create')),
	array('label'=>Yii::t('bg','View'), 'url'=>array('view', 'id'=>$model->typeid)),
	array('label'=>Yii::t('bg','Manage'), 'url'=>array('admin')),
);
?>

<h1>Update Type <?php echo $model->typeid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>