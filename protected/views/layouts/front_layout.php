<?php header('P3P: CP=CAO PSA OUR'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php
        $config = new CConfiguration();
        $config->loadFromFile("protected/config/qq_connect.php");
        $appId = $config->itemAt("appId");
        $baseUrl = Yii::app()->baseUrl."/";
        $actionId = Yii::app()->controller->action->id;
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <title>我要试用</title>
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/style/base.css?v=<?php echo date("YmdHi");?>">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/style/master.css?v=<?php echo date("YmdHi");?>">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/css/colorbox.css?v=<?php echo date("YmdHi");?>">
    <script src="http://www.lady8844.com/images/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->baseUrl;?>/js/tools.js?v=<?php echo date("YmdHi");?>" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8"  src="http://fusion.qq.com/fusion_loader?appid=<?php echo $appId?>&platform=qzone"> </script>
    <script type="text/javascript" src="<?php echo $baseUrl;?>js/jquery.colorbox-min.js"></script>
    <script type="text/javascript">
        <?php
            if(!empty($this->_userInfo['isFans'])){
               $_isFans = 1;
            }

            $newSession = new CHttpSession();
            $newSession->open();
            if(!empty($newSession['firstEnter']) && $newSession['firstEnter'] == 1){
               $_isFirstEnter = 1;
            }
        ?>

        var _isFans = <?php echo !empty($_isFans) ? 1 : 0?>;
        var _isFirstEnter = <?php echo !empty($_isFirstEnter) ? 1 : 0; ?>;
        var _isNoticed = 0;
        var _update = 0;
        var baseUrl = '<?php echo $baseUrl;?>';
        var serverTime = <?php echo time()*1000; ?>;
        var tools = {
            addFav : function(item_id){
                $.ajax({
                    type: "POST",
                    url: '<?php echo Yii::app()->createUrl("main/Ajax/AddTimes"); ?>',
                    data: { type : "fav_time", itemId:item_id },
                    success: function(msg){
                        if(parseInt(msg) > 0){
                            var numberSpan = $("#favNumber_"+item_id).find(".number").eq(0);
                            numberSpan.html(parseInt(numberSpan.html()) + 1);
                        }
                    }
                });
            },
            addShare : function(item_id){
                $.ajax({
                    type: "POST",
                    url: '<?php echo Yii::app()->createUrl("main/Ajax/AddTimes"); ?>',
                    data: { type : "share_time", itemId:item_id },
                    success: function(msg){
                        var numberSpan = $("#shareNumber_"+item_id).find(".number").eq(0);
                        numberSpan.html(parseInt(numberSpan.html()) + 1);
                    }
                });
            },
            favBox: function(event) {
                var obj = $(this);
                var xid = obj.attr("xid");

                //log
                appTools.clickLog(xid, 'fav');
                //tools.addFav(xid);
                tools.sendStory(xid, tools.addFav);
                /*
                fusion2.dialog.sendStory
                ({
                            title : content.title,
                            img: content.img,
                            summary : content.summary,
                            msg: content.msg,
                            //button :"获取能量",
                            context: content.context,
                            onSuccess : function (opt)
                            {
                                tools.addFav(xid);
                            }
                });
                */
            },
            //分享到内容
            shareContent:{
                title : '<?php echo $config->itemAt("dialog_title"); ?>',
                img: '<?php echo $config->itemAt("dialog_img");?>',
                summary : '<?php echo $config->itemAt("dialog_summary"); ?>',
                msg: '<?php echo $config->itemAt("dialog_msg"); ?>',
            //button :"获取能量",
                context: '<?php echo $config->itemAt('dialog_context'); ?>'
            },
            readImg : function(xid){
                var result = false;
                if(parseInt(xid) > 0){
                    result = jQuery("#itempic_"+xid).attr("src");
                }

                return result;
            },
            //qq分享
            sendStory : function(xid, succFunc, othxid){
                var content = tools.shareContent;
                var usedXid = (typeof othxid !== 'undefined') ? othxid : xid;
                var imgsrcResult = tools.readImg(usedXid);
                var imgsrc = imgsrcResult ? imgsrcResult : content.img;
                fusion2.dialog.sendStory
                        ({
                            title : content.title,
                            img: imgsrc,
                            summary : content.summary,
                            msg: content.msg,
                            //button :"获取能量",
                            context: content.context,
                            onSuccess : function (opt)
                            {
                                if(typeof xid != 'undefined' && typeof succFunc != 'undefined')
                                    succFunc(xid);
                            }
                        });
            },
            //qq邀请好友
            inviteFriend : function(xid, succFunc){
                    var content = tools.shareContent;
                    fusion2.dialog.invite
                        ({
                            msg  : content.msg,
                            img :  content.img,
                            onSuccess : function() {
                                if(typeof xid != 'undefined' && typeof succFunc != 'undefined')
                                    succFunc(xid);
                            }
                        });
            },

            attention_box:function(){
                $(".qzone").hide();
                $("#cur_iframe").removeAttr("id");
                var obj = $(this).find(".qzone").eq(0);obj.show();
                obj.find("iframe").attr("id","cur_iframe");
                iframeBind();
            },
            //分享
            shareBox : function(event){
                var obj = $(this);
                var xid = obj.attr("xid");

                //log
                appTools.clickLog(xid, 'share');
                //tools.sendStory(xid, tools.addShare);
                tools.inviteFriend(xid, tools.addShare);
            },
            trigger : function(the_type){
                if(the_type == "fav_time"){
                    jQuery.getJSON('<?php echo Yii::app()->createUrl("main/Ajax/updateTrigger");?>', {the_type:the_type}, function(data){ appTools.userAddGoldInJs(data.usergold)} );
                    appTools.showFloat(3);
                }else if(the_type == "share_time"){
                    jQuery.getJSON('<?php echo Yii::app()->createUrl("main/Ajax/updateTrigger");?>', {the_type:the_type}, function(data){ appTools.userAddGoldInJs(data.usergold)} );
                }
            },
            updateState: function(){
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl("main/Ajax/UpdateIsFans"); ?>',
                    success: function(msg){
                        if(parseInt(msg) == 1){
                            _isFans = 1;
                        }else{
                            floatAttention.showWindow();
                        }
                    }
                });
            },
            bindHover : function(){
                //解除关注框
                //$(".prolist .item").hover(tools.attention_box);
            }
        };
    </script>
