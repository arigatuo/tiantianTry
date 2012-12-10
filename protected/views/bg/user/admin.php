<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>Yii::t('bg','List'), 'url'=>array('index')),
	array('label'=>Yii::t('bg','Create'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'uid',
		//'openid',
		'nickname',
        array(
          'name' => 'ctime',
          'value' => 'date("Y-m-d H:i", $data->ctime)',
        ),
		'score',
        array(
          'name' => 'head',
          'value' => 'CHtml::image($data->head, $data->nickname)',
          'type' => 'raw',
        ),
		/*
		'share_time',
		'fav_time',
		'gender',
		'is_follow',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
