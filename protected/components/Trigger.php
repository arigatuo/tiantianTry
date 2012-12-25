<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lizhen
 * Date: 12/6/12
 * Time: 4:23 PM
 * To change this template use File | Settings | File Templates.
 */
class Trigger extends Controller
{
    //信息提示
    public static function msgNotice($type, $key, $uid){
        $_return = false;
        if(!empty($uid)){
            $config = Helper::loadAwardConfig($type);
            if(!empty($config[$key]['msg'])){
                $newUserMsg = new UserMsg();
                $newUserMsg->ctime = time();
                $newUserMsg->msg = $config[$key]['msg'];
                $newUserMsg->is_read = 0;
                $newUserMsg->uid = $uid;

                if($newUserMsg->save()){
                    $_return = true;
                }
            }
        }
        return $_return;
    }

    //第一次进入设置的钩子
    public static function firstEnterEvent($uid){
        //奖励先到先得
       $productId = 2;
       UserProduct::userBuyOneProduct($productId, $uid);

       $newSession = new CHttpSession();
       $newSession->open();
       $newSession['firstEnter'] = 1;
    }

    //分享奖励
    public static function shareAward($type){
        $config = Helper::loadAwardConfig(__FUNCTION__);
        $curAward = $config[$type];
        $userInfo = Userinfo::getUserId(0);
        $result = 0;
        if(!empty($userInfo['userid']) && is_numeric($userInfo['userid'])){
            $result = Useraward::addUserGold($userInfo['userid'], $curAward);
            if($result){
                Userinfo::updateUserInfo();
                $result = $userInfo['gold'] + $curAward;
            }
        }

        return $result;
    }
}
