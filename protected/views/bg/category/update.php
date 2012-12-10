<?php
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->category_id=>array('view','id'=>$model->category_id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('bg','List'), 'url'=>array('index')),
	array('label'=>Yii::t('bg','Create'), 'url'=>array('create')),
	array('label'=>Yii::t('bg','View'), 'url'=>array('view', 'id'=>$model->category_id)),
	array('label'=>Yii::t('bg','Manage'), 'url'=>array('admin')),
);
?>

<h1>Update Category <?php echo $model->category_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>