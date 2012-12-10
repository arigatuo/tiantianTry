<?php
class AjaxController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = false;

    /**
     *
     */
    public function init(){
        header('P3P: CP=CAO PSA OUR');
    }

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
				array('allow',
						'users'=>array('*'),
					),
				/*
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('index','view'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('create','update'),
						'users'=>array('@'),
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions'=>array('admin','delete', 'Uploadimg'),
						'users'=>array('admin'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
				*/
		);
	}

    /**
     *
     */
    public function actionUploadimg(){
		Yii::import("ext.EAjaxUpload.qqFileUploader");
		
		$folder='upload/'.date("Ymd", time()).'/';// folder for uploaded files
        if(!is_dir("upload")){
            mkdir("upload");
        }
		if(!is_dir($folder)){
			mkdir($folder);
		}
		
		$allowedExtensions = array("jpg", "jpeg", "gif");//array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 1 * 1024 * 1024;// maximum file size in bytes
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload($folder);
		$result['folder'] = $folder;
		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		
		$fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
		$fileName=$result['filename'];//GETTING FILE NAME
		
		echo $return;// it's array
	}

    //增加分享
    //需要参数 itemId, uid, type
    /**
     *
     */
    public function actionAddTimes(){
        if(Yii::app()->request->isAjaxRequest){
            $userInfo = Userinfo::getUserId(1);
            if(!empty($userInfo['userid']))
                $uid = $userInfo['userid'];

            if(!empty($_POST['itemId']) && !empty($uid) && is_numeric($_POST['itemId']) && is_numeric($uid)
                && in_array($_POST['type'], array('share_time', 'fav_time'))
            ){
                //分享奖励
                Trigger::shareAward($_POST['type']);
            }else{
                echo -1;
                die();
            }

            $result = Appcache::setCache($_POST['itemId'], $_POST['type'], $uid);

            //收藏会返回是否收藏成功
            if($_POST['type'] == "fav_time"){
                echo $result;
            }
        }
    }

    /*
     *
     */
    public function actionUpdateTrigger(){
        if(Yii::app()->request->isAjaxRequest){
            if(!empty($userInfo['userid'])){
                $uid = $userInfo['userid'];
                Trigger::shareAward($_POST['type']);
            }
        }
    }

    /**
     *
     */
    public function actionUpdateIsFans(){
        if(Yii::app()->request->isAjaxRequest){
            $qqMember = new Qqmember();
            $return = $qqMember->update_user_is_login();
            echo $return;
        }
    }

    /**
     * 取得最新50条信息
     * @return array
     */
    public function actionGetLatestMsg(){
        if(Yii::app()->request->isAjaxRequest){
            $userInfo = Userinfo::getUserId(1);
            if(!empty($userInfo['userid'])){
                $criteria = new CDbCriteria;
                $criteria->addCondition("uid=:uid AND is_read=0");
                $criteria->params = array(":uid"=>$userInfo['userid']);
                $criteria->order = "ctime desc";
                $criteria->limit = 50;
                $userMsgs = UserMsg::model()->findAll($criteria);
                $msgArray = array();
                if(!empty($userMsgs)){
                    foreach($userMsgs as $msg){
                        $msgArray['msgs'][] = $msg->getAttributes();
                    }
                    $msgCount = count($msgArray['msgs']);
                }
                $msgArray['result_count'] = !empty($msgCount) ? $msgCount : 0;
                echo json_encode($msgArray);
            }
        }
    }

    /**
     * 标记消息已读
     * @return bool
     * @throws CException
     */
    public function actionMarkMsgReaded(){
        if(Yii::app()->request->isAjaxRequest){
            $msgId = $_GET['msgId'];
            if(!empty($msgId) && is_numeric($msgId)){
                ;
            }else{
                throw new CException('msgId should be a number');
            }
            $userInfo = Userinfo::getUserId(1);
            if(!empty($userInfo['userid'])){
                $theMsg = UserMsg::model()->findByAttributes( array(
                    "uid" => $userInfo['userid'],
                    "autoid" => $msgId,
                ) );

                if(!empty($theMsg)){
                    if($theMsg->delete()){
                        Userinfo::getUserId(0, 1);
                        echo json_encode(array('result'=>1));
                    }
                }
            }
        }
    }



    //购买商品
    public function actionBuyProduct(){
        if(Yii::app()->request->isAjaxRequest){
            $request = Yii::app()->request;
            $productId = $request->getParam('productId');
            $userInfo = Userinfo::getUserId(0, 1);

            $return = "";

            if(!empty($productId) && is_numeric($productId) && !empty($userInfo['userid']) && is_numeric($userInfo['userid'])){
                $theProduct = Product::model()->findByPk($productId);
                if(!empty($theProduct)){
                    $leftMoney = $userInfo['gold'] - $theProduct->getAttribute("productPrice");
                    if($leftMoney >= 0){
                        $user = User::model()->findByPk($userInfo['userid']);
                        if(!empty($user)){
                            if($user->setAttribute("gold", $leftMoney)){
                                $return = UserProduct::userBuyOneProduct($productId, $userInfo['userid']);
                                //如果成功更新userInfo缓存
                                $return && $user->save() && $userInfo = UserInfo::getUserId(0, 1);
                            }
                        }else{
                            $return = -2;
                        }
                    }else{
                        //金钱不足
                        $return = -1;
                    }
                }else{
                    throw new CHttpException("confirm fail");
                }
            }

            echo json_encode(array("return"=>$return));
        }
    }

    //签到
    public function actionSignDaily(){
        $return = 0;
        if(Yii::app()->request->isAjaxRequest){
            $userInfo = Userinfo::getUserId();
            if(!empty($userInfo)){
                $signToday = UserLoginRecord::signToday($userInfo['userid']);
                if($signToday > 0){
                    $config = new CConfiguration();
                    $config->loadFromFile("protected/config/award.config.php");
                    $signConfig = $config->itemAt("sign");

                    if(Useraward::addUserGold($userInfo['userid'], $signConfig['gold'])){
                        $newUserMsg = new UserMsg();
                        $newUserMsg->ctime = time();
                        $newUserMsg->msg = $signConfig['msg'];
                        $newUserMsg->is_read = 0;
                        $newUserMsg->uid = $userInfo['userid'];

                        if($newUserMsg->save()){
                            UserLoginRecord::isSignToday($userInfo['userid'],1);
                            UserInfo::getUserId(0, 1);
                            $return = 1;
                        }else{
                            $return = -2;
                        }
                    }else{
                        $return = -3;
                    }
                }else{
                    $return = -1;
                }
            }
        }
        echo json_encode(array('return' => $return));
    }

    //判断是否有时光机
    public function actionIsHaveTimeMachine(){
        $return = UserProduct::isUserHaveThisProduct(1);
        echo json_encode(
            array('return' => $return)
        );
    }

    //判断是否有先到先抢
    public function actionIsHaveGotFirst(){
        $return = UserProduct::isUserHaveThisProduct(2, 1);
        echo json_encode(
            array('return' => $return)
        );
    }

    //设置firstEnter=0
    public function actionSetFirstEnterFalse(){
        $newSession = new CHttpSession();
        $newSession->open();
        $newSession['firstEnter'] = 0;
    }
}