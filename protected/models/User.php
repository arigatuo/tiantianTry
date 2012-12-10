<?php

/**
 * This is the model class for table "qfa_user".
 *
 * The followings are the available columns in table 'qfa_user':
 * @property string $uid
 * @property string $openid
 * @property string $nickname
 * @property string $ctime
 * @property string $score
 * @property string $head
 * @property string $share_time
 * @property string $fav_time
 * @property integer $gender
 * @property integer $is_follow
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'qfa_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('openid, nickname, ctime, head', 'required'),
			array('gender, is_follow', 'numerical', 'integerOnly'=>true),
			array('openid', 'length', 'max'=>32),
			array('nickname', 'length', 'max'=>50),
			array('ctime, score, share_time, fav_time', 'length', 'max'=>10),
			array('head', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uid, openid, nickname, ctime, score, head, share_time, fav_time, gender, is_follow', 'safe', 'on'=>'search'),
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
			'uid' => Yii::t('bg','Uid'),
			'openid' => Yii::t('bg,','Openid'),
			'nickname' => Yii::t('bg','Nickname'),
			'ctime' => Yii::t('bg','Ctime'),
			'score' => Yii::t('bg','Score'),
			'head' => Yii::t('bg','Head'),
			'share_time' => Yii::t('bg','Share Time'),
			'fav_time' => Yii::t('bg','Fav Time'),
			'gender' => Yii::t('bg','Gender'),
			'is_follow' => Yii::t('bg','Is Follow'),
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
		$criteria->compare('openid',$this->openid,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('ctime',$this->ctime,true);
		$criteria->compare('score',$this->score,true);
		$criteria->compare('head',$this->head,true);
		$criteria->compare('share_time',$this->share_time,true);
		$criteria->compare('fav_time',$this->fav_time,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('is_follow',$this->is_follow);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    //增加分享/收藏次数
    //type enum { share_time, fav_time}
    public function addTimes($userId, $type, $times=1){
        $return = false;
        if(!empty($userId) && is_numeric($userId) && in_array($type, array("share_time", "fav_time")) && !empty($times)
            && is_numeric($times)){
        }else{
            throw new Exception('arguments error');
        }

        $theOne = self::model()->findByPk($userId);

        if($theOne != null){
            $orgVal = $theOne->getAttribute($type);
            $theOne->setAttribute($type, $orgVal + $times);
            if($theOne->save()){
                $return = true;
            }
        }

        return $return;
    }
}