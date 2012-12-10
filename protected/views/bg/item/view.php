<?php
$this->breadcrumbs=array(
	'Items'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>Yii::t('bg','List'), 'url'=>array('index')),
	array('label'=>Yii::t('bg','Create'), 'url'=>array('create')),
	array('label'=>Yii::t('bg','Update'), 'url'=>array('update', 'id'=>$model->item_id)),
	array('label'=>Yii::t('bg','Delete'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->item_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('bg','Manage'), 'url'=>array('admin')),
);
?>

<h1>View Item #<?php echo $model->item_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'item_id',
		'price',
		'special_price',
		'title',
		'endtime',
		'is_free',
		'category_id',
		'pieces',
		'description',
		'share_time',
		'fav_time',
		'already_buy',
		'photo',
		'is_top',
	),
)); ?>
