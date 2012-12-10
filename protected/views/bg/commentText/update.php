<?php
$this->breadcrumbs=array(
	'Comment Texts'=>array('index'),
	$model->comment_text_id=>array('view','id'=>$model->comment_text_id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('bg','List'), 'url'=>array('index')),
	array('label'=>Yii::t('bg','Create'), 'url'=>array('create')),
	array('label'=>Yii::t('bg','View'), 'url'=>array('view', 'id'=>$model->comment_text_id)),
	array('label'=>Yii::t('bg','Manage'), 'url'=>array('admin')),
);
?>

<h1>Update <?php echo $model->comment_text_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>