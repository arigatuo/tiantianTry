<?php

/**
 * This is the model class for table "qfa_product".
 *
 * The followings are the available columns in table 'qfa_product':
 * @property string $productId
 * @property string $productName
 * @property string $productPrice
 * @property string $productDesc
 * @property string $productPhoto
 * @property string $productAvaDays
 */
class Product extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
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
		return 'qfa_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('productName, productPrice, productPhoto, productAvaDays', 'required'),
			array('productName, productDesc, productPhoto', 'length', 'max'=>255),
			array('productPrice', 'length', 'max'=>10),
			array('productAvaDays', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('productId, productName, productPrice, productDesc, productPhoto, productAvaDays', 'safe', 'on'=>'search'),
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
			'productId' => 'Product',
			'productName' => 'Product Name',
			'productPrice' => 'Product Price',
			'productDesc' => 'Product Desc',
			'productPhoto' => 'Product Photo',
			'productAvaDays' => 'Product Ava Days',
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

		$criteria->compare('productId',$this->productId,true);
		$criteria->compare('productName',$this->productName,true);
		$criteria->compare('productPrice',$this->productPrice,true);
		$criteria->compare('productDesc',$this->productDesc,true);
		$criteria->compare('productPhoto',$this->productPhoto,true);
		$criteria->compare('productAvaDays',$this->productAvaDays,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}