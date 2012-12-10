<?php
$this->breadcrumbs=array(
	'Comment Heads'=>array('index'),
	$model->comment_head_id=>array('view','id'=>$model->comment_head_id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('bg','List'), 'url'=>array('index')),
	array('label'=>Yii::t('bg','Create'), 'url'=>array('create')),
	array('label'=>Yii::t('bg','View'), 'url'=>array('view', 'id'=>$model->comment_head_id)),
	array('label'=>Yii::t('bg','Manage'), 'url'=>array('admin')),
);
?>

<h1>Update CommentHead <?php echo $model->comment_head_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>