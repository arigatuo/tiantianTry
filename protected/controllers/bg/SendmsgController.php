<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lizhen
 * Date: 12/7/12
 * Time: 5:23 PM
 * To change this template use File | Settings | File Templates.
 */
class SendmsgController extends Controller
{
    public $layout='//layouts/column2';

    public function init(){

    }

    //群发消息给所有用户
    public function actionMsgSet(){
        $request = Yii::app()->request;
        $sureSubmit = $request->getPost("sureSubmit");

        if(!empty($sureSubmit)){
            $content = $request->getPost("msgContent");
            UserMsg::sendAllUserMsg($content);
        }

        $this->render('msgset');
    }
}
