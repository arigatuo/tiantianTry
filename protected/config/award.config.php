<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lizhen
 * Date: 11/28/12
 * Time: 10:44 AM
 * To change this template use File | Settings | File Templates.
 */

return array(
    'rewardRule' => array(
        "1" => array(
            'gold' => 20,
            'msg' => '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~ ',
        ),
        "2" => array(
            'gold' => 50,
            'msg' => '你已经连续登陆2天了，明天再来就可以获得100元宝啦，记得要回来！',
        ),
        "3" => array(
            'gold' => 100,
            'msg' => '恭喜你，你连续登陆三天的毅力感动了我，我送你100元宝，再接再厉吧！',
        ),
    ),

    'sign' => array(
        'gold' => 20,
        'msg' => "签到赚20元宝",
    ),

    'timeMachine' => array(
        'firstBuy' => array(
            'gold' => 0,
            'msg' => '亲，你的时光机已经就位，它的工作寿命有5天，穿越去昨天看看错过的宝贝吧！',
        ),
        'oneDayLeft' => array(
            'gold' => 0,
            'msg' => '亲，你的时光机快要报废了，明天记得来签到，赚钱买一台新的哦',
        ),
        'cantClick' => array(
            'gold' => 0,
            'msg' => '旧的不去新的不来，你的时光机已经报废，去卖一台新的吧！',
        ),
    ),

    'gotFirst' => array(
        'firstBuy' => array(
            'gold' => 0,
            'msg' => '你已成功获得“折扣到底”卡，尊享1-3折优惠，每张只能看一个宝贝哦~~',
        ),
        'firstEnter' => array(
            'gold' => 0,
            'msg' => '亲，尊享1-3折的“折扣到底”卡已经送到，去看看哪个爆款等着你。',
        ),
        'cantClick' => array(
            'gold' => 0,
            'msg' => '一张“折扣到底”卡只能使用一次，今天的爆款看完了，它不会在出现的哈，明天记得来看看~~',
        ),
    ),

    'shareAward' => array(
        //分享奖励金币数
        'share_time' => 50,
        'fav_time' => 100,
    ),
);