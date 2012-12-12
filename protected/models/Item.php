<?php

/**
 * This is the model class for table "qfa_item".
 *
 * The followings are the available columns in table 'qfa_item':
 * @property string $item_id
 * @property double $price
 * @property double $special_price
 * @property string $title
 * @property string $endtime
 * @property string $is_free
 * @property string $category_id
 * @property string $pieces
 * @property string $description
 * @property string $share_time
 * @property string $fav_time
 * @property string $already_buy
 * @property string $photo
 * @property integer $is_top
 */
class Item extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Item the static model class
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
		return 'qfa_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,  category_id, photo, type_id, url', 'required'),
			array('is_top, free_trans', 'numerical', 'integerOnly'=>true),
			array('price, special_price', 'numerical'),
			array('title, photo,fixDate', 'length', 'max'=>255),
			array('category_id,  pieces, share_time, fav_time, already_buy', 'length', 'max'=>10),
			array('is_free', 'length', 'max'=>1),
			array('description, endtime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('item_id, price, special_price, title, endtime, is_free, category_id, pieces, description, share_time, fav_time, already_buy, photo, is_top', 'safe', 'on'=>'search'),
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
			'item_id' => Yii::t("bg", 'Item'),
			'price' => Yii::t('bg','Price'),
			'special_price' => Yii::t('bg','Special Price'),
			'title' => Yii::t('bg','Title'),
			'endtime' => Yii::t('bg','Endtime'),
			'is_free' => Yii::t('bg','Is Free'),
			'category_id' => Yii::t('bg','Category'),
			'pieces' => Yii::t('bg','Pieces'),
			'description' => Yii::t('bg','Description'),
			'share_time' => Yii::t('bg','Share Time'),
			'fav_time' => Yii::t('bg','FavTime'),
			'already_buy' => Yii::t('bg','Already Buy'),
			'photo' => Yii::t('bg','Photo'),
			'is_top' => Yii::t('bg','IsTop'),
            'type_id' => Yii::t('bg', 'type_id'),
            'url' => Yii::t('bg', 'url'),
            'fixDate' => Yii::t('bg', 'fixDate'),
            'free_trans' => Yii::t('bg', 'free_trans'),
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

		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('special_price',$this->special_price);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('is_free',$this->is_free,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('pieces',$this->pieces,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('share_time',$this->share_time,true);
		$criteria->compare('fav_time',$this->fav_time,true);
		$criteria->compare('already_buy',$this->already_buy,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('is_top',$this->is_top);
        $criteria->compare('type_id',$this->type_id);
        $criteria->compare('type_id',$this->url);

        $criteria->compare('endtime',$this->endtime,true);

        //$criteria->order = " item_id DESC ";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'item_id DESC',
            ),
		));
	}

    public function beforeSave(){
        $this->endtime = strtotime($this->endtime);
        $this->fixDate = date("Y-m-d", strtotime($this->fixDate));
        $this->fixDate = strtotime($this->fixDate);
        if($this->isNewRecord){
            $this->ctime = time();
        }
        return parent::beforeSave();
    }

    public function afterFind(){
        $this->endtime = date("Y-m-d H:i:s", $this->endtime);
        $this->fixDate = date("Y-m-d", $this->fixDate);
        return parent::afterFind();
    }

    public function afterSave(){
        if($this->getIsNewRecord()){
            //生成评论
            Helper::makeMultiComments($this->item_id);
        }
        return parent::afterSave();
    }

    /**
     * @param $type_id
     * @param string $date
     * @return mixed
     */
    public static function findByCondition($type_id, $date="", $category_id=0, $limit=10){
        $cacheKey = md5(__CLASS__.__FUNCTION__.$type_id.$date.$category_id);
        $cacheTime = 5 * 60;
        $cacheVal = Yii::app()->cache->get($cacheKey);

        if($cacheVal != null){
            $items = $cacheVal;
        }else{
            $criteria = new CDbCriteria();
            /*
            $criteria->addCondition("endtime>".time());
            */
            $criteria->addCondition("is_top=1");
            $criteria->addCondition("type_id={$type_id}");
            if(!empty($date)){
                $criteria->addCondition("fixDate=:fixDate");
                $criteria->params[':fixDate'] = $date;
            }
            if(!empty($category_id) && is_numeric($category_id)){
                $criteria->addCondition("category_id=:category_id");
                $criteria->params[':category_id'] = $category_id;
            }

            $criteria->limit = $limit;
            $criteria->order = "item_id desc";
            $items = Item::model()->findAll($criteria);

            if($items != null){
                Yii::app()->cache->set($cacheKey, $items, $cacheTime);
            }
        }

        return $items;
    }
}