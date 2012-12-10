<?php

/**
 * This is the model class for table "qfa_user_msg".
 *
 * The followings are the available columns in table 'qfa_user_msg':
 * @property string $autoid
 * @property string $uid
 * @property string $msg
 * @property string $ctime
 * @property integer $is_read
 */
class UserMsg extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserMsg the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qfa_user_msg';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, msg, ctime', 'required'),
			array('is_read', 'numerical', 'integerOnly'=>true),
			array('uid', 'length', 'max'=>20),
			array('msg', 'length', 'max'=>255),
			array('ctime', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('autoid, uid, msg, ctime, is_read', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'autoid' => 'Autoid',
			'uid' => 'Uid',
			'msg' => 'Msg',
			'ctime' => 'Ctime',
			'is_read' => 'Is Read',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('autoid',$this->autoid,true);
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('msg',$this->msg,true);
		$criteria->compare('ctime',$this->ctime,true);
		$criteria->compare('is_read',$this->is_read);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    //未读消息数
    public function readUidUnreadCount($uid){
        if(!empty($uid) &&  is_numeric($uid)){
            return UserMsg::model()->countByAttributes(array("is_read"=>0, "uid"=>$uid));
        }
    }

    //给所有用户发一条消息
    /*
     * @param $msgContent string 消息内容
     */
    public static function sendAllUserMsg($msgContent){
        $criteria = new CDbCriteria();
        $criteria->select = "uid";

        $allUser = User::model()->findAll($criteria);

        if(!empty($allUser)){
            foreach($allUser as $user){
                $uid = $user->getAttribute("uid");

                if(!empty($uid)){
                    $newMsg = new UserMsg();
                    $newMsg->msg = $msgContent;
                    $newMsg->is_read = 0;
                    $newMsg->ctime = time();
                    $newMsg->uid = $uid;

                    if($newMsg->save()){
                        unset($newMsg);
                        continue;
                    }else{
                        throw new CHttpException("send msg error");
                    }
                }
            }
        }
    }
}