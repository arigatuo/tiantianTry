<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lizhen
 * Date: 11/4/12
 * Time: 11:59 PM
 * To change this template use File | Settings | File Templates.
 */
class Qqmember extends CController
{
    private $_appKey, $_appId, $_appRecallUrl, $_serverName, $_followPageId;

    public function __construct(){
        ;
    }

    public function init(){
        header('P3P: CP=CAO PSA OUR');

        $config = new CConfiguration();
        $config->loadFromFile("protected/config/qq_connect.php");
        $this->_appKey = $config->itemAt("appKey");
        $this->_appId = $config->itemAt("appId");
        $this->_appRecallUrl = $config->itemAt("appRecallUrl");
        $this->_serverName = $config->itemAt("serverName");

        //要关注的qq号
        $this->_followPageId = $config->itemAt("page_id");
    }

    //取得用户信息
    public function get_user_info($sdk, $openid, $openkey, $pf){
        $params = array(
            'openid' => $openid,
            'openkey' => $openkey,
            'pf' => $pf,
        );
        $script_name = '/v3/user/get_info';
        return $sdk->api($script_name, $params,'post');
    }

    //判断是否关注, page_id为要关注的qq号
    public function is_attention($sdk, $openid, $openkey, $pf, $page_id){
        $params = array(
            'openid' => $openid,
            'openkey' => $openkey,
            'pf' => $pf,
            'page_id' => $page_id,
        );
        $script_name = '/v3/page/is_fans';
        return $sdk->api($script_name, $params,'post');
    }

    //sdk
    public function newSdk(){
        self::init();
        Yii::import('application.vendors.qqsdk.*');
        Yii::import('application.vendors.qqsdk.lib.*');
        require_once("OpenApiV3.php");

        $sdk = new OpenApiV3($this->_appId, $this->_appKey);
        $sdk->setServerName($this->_serverName);

        return $sdk;
    }

    //用户接入
    public function memberEnter(){
        $sdk = self::newSdk();

        if(!empty($_REQUEST['openid']) && !empty($_REQUEST['openkey']) && !empty($_REQUEST['pf'])){
            $newSession = new CHttpSession();
            $newSession->open();
            $newSession['userInfo'] = array();

            //user_info
            $ret = $this->get_user_info($sdk, $_REQUEST['openid'], $_REQUEST['openkey'], $_REQUEST['pf']);
            //is_fans
            $ret_is_fans = $this->is_attention($sdk, $_REQUEST['openid'], $_REQUEST['openkey'], $_REQUEST['pf'], $this->_followPageId);

            if($ret['ret'] !== 0){
                throw new CHttpException("404");
            }else{
                $isExist = User::model()->countByAttributes(array('openid'=>$_REQUEST['openid']));
                $isFans = 0;
                if($ret_is_fans['ret'] == 0){
                    $isFans = $ret_is_fans['is_fans'];
                }

                if($isExist > 0){
                    $theOne = User::model()->findByAttributes(array('openid'=>$_REQUEST['openid']));
                    $theOneAttribute = $theOne->getAttributes();

                    if($theOneAttribute != null){
                        $userInfo = array(
                            'userid' => $theOneAttribute['uid'],
                            'nickname' => $theOneAttribute['nickname'],
                            'head' => $theOneAttribute['head'],
                            'openid' => $_REQUEST['openid'],
                            'openkey' => $_REQUEST['openkey'],
                            'isFans' => $isFans,
                            'pf' => $_REQUEST['pf'],
                        );
                        $newSession['userInfo'] = $userInfo;
                    }
                }else{
                    $newUser = new User;

                    $nickname_head = trim(Helper::truncate_utf8_string($ret['nickname'],5));
                    if(empty($nickname_head)){
                        $nickname_head = substr($_REQUEST['openid'], 0, 5);
                    }

                    $nickname = $nickname_head."_".substr(md5(time()), 5, 5);
                    $newUser->attributes = array(
                        'openid' => $_REQUEST['openid'],
                        'nickname' => $nickname,
                        'gender' => $ret['gender'] == "男" ?  1 : 0,
                        'ctime' => time(),
                        'score' => 0,
                        'head' => $ret['figureurl'],
                        'share_time' => 0,
                        'fav_time' => 0,
                        'is_follow' => $isFans,
                    );

                    if($newUser->save()){
                        $lastInsertId = $newUser->uid;

                        $userInfo = array(
                            'userid' => $lastInsertId,
                            'nickname' => $nickname,
                            'head' => $ret['figureurl'],
                            'openid' => $_REQUEST['openid'],
                            'openkey' => $_REQUEST['openkey'],
                            'isFans' => $isFans,
                            'pf' => $_REQUEST['pf'],
                        );
                        $newSession['userInfo'] = $userInfo;

                        //第一次进入应用钩子
                        Trigger::firstEnterEvent($lastInsertId);
                    }
                }
            }
        }


    }

    //更新是否关注状态
    public function update_user_is_login(){
        $session = new CHttpSession();
        $session->open();
        if(!empty($session['userInfo'])){
            $userInfo = $session['userInfo'];
            $sdk = self::newSdk();
            if(!empty($userInfo['openid']) && !empty($userInfo['openkey']) && !empty($userInfo['pf'])){
                $ret_is_fans = $this->is_attention($sdk, $userInfo['openid'], $userInfo['openkey'], $userInfo['pf'], $this->_followPageId);
                $isFans = ($ret_is_fans['ret'] == 0) ? $ret_is_fans['is_fans'] : 0;
                $userInfo['isFans'] = $isFans;
                $session['userInfo'] = $userInfo;

                return $isFans;
            }
        }
    }
}
