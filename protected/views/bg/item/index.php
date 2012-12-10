<?php
$this->breadcrumbs=array(
	'Items',
);

$this->menu=array(
	array('label'=>Yii::t('bg','Create'), 'url'=>array('create')),
	array('label'=>Yii::t('bg','Manage'), 'url'=>array('admin')),
);
?>

<h1>Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
