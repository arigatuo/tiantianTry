<?php
$this->breadcrumbs=array(
	'Types'=>array('index'),
	$model->typeid,
);

$this->menu=array(
	array('label'=>Yii::t('bg','List'), 'url'=>array('index')),
	array('label'=>Yii::t('bg','Create'), 'url'=>array('create')),
	array('label'=>Yii::t('bg','Update'), 'url'=>array('update', 'id'=>$model->typeid)),
	array('label'=>Yii::t('bg','Delete'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->typeid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('bg','Manage'), 'url'=>array('admin')),
);
?>

<h1>View Type #<?php echo $model->typeid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'typeid',
		'typename',
	),
)); ?>
