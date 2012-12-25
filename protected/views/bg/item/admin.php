<?php
$this->breadcrumbs=array(
	'Items'=>array('index'),
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
	$.fn.yiiGridView.update('item-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--
<h1>Manage Items</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php /* echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); */ ?>

</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'ajaxUpdate'=>false,
	'columns'=>array(
		'item_id',
		'title',
        'price',
        'special_price',
        array(
          'name' => 'category_id',
          'value' => 'Category::returnCategoryName($data->category_id)',
          'filter' => CHtml::listData(Category::model()->findAll(), 'category_id', 'category_name'),
        ),
        array(
          'name' => 'type_id',
          'value' => 'Type::model()->findByPk($data->type_id)->getAttribute("typename")',
          'filter'=>CHtml::listData(Type::model()->findAll(),'typeid','typename'),
        ),
        /*
        array(
          'name' => 'is_free',
          'value' => ' $data->is_free ? "是" : "否" ',
        ),
        */
        array(
          'name' => 'photo',
          'value' => 'CHtml::image($data->photo, $data->title, array("width"=>"100px", "height"=>"100px"))',
          'type' => 'raw',
        ),
		/*
		'category_id',
		'pieces',
		'description',
		'share_time',
		'fav_time',
		'already_buy',
		'is_top',
		*/
        //'endtime',
        array(
            'name' => 'endtime',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'=>$model,
                'attribute'=>'endtime',
                'language' => 'en',
                'i18nScriptFile' => 'jquery.ui.datepicker-en.js', // (#2)
                'htmlOptions' => array(
                    'id' => 'datepicker_for_due_date',
                    'size' => '10',
                ),
                'defaultOptions' => array(  // (#3)
                    'showOn' => 'focus',
                    'dateFormat' => 'yy/mm/dd',
                    'showOtherMonths' => true,
                    'selectOtherMonths' => true,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'showButtonPanel' => true,
                )
            ),true),
        ),
        'fixDate',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
