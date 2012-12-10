<?php
$this->breadcrumbs=array(
	'Comment Heads'=>array('index'),
	$model->comment_head_id,
);

$this->menu=array(
	array('label'=>Yii::t('bg','List'), 'url'=>array('index')),
	array('label'=>Yii::t('bg','Create'), 'url'=>array('create')),
	array('label'=>Yii::t('bg','Update'), 'url'=>array('update', 'id'=>$model->comment_head_id)),
	array('label'=>Yii::t('bg','Delete'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->comment_head_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('bg','Manage'), 'url'=>array('admin')),
);
?>

<h1>View #<?php echo $model->comment_head_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'comment_head_id',
		'comment_head',
	),
)); ?>
