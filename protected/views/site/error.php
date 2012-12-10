<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>Error <?php echo $code; ?></h2>
<div class="error">
<?php echo CHtml::encode($message); ?>
<script type="text/javascript">
    var main_page = '<?php echo Yii::app()->createUrl("/"); ?>';
    setTimeout("location.href=main_page", 1000);
</script>
</div>