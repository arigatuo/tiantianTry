    <ul class="prolist">
<?php
    $baseUrl = Yii::app()->baseUrl."/";
    foreach($items as $item){
        $itemAttributes = $item->getAttributes();
        $curHref = "javascript:appTools.openUrl('{$itemAttributes['url']}')";
        $curHrefWithShare = "javascript:appTools.openUrlWithShare('{$itemAttributes['item_id']}', '{$itemAttributes['url']}')";
?>
        <li class="item">
            <h2><img src="<?php echo $baseUrl;?>images/icon2.gif" width="37" height="37"><span class="fy">[<?php echo $itemAttributes['free_trans'] ? '包邮' : '付邮'; ?>]</span><a href="<?php echo $curHref;?>"><?php echo $itemAttributes['title'];?></a></h2>
            <div class="pic"><a href="<?php echo $curHref;?>"><img id="itempic_<?php echo $itemAttributes['item_id'];?>" src="<?php echo $itemAttributes['photo'];?>" width="310" height="310"></a> <span class="shadow"></span> </div>
            <div class="txt">
                <div class="price-try">
                    <div class="price"><span class="cp"><?php echo $itemAttributes['special_price'];?></span> <span class="op">原价：<i><?php echo $itemAttributes['price'];?></i></span> </div>
                    <div class="try <?php echo $page == 'page2' ? 'b_link' :'';?>"><a href="<?php echo $curHrefWithShare;?>" title="马上试用">马上试用</a></div>
                </div>
                <?php
                    $actionId = Yii::app()->controller->action->id;
                    if($actionId == "TryPageTwo"){
                ?>
                            <div class="num  num-style2">
                              <div class="left ">购买人数:<strong><?php echo max(0,$itemAttributes['pieces'] - $itemAttributes['already_buy']);?></strong>人</div>
                            </div>
                <?php
                    }else{
                        if(!empty($itemAttributes['free_trans'])){
                            ?>
                            <div class="num  num-style2">
                                <div class="left ">总份数:<strong><?php echo $itemAttributes['pieces'];?></strong>份</div>
                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="num">
                                <div class="left">总份数:<strong><?php echo $itemAttributes['pieces'];?></strong>份</div>
                                <div class="right">申领数:<strong><?php echo max(0, $itemAttributes['already_buy']);?></strong>份</div>
                            </div>
                            <?php
                        }
                    }
                ?>


                <p class="recommend"> <strong>小编推荐：</strong><?php echo Helper::truncate_utf8_string($itemAttributes['description'],50); ?></p>
                <div class="favorite-handsel">
                    <a href="javascript:" id="favNumber_<?php echo $itemAttributes['item_id'];?>" xid="<?php echo $itemAttributes['item_id'];?>" title="收藏" class="favorite favorite2"><span>( <font class="number"><?php echo Appcache::getCache($itemAttributes['item_id'], 'fav_time'); ?></font> )</span></a>
                    <a href="javascript:" id="shareNumber_<?php echo $itemAttributes['item_id'];?>" xid="<?php echo $itemAttributes['item_id'];?>" title="请好友赠送" class="handsel handsel-style2"><span>( <font class="number"><?php echo Appcache::getCache($itemAttributes['item_id'], 'share_time'); ?></font> )</span></a>
                </div>
            </div>

            <?php if(empty($this->_userInfo['isFans'])){ ?>
            <div class="qzone" style="display:none"><iframe src="http://open.qzone.qq.com/like?url=http%3A%2F%2Fuser.qzone.qq.com%2F625617480&type=button&width=400&height=30&style=3" allowtransparency="true" scrolling="no" border="0" frameborder="0" style="width:65px;height:30px;border:none;overflow:hidden; margin:17px 0 5px 15px;"></iframe><p>关注我，每天有新试用哦</p></div>
            <?php } ?>
        </li>
<?php
    }
?>
    </ul>
