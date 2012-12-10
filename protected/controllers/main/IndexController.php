<?php

class IndexController extends Controller
{
    public $_userInfo, $_gotFirstInfo;

    /**
     *
     */
    public function init(){
        $this->layout = "front_layout";

        $userInfo = Userinfo::getUserId();
        if(!empty($userInfo)){
            $this->_userInfo = $userInfo;
        }

        //先到先得
        $this->_gotFirstInfo = Item::findByCondition(3, strtotime(date("Ymd")), 0, 1);
    }



    /**
     *
     */
    public function actionIndex()
	{
        //入口页
        //qq用户接入
        $qqMember = new Qqmember;
        $qqMember->memberEnter();

        $userInfo = Userinfo::getUserId();


        if(empty($userInfo['userid'])){
            die('user auth error');
        }

        //连续登录检查并奖励
        $newBeforeEnter = new Beforeenter();
        $newBeforeEnter->enterRecord($userInfo['userid']);

        $url = Yii::app()->createUrl("main/Index/TryPageOne");
        $this->redirect($url);
	}

    //tabOne
    /**
     *
     */
    public function actionTryPageOne($date=""){
        if(empty($this->_userInfo['userid'])){
            die('user auth error');
        }

        $category_id = (!empty($_GET['category_id']) && is_numeric($_GET['category_id'])) ? $_GET['category_id'] : 0;

        $type_id = 1;
        //如果有category_id则不考虑时间限制
        $curDate = $category_id ? "" : ( $date ? $date : strtotime(date("Y-m-d", time())) );
        $items = Item::model()->findByCondition($type_id, $curDate, $category_id);

        $this->render('index',
                array(
                    'items' => $items,
                    'page' => 'page1',
                )
        );
    }

    public function actionTryPageTimeMachine(){
        $date = strtotime(date("Y-m-d", time()-24*3600));
        $this->actionTryPageOne($date);
    }

    //tabtwo
    /**
     *
     */
    public function actionTryPageTwo(){
        if(empty($this->_userInfo['userid'])){
            die('user auth error');
        }

        $category_id = (!empty($_GET['category_id']) && is_numeric($_GET['category_id'])) ? $_GET['category_id'] : 0;

        $type_id = 2;
        $items = Item::model()->findByCondition($type_id, "", $category_id);

        $this->render('index',
            array(
                'items' => $items,
                'page' => 'page2',
            )
        );
    }

   //用户中心
    public function actionUserCenter(){
        if(empty($this->_userInfo['userid'])){
            die('user auth error');
        }

        $cacheKey = md5("gotUserFav".$this->_userInfo['userid']);
        $cacheTime = 1 * 60;
        $cacheVal = Yii::app()->cache->get($cacheTime);
        if(!empty($cacheVal)){
            $favArray = $cacheVal;
        }else{
            $criteria = new CDbCriteria;
            $criteria->addCondition("uid=:uid");
            $criteria->params = array(
                ':uid' => $this->_userInfo['userid'],
            );
            $criteria->limit = 10;

            $favList = UserFav::model()->findAll($criteria);

            $favArray = array();
            if(!empty($favList)){
                foreach($favList as $key=>$fav){
                    $item_id = $fav->getAttribute("itemId");
                    if(!empty($item_id)){
                        $theItem = Item::model()->findByPk($item_id);
                        $favArray[$key] = array(
                            'item_id' => $item_id,
                            'attributes' => $theItem->getAttributes(array("url", "photo", "title")),
                        );
                    }
                }
            }
            Yii::app()->cache->set($cacheKey, $favArray, $cacheTime);
        }

        $this->_userInfo['loginRecord'] = Userinfo::getLoginRecord($this->_userInfo['userid']);
        $this->render('userCenter',
            array(
                'favArray' => $favArray,
            )
        );
    }


	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}