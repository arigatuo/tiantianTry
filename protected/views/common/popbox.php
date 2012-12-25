<div class="nodisplay">
    <div id="overlay1">
        <div class="overlay overlay1">
            <div class="w">
                <div class="cbd close">
                    <span class="close" title="关闭"></span>
                    <a href="javascript:void(0)" title="确认"></a></div>
                <div class="opacitylay"></div>
            </div>
        </div>
    </div>



    <div id="overlay2">
        <div class="overlay overlay2">
            <div class="w">
                <div class="cbd">
                    <span class="close" title="关闭"></span>
                    <a href="javascript:tools.inviteFriend('fav_time', tools.trigger);jQuery.colorbox.close();" title="邀请好友赚100元宝"></a></div>
                <div class="opacitylay"></div>
            </div>
        </div>
    </div>

    <div id="overlay3">
        <div class="overlay overlay3">
            <div class="w">
                <div class="cbd">
                    <span class="close" title="关闭"></span>
                    <a href="javascript:tools.sendStory('share_time', tools.trigger);jQuery.colorbox.close();" title="分享应用赚50元宝"></a></div>
                <div class="opacitylay"></div>
            </div>
        </div>
    </div>

    <div id="overlay4">
        <div class="overlay4">
            <?php
                if(!empty($this->_gotFirstInfo)){
                    foreach($this->_gotFirstInfo as $info){
                            $itemAttributes = $info->getAttributes();
                            $curHref = "javascript:appTools.openUrl('{$itemAttributes['url']}');jQuery.colorbox.close()";
                        ?>
                        <span class="close" title="关闭"></span>
                        <div class="cbd clearfix"><div class="left">
                            <a href="<?php echo $curHref; ?>"><img src="<?php echo $itemAttributes['photo'];?>" width="233" height="233"></a>
                        </div>
                            <div class="right">
                                <div class="price">￥<span class="np"><?php echo $itemAttributes['special_price']?></span><span class="yjt">原价：</span><span class="yjc"><?php echo $itemAttributes['price'];?></span></div>
                                <div class="zk"><span class="n"><?php printf("%1.1f", $itemAttributes['special_price']/$itemAttributes['price']*10);?></span><span class="f">折</span></div>
                                <p class="intr">
                                    <?php echo CHtml::encode($itemAttributes['description']);?>
                                <p>
                                    <a href="<?php echo $curHref?>" title="去购买" class="buy"></a>
                            </div></div>
                       <?php
                    }
                }
            ?>
        </div>
    </div>

    <div id="overlay5">
        <div class="overlay overlay5">
            <div class="w">
                <div class="cbd">
                    <span class="close" title="关闭"></span>
                    <a href="javascript:tools.sendStory()" title="分享应用赚50元宝"></a></div>
                <div class="opacitylay"></div>
            </div>
        </div>
    </div>
</div>


<div class="init nodisplay">
    <div class="rw">
        <div class="cbd">
            <a href="javascript:appTools.closeFirstEnter()" title="确定" class="qd"></a>
        </div>
        <div class="bg"></div>
    </div>
</div>
