<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lizhen
 * Date: 11/26/12
 * Time: 6:03 PM
 * To change this template use File | Settings | File Templates.
 * 用户登录记录
 */
class Beforeenter extends CController{
    const MAX_DAY = 3;
    //进入应用记录
    public $uid;

    public function __construct(){
    }

    /**
     * @param $uid
     */
    public function setUid($uid){
        $this->uid = $uid;
    }

    /**
     * 连续登录判断
     * @param $uid
     * @return bool
     */
    public function enterRecord($uid){
        $return = null;

        $cacheKey = md5(__CLASS__.__FUNCTION__.$uid);
        $cacheTime = 5 * 60;
        $cacheVal = Yii::app()->cache->get($cacheKey);
        if(!empty($cacheVal)){
            $theUidRecord = $cacheVal;
        }else{
            $theUidRecord = UserLoginRecord::model()->findByPk($uid);
            if(!empty($theUidRecord)){
                Yii::app()->cache->set($cacheKey, $theUidRecord, $cacheTime);
            }
        }

        $isChange = FALSE;
        if(!empty($theUidRecord)){
            $logDate = date("Ymd", $theUidRecord->last_update);
            $today = date("Ymd");

            //上次记录得天数是否同一天
            if($logDate == $today){
            }else{
                if( ($today - $logDate) == 1){
                    if($theUidRecord->consistent < self::MAX_DAY){
                        $theUidRecord->consistent++;
                    }else{
                        $theUidRecord->consistent = 1;
                    }
                    $theUidRecord->last_update = time();
                    $isChange = TRUE;
                    //奖励接口
                    //传入连续登录天数， 用户id
                }else{
                    $theUidRecord->consistent = 1;
                    $theUidRecord->last_update = time();
                    $isChange = TRUE;
                }
            }
        }else{
            $theUidRecord = new UserLoginRecord();
            $theUidRecord->consistent = 1;
            $theUidRecord->last_update = time();
            $theUidRecord->uid = $uid;
            $isChange = TRUE;
        }

        if($isChange){
            //添加奖励
            self::awardConsistent($theUidRecord->consistent, $uid);
        }

        if($isChange && $theUidRecord->save()){
            $return = TRUE;
        }

        return $return;
    }

    /**
     * 连续登录奖励
     * @param $consistent 连续登录天数
     * @param $uid
     * @return bool
     */
    public function awardConsistent($consistent, $uid){
        $return = null;

        $config = new CConfiguration();
        $config->loadFromFile("protected/config/award.config.php");
        $rewardRule = $config->itemAt("rewardRule");

        if(array_key_exists($consistent, $rewardRule)){
            $curRule = $rewardRule[$consistent];
            //增加金币
            if(Useraward::addUserGold($uid, $curRule['gold'])){
                //增加消息
                $newUserMsg = new UserMsg();
                $newUserMsg->ctime = time();
                $newUserMsg->msg = $curRule['msg'];
                $newUserMsg->is_read = 0;
                $newUserMsg->uid = $uid;

                if($newUserMsg->save()){
                    Userinfo::updateUserInfo();
                    $return = true;
                }
            }
        }

        return $return;
    }
}