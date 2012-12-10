<?php

/**
 * This is the model class for table "qfa_user_login_record".
 *
 * The followings are the available columns in table 'qfa_user_login_record':
 * @property string $uid
 * @property string $last_update
 * @property string $consistent
 */
class UserLoginRecord extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserLoginRecord the static model class
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
		return 'qfa_user_login_record';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid', 'required'),
			array('uid', 'length', 'max'=>20),
			array('last_update', 'length', 'max'=>10),
			array('consistent', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uid, last_update, consistent', 'safe', 'on'=>'search'),
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
			'uid' => 'Uid',
			'last_update' => 'Last Update',
			'consistent' => 'Consistent',
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

		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('consistent',$this->consistent,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * 签到
     * @param $uid
     * @return int
     * @throws CException
     */
    public static function signToday($uid){
        if(!empty($uid) && is_numeric($uid)){
            ;
        }else
            throw new CException("param missing or error");

        $theRecord = UserLoginRecord::model()->findByPk($uid);
        if(!empty($theRecord)){
            $lastSign = $theRecord->getAttribute("last_sign");
            if(date("Ymd", $lastSign) == date("Ymd")){
                //已签到
                $return = -1;
            }else{
                $theRecord->setAttribute("last_sign", time());
                if($theRecord->save()){
                    $return = 1;
                }else{
                    //save fail
                    $return = -2;
                }
            }
        }
        return $return;
    }

    /**
     * 是否已签到
     * @param $uid
     * @return bool
     * @throws CException
     */
    public static function isSignToday($uid, $withoutCache = 0){
        if(!empty($uid) && is_numeric($uid)){
            ;
        }else
            throw new CException("param missing or error");

        $cacheKey = md5(__CLASS__.__FUNCTION__.$uid);
        $cacheTime = 60;
        $cacheVal = Yii::app()->cache->get($cacheKey);

        if(!empty($cacheVal) && !$withoutCache){
            $theRecord = $cacheVal;
        }else{
            $theRecord = UserLoginRecord::model()->findByPk($uid);
            if(!empty($theRecord))
                Yii::app()->cache->set($cacheKey, $theRecord, $cacheTime);
        }

        if(!empty($theRecord)){
            $lastSign = $theRecord->getAttribute("last_sign");
            if(date("Ymd", $lastSign) == date("Ymd")){
                //已签到
                $return = true;
            }else{
                $return = false;
            }
        }else{
            $return = false;
        }

        return $return;
    }
}