<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lizhen
 * Date: 11/6/12
 * Time: 11:27 PM
 * To change this template use File | Settings | File Templates.
 * 用于操作收藏和分享
 */
class Appcache extends CController
{
    const KEY_HEAD = "read_nums_";
    const CACHE_TIME = 86400;
    //设置缓存， 并新增用户收藏记录
    //@type (enum){share_time, fav_time}
    public static function setCache($itemId, $type, $uid=0){
        if(!empty($itemId) && is_numeric($itemId) && !empty($type) && in_array($type, array('share_time', 'fav_time'))){
        }else{
            die();
        }

        //如果是fav_time, 返回1表示收藏成功
        $return = 0;

        //如果是收藏还要添加用户记录
        if($type == "fav_time" && !empty($uid)){
            $countCacheKey = md5("count".__CLASS__.__FUNCTION__.$itemId.$uid);
            $countCacheTime = self::CACHE_TIME;
            $count = Yii::app()->cache->get($countCacheKey);
            if($count != null){
                ;
            }else{
                $count = UserFav::model()->count("uid=:uid AND itemId=:itemId", array(":uid"=>$uid, ":itemId"=>$itemId));
                if($count > 0){
                    Yii::app()->cache->set($countCacheKey, $count, $countCacheTime);
                }
            }

            if($count == 0){
                $newUserFav = new UserFav;
                $attributeArray = array(
                    'uid' => $uid,
                    'itemId' => $itemId,
                    'ctime' => time(),
                );
                $newUserFav->setAttributes($attributeArray);
                if($newUserFav->save()){
                    Yii::app()->cache->set($countCacheKey, 1, $countCacheTime);
                    //用户收藏数+1
                    User::model()->addTimes($uid, $type, 1);
                    $return = 1;
                }
            }
        }

        //分享用户统计直接加1
        if($type == "share_time"){
            User::model()->addTimes($uid, $type, 1);
        }

        if($type == 'share_time' || ($type == "fav_time" && $return == 1) ){
            //如果是分享则直接加1， 如果是收藏， 如果收藏成功则+1
            $cacheKey = md5(self::KEY_HEAD.$itemId.$type);
            $cacheTime = self::CACHE_TIME;

            $cacheVal = Yii::app()->cache->get($cacheKey);
            if($cacheVal != null){
                $cacheVal['times'] += 1;
                $cacheVal['changed'] = 1;
                Yii::app()->cache->set($cacheKey, $cacheVal, $cacheTime);
            }else{
                $theOneAttribute = Item::model()->findByPk($itemId)->getAttribute($type);
                $cacheVal = array(
                    'times' => $theOneAttribute+1,
                    'lastUpdateTime' => time(),
                    'changed' => 0,
                );
                Yii::app()->cache->set($cacheKey, $cacheVal, $cacheTime);
            }
        }


        return $return;
    }

    //读取cache, 并在一定时间后存入数据库
    //@type (enum){share_time, fav_time}
    public static function getCache($itemId, $type){
        if(!empty($itemId) && is_numeric($itemId) && !empty($type) && in_array($type, array('share_time', 'fav_time'))){
        }else{
            die();
        }

        $cacheKey = md5(self::KEY_HEAD.$itemId.$type);
        $cacheTime = self::CACHE_TIME;

        $cacheVal = Yii::app()->cache->get($cacheKey);

        if($cacheVal != null){
            //60秒更新到数据库
            if(!empty($cacheVal['lastUpdateTime']) && (time()-$cacheVal['lastUpdateTime']) > 60){
                //如果状态改变
                if(!empty($cacheVal['changed']) && $cacheVal['changed'] == 1){
                    $theOne = Item::model()->findByPk($itemId);
                    if($theOne != null){
                        $theOne->setAttribute($type, $cacheVal['times']);
                        if($theOne->update()){
                            $cacheVal['changed'] = 0;
                            $cacheVal['lastUpdateTime'] = time();
                        }
                    }
                }else{
                    $cacheVal['lastUpdateTime'] = time();
                }
                Yii::app()->cache->set($cacheKey, $cacheVal, $cacheTime);
            }
        }else{
            $theOne = Item::model()->findByPk($itemId);
            if($theOne != null){
                $theOneAttribute = $theOne->getAttribute($type);
                $cacheVal = array(
                    'times' => $theOneAttribute,
                    'lastUpdateTime' => time(),
                    'changed' => 0,
                );
                Yii::app()->cache->set($cacheKey, $cacheVal, $cacheTime);
            }
        }
        return $cacheVal['times'];
    }

}
