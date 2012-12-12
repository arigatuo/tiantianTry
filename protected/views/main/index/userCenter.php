<?php
    $baseUrl = Yii::app()->baseUrl."/";
?>
<div class="userinfo">
    <div class="top">
        <div class="u"><a href="#" target="_blank" class="pic"><img src="<?php echo $this->_userInfo['head'];?>" width="50" height="50" alt="<?php echo $this->_userInfo['nickname'];?>"></a>
            <div class="txt">
                <div class="ybs">元宝数:<strong><span class="user_gold"><?php echo $this->_userInfo['gold'];?></span></strong></div>
                <div class="login">连续登陆:<strong><?php echo $this->_userInfo['loginRecord']['consistent'];?></strong> 天</div>
            </div>
        </div>
        <ul class="mod_list">
            <li>
                <div class="t">
                    <img src="<?php echo $baseUrl;?>images/<?php echo !empty($this->_userInfo['timeMachine']) ? 2 : 1;?>.gif" width="34" height="34" />
                    <a href="javascript:" class="use timeMachineButton <?php echo !empty($this->_userInfo['timeMachine']) ? "":"disable";?>">使用</a>
                </div>
                <div class="b"><strong>时光机</strong> ( <?php echo !empty($this->_userInfo['timeMachine']) ? "剩余天数：<i>{$this->_userInfo['timeMachine']}天</i>" : "请去商城购买";?> )
                </div>
            </li>
            <li>
                <div class="t">
                    <img src="<?php echo $baseUrl;?>images/<?php echo !empty($this->_userInfo['gotFirst'])  ? 3 : 4;?>.gif" width="34" height="34">
                    <a href="javascript:" class="use gotFirstButton <?php echo !empty($this->_userInfo['gotFirst']) ? "":"disable";?>">使用</a>
                </div>
                <div class="b"><strong>折扣到底</strong> (  <?php echo !empty($this->_userInfo['gotFirst']) ? "有效次数：<i>1次</i>" : "请去商城购买";?> )</div>
            </li>
        </ul>
    </div>
    <div class="bottom">
        <div class="bl">新信息<i>(<span class="msgLeft"><?php echo $this->_userInfo['unread_msg_count'];?></span>)</i><span class="new"></span></div>
        <div class="br" id="msgContainer"></div>
    </div>
</div>
<div class="shop">
    <h2 class="hd">兑兑乐商城</h2>
    <ul class="bd">
        <?php
        $toolsArray = Product::model()->findAll();
        if(!empty($toolsArray)){
            foreach($toolsArray as $tools){
                $toolsAttributes = $tools->getAttributes();
                ?>
                <li>
                    <img src="<?php echo $toolsAttributes['productPhoto'];?>"  width="70" height="76">
                    <div class="strong"><span class="left">元 宝：</span><span class="right"><?php echo $toolsAttributes['productPrice'];?></span></div>
                    <div class="yx"><span class="left">有效期：</span><span class="right"><?php echo $toolsAttributes['productAvaDays']?>天</span></div>
                    <div class="gn">功  能： <?php echo $toolsAttributes['productDesc'];?></div>
                    <a href="javascript:" productId="<?php echo $toolsAttributes['productId'];?>" title="购买" class="buy shoppingButton">购买</a>
                </li>
                <?php
            }
        }
        ?>
        <li class="more"> <img src="<?php echo $baseUrl;?>images/xl.gif" width="48" height="52">
            <p class="m">更多道具</p>
            <p class="l">稍后推出...</p>
        </li>
    </ul>
</div>
<div class="favorite">
    <h2 class="hd"><strong>我的收藏</strong> (保存最新的十条记录)</h2>
    <ul class="bd">
        <?php
        if(!empty($favArray)){
            foreach($favArray as $fav){
                $curHref = "javascript:appTools.openUrl('{$fav['attributes']['url']}')";
                ?>
                <li><a href="<?php echo $curHref;?>" class="pic"><img src="<?php echo $fav['attributes']['photo'];?>" width="50" height="50" alt="<?php echo $fav['attributes']['title'];?>"/></a> <a href="<?php echo $curHref;?>" class="txt"><?php echo Helper::truncate_utf8_string($fav['attributes']['title'], 30);?></a><!--<a href="javascript:void(0);" class="del">删除</a>--><a href="<?php echo $curHref;?>" class="gotobuy">购买</a></li>
                <?php
            }
        }
        ?>
    </ul>
</div>
<script type="text/javascript">
        appTools.getLatestMsg();
</script>
