<h1>公告消息</h1>
<form action="<?php echo Yii::app()->createUrl("/bg/Sendmsg/msgset")?>" method="post">
    <input type="text" name="msgContent" />
    <input type="hidden" name="sureSubmit" value="1" />
    <input type="submit" />
</form>