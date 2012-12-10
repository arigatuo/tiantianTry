<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lizhen
 * Date: 11/28/12
 * Time: 10:14 AM
 * To change this template use File | Settings | File Templates.
 */
class Useraward extends CController
{
    //增加用户金币
    public static function addUserGold($uid, $gold){
        if(!empty($uid) && !empty($gold) && is_numeric($uid) && is_numeric($gold)){
            //添加用户金币增加记录
            $userAwardLog = new UserAwardLog();
            $userAwardLog->award = $gold;
            $userAwardLog->ctime = time();
            $userAwardLog->uid = $uid;


            if($userAwardLog->save()){
                $theUser = User::model()->findByPk($uid);
                if(!empty($theUser)){
                    $theUser->gold += $gold;
                    $theUser->save();
                    if($theUser->save()){
                        return true;
                    }
                }
            }
        }
    }
}
