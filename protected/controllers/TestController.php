<?php
    class TestController extends Controller{
        public function actionTest(){
            //测试设置收藏
            $theOne = Item::model()->findByPk(5)->getAttribute('share_time');
            var_dump($theOne);
            $rs = Appcache::getCache(5, 'share_time');
            var_dump($rs);

            echo "</br>";

            $theOne = Item::model()->findByPk(5)->getAttribute('fav_time');
            var_dump($theOne);
            $rs = Appcache::getCache(5, 'fav_time');
            var_dump($rs);
        }

        public function actionTest2(){
            //测试设置收藏
            $rs1 = Appcache::setCache(5, 'share_time', 10);
            $rs2 = Appcache::setCache(5, 'fav_time', 10);

            var_dump($rs1);
            var_dump($rs2);
        }

        public function actionTest3(){
            Helper::makeMultiComments(5);
        }

        public function actionFlushMem(){
            Yii::app()->cache->flush();
        }

        public function actionHtml(){
            $this->render("html");
        }
        public function actionHtml2(){
            $this->layout = false;
            $this->render("html2");
        }

        public function actionComment(){
            $rs = Item::model()->findAll();
            foreach($rs as $v){
                $pk = $v->getAttribute("item_id");
                Helper::makeMultiComments($pk, 3);
            }
        }

        //测试连续登录奖励
        public function actionTestAward(){
            $uid = 397246;

            $rs = UserLoginRecord::model()->findByPk($uid);
            /*
             * 新记录
            $rs->delete();
            */
            /*
             * 隔天
             */
            $rs->last_update = time() - 48 * 3600;
            var_dump(date("Y-m-d", $rs->last_update));
            $rs->save();

            $newBeforeEnter = new Beforeenter($uid);
            $newBeforeEnter->enterRecord($uid);

            $rs = User::model()->findByPk($uid);
            var_dump($rs->getATtribute("gold"));

            $rs = UserLoginRecord::model()->findByPk($uid);
            var_dump($rs->getAttributes());

            $rs = UserAwardLog::model()->findAllByAttributes(array("uid"=>$uid));
            foreach($rs as $v){
                var_dump($v->getAttributes());
            }

            $rs = UserMsg::model()->findAllByAttributes(array('uid'=>$uid));
            foreach($rs as $v){
                var_dump($v->getAttributes());
            }
        }

        public function actionTestCountMsg(){
            $uid = 397246;
            var_dump(UserMsg::model()->readUidUnreadCount($uid));
            var_dump(Userinfo::getOthUserInfo($uid));
            var_dump(Userinfo::getUserId());
        }

        public function actionCreateMsg(){
            $msgNumber = 3;
            $uid = 10;
            for($i = 0; $i < $msgNumber; $i++){
                $msg = new UserMsg();
                $msg->msg = "test".time();
                $msg->ctime = time();
                $msg->is_read = 0;
                $msg->uid = $uid;
                $msg->save();
            }
        }

        public function actionClearCache(){
            Yii::app()->cache->flush();
        }
    }
?>