</head>
<body>
<div class="wrap">
    <div class="logo-ad">
        <div class="logo"><a href="javascript:"><img src="<?php echo $baseUrl;?>images/logo.gif" width="165" height="39" title="天天试用"></a></div>
        <div class="ad"><!--<a href="javascript:tools.inviteFriend()"><img src="<?php echo $baseUrl;?>images/del_55073.jpg" width="550" height="73"></a>--></div>
    </div>
    <div class="nav-user">
        <ul class="nav">
            <?php
                $actionId = Yii::app()->controller->action->id;
            ?>
            <li class="<?php echo $actionId=="TryPageOne"?"current":"";?>"><a href="<?php echo Yii::app()->createUrl("main/index/TryPageOne");?>" >今日试用</a></li>
            <li class="<?php echo $actionId=="TryPageTwo"?"current":"";?>"><a  href="<?php echo Yii::app()->createUrl("main/index/TryPageTwo");?>">先到先抢</a><span class="hot"></span></li>
            <li class="user <?php echo $actionId=="UserCenter"?"current":"";?>"><a href="<?php echo Yii::app()->createUrl("main/index/UserCenter");?>">个人中心</a></li>
        </ul>
        <ul class="user">
            <?php
                $userCenterUrl = Yii::app()->createUrl("main/index/UserCenter");
            ?>
            <li class="newMess"><a href="<?php echo $userCenterUrl;?>">新信息(<span class="msgLeft"><?php echo $this->_userInfo['unread_msg_count'];?></span>)</a></li>
            <li class="yb"><a href="<?php echo $userCenterUrl;?>">元宝(<span class="user_gold"><?php echo $this->_userInfo['gold'];?></span>)</a></li>
            <li class="avatar"><a href="<?php echo $userCenterUrl;?>"><img src="<?php echo $this->_userInfo['head'];?>" width="32" height="32" alt="<?php echo $this->_userInfo['nickname'];?>"></a></li>
        </ul>
    </div>
    <?php
        if($actionId != "UserCenter"){
    ?>
    <div class="subnav">
        <dl class="categories">
            <dt><a href="<?php echo Yii::app()->createUrl("main/index/{$actionId}/");?>">全部</a></dt>
            <?php
                $allCategory = Category::model()->findAll();
                if(!empty($allCategory)){
                    foreach($allCategory as $category){
            ?>
                            <dd class="strong"><a href="<?php echo Yii::app()->createUrl("main/index/{$actionId}/", array('category_id'=>$category->category_id));?>" ><?php echo $category->category_name;?></a></dd>
           <?php
                    }
                }
            ?>
        </dl>
        <dl class="tool">
            <dt>工具栏:</dt>
            <dd class="timeMac <?php echo !empty($this->_userInfo['timeMachine'])? "": "notimeMac";?>"><a href="javascript:" class="timeMachineButton">时光机(<?php echo !empty($this->_userInfo['timeMachine']) ? $this->_userInfo['timeMachine'] : 0;?>)</a></dd>
            <dd class="disco <?php echo !empty($this->_userInfo['gotFirst']) ? "" : "nodisco";?>" <?php ?>><a href="javascript:" class="gotFirstButton">折扣到底<!--(<?php echo !empty($this->_userInfo['gotFirst']) ? $this->_userInfo['gotFirst'] : 0;?>)--></a></dd>
        </dl>
    </div>
    <div class="lingjiang">
        <?php
            $signDetail = Helper::loadAwardConfig("sign");
            $isSign = UserLoginRecord::isSignToday($this->_userInfo['userid']);
            $signButtonClass = $isSign ?  "b h" : "b m signButton" ;
        ?>
        <div class="fr">领 <span class="m"><?php echo !empty($signDetail['gold']) ? $signDetail['gold'] : 20; ?></span> 元宝 <a href="javascript:" class="<?php echo $signButtonClass;?>" id="isSign"><?php echo $isSign? "已":"";?>签到</a></div>
    </div>
    <?php
        }
    ?>

    <?php echo $content; ?>

<?php
        if(in_array($actionId,array( "TryPageOne"))){
?>
    <div class="rem"><img src="<?php echo $baseUrl;?>images/r.png" width="718" height="52"></div>
<?php   } ?>

    <div class="footer">
        <p class="w">客服QQ： 800078845　　　商务合作邮箱：bd@lady8844.com　　　&copy;爱美网 版权所有</p>
    </div>
</div>
<?php
    //弹窗
    $this->renderPartial("////common/popbox");
    $this->renderPartial("////common/float_attention");
?>
</body>
</html>
