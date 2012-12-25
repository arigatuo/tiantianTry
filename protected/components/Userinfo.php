<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lizhen
 * Date: 11/28/12
 * Time: 4:31 PM
 * To change this template use File | Settings | File Templates.
 * 取得用户信息
 */
class Userinfo extends CController
{
    const CACHE_KEY_HEAD = "theUserInfoCache";
    //取得用户额外信息，消息数，金币数，道具==
    /**
     * @param int $uid 用户id
     * @param int $withoutCache 是否更新缓存
     * @return mixed
     */
    public static function getOthUserInfo($uid, $withoutCache=0){
        if(!empty($uid) && is_numeric($uid)){
            $cacheKey = md5(self::CACHE_KEY_HEAD.$uid);
            $cacheTime = 1 * 60;
            $cacheVal = Yii::app()->cache->get($cacheKey);

            if(!empty($cacheVal) && !$withoutCache){
                $userInfo = $cacheVal;
            }else{
                //时光机
                $timeMachine = UserProduct::model()->findByAttributes(array('uid'=>$uid, 'product_id'=>1));

                $msgAdd = 0;
                if(!empty($timeMachine)){
                    $leftDay = Helper::countLeftDays($timeMachine->getAttribute("expireTime"));
                    //消息提醒
                    if(self::timeMachineNotice($timeMachine, $uid, 1, "oneDayLeft")){
                        //1天提醒
                        ;
                    }
                    if(self::timeMachineNotice($timeMachine, $uid, 0, "cantClick")){
                        //到期提醒
                        if($timeMachine->delete())
                            unset($timeMachine);
                    }
                    $userInfo['timeMachine'] = !empty($timeMachine) ?  $leftDay : 0;
                }
                //未读消息数
                $userInfo['unread_msg_count'] = UserMsg::model()->readUidUnreadCount($uid);
                $theUser = User::model()->findByPk($uid);
                //金币数
                $userInfo['gold'] = !empty($theUser) ? $theUser->getAttribute("gold") : 0;
                //先到先得
                $gotFirst = UserProduct::model()->findByAttributes(array('uid'=>$uid, 'product_id'=>2));

                $userInfo['gotFirst'] = !empty($gotFirst) ? $gotFirst->getAttribute("product_num") : 0;

                Yii::app()->cache->set($cacheKey, $userInfo, $cacheTime);

            }

            return $userInfo;
        }
    }

    /*
     * message notice condition
     */
    public static function timeMachineNotice($timeMachine, $uid, $day, $msgKey){
        $_return = false;
        $leftDay = Helper::countLeftDays($timeMachine->getAttribute("expireTime"));
        $noticeDay = $timeMachine->getAttribute('noticeTime') ? $timeMachine->getAttribute('noticeTime') : 0;
        $condition = ($leftDay === $day) && (date("Ymd", time()) != date("Ymd", $noticeDay));
        if( $condition ){
            //通知
            if(Trigger::msgNotice("timeMachine", $msgKey, $uid)){
                //标记今天已通知
                $timeMachine->setAttribute("noticeTime", time());
                if($timeMachine->save()){
                    $_return = true;
                }
            }
        }

        return $_return;
    }

    /**取得用户基本信息
     * @return mixed
     */
    public static function getUserId($withoutMore = 0, $withoutCache = 0){
        $mySession = new CHttpSession();
        $mySession->open();
        $userInfo = $mySession->get("userInfo");
        if(!empty($userInfo['userid']) && !$withoutMore){
            $userInfoMore = self::getOthUserInfo($userInfo['userid'], $withoutCache);

            if(is_array($userInfoMore))
                $userInfo = array_merge($userInfo, $userInfoMore);
        }
        return $userInfo;
    }

    /*
     * 取得用户的登录记录
     */
    public static function getLoginRecord($uid){
        if(!empty($uid) && is_numeric($uid)){
            $theOne = UserLoginRecord::model()->findByPk($uid);
            return !empty($theOne) ? $theOne->getAttributes() : NULL;
        }
    }

    /*
     * 更新缓存
     */
    public static function updateUserInfo(){
        Userinfo::getUserId(0, 1);
    }
}
