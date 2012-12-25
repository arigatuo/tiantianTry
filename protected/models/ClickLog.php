<?php

/**
 * This is the model class for table "qfa_click_log".
 *
 * The followings are the available columns in table 'qfa_click_log':
 * @property string $logid
 * @property string $item_id
 * @property string $button_type
 * @property string $ctime
 */
class ClickLog extends CActiveRecord
{
    public $button_type_array = array("buy", "share", "fav");
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ClickLog the static model class
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
		return 'qfa_click_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, button_type, ctime', 'required'),
			array('item_id', 'length', 'max'=>20),
			array('button_type', 'length', 'max'=>5),
			array('ctime', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('logid, item_id, button_type, ctime', 'safe', 'on'=>'search'),
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
			'logid' => 'Logid',
			'item_id' => 'Item',
			'button_type' => 'Button Type',
			'ctime' => 'Ctime',
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

		$criteria->compare('logid',$this->logid,true);
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('button_type',$this->button_type,true);
		$criteria->compare('ctime',$this->ctime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    /**
     * 增加新的记录
     * @param $newInfo array(item_id, button_type)
     * @return bool
     */
    public function addRecord($newInfo){
        $return = false;
        if(!empty($newInfo) && !empty($newInfo['item_id']) && !empty($newInfo['button_type'])
                && in_array($newInfo['button_type'], $this->button_type_array) ){
                    $newRecord = new ClickLog();
                    $newInfo['ctime'] = date("Ymd", time());
                    $newRecord->setAttributes($newInfo);
                    if($newRecord->save()){
                        $return = TRUE;
                    }
        }
        return $return;
    }
}