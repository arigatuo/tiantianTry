<?php

/**
 * This is the model class for table "qfa_user_product".
 *
 * The followings are the available columns in table 'qfa_user_product':
 * @property string $uid
 * @property string $product_id
 * @property string $left_day
 * @property string $product_num
 * @property integer $status
 */
class UserProduct extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserProduct the static model class
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
		return 'qfa_user_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, product_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('uid', 'length', 'max'=>20),
			array('product_id, expireTime, noticeTime', 'length', 'max'=>10),
			array('left_day, product_num', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uid, product_id, left_day, product_num, status', 'safe', 'on'=>'search'),
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
			'product_id' => 'Product',
			'left_day' => 'Left Day',
			'product_num' => 'Product Num',
			'status' => 'Status',
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
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('left_day',$this->left_day,true);
		$criteria->compare('product_num',$this->product_num,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    /*
     * 购买道具
     */
    public static function userBuyOneProduct($productId, $uid){
        $return = 0;
        if(!empty($productId) && is_numeric($productId) && !empty($uid) && is_numeric($uid)){
            $userProductRecord = UserProduct::model()->findByAttributes(array(
                'uid' => $uid,
                'product_id' => $productId,
            ));

            $theProduct = Product::model()->findByPk($productId);
            $theProductAttributes = $theProduct->getAttributes();

            if(!empty($userProductRecord)){
                //原来有记录
                if($userProductRecord->getAttribute("product_num") > 0 ){
                    //已有此道具
                    $return = -3;
                }else{
                    if($userProductRecord->setAttribute("product_num", $userProductRecord->getAttribute("product_num")+1)){
                        $userProductRecord->setAttribute("expireTime", time() + 3600 * 24 * $theProductAttributes['productAvaDays']);
                        $userProductRecord->save() && $return = 1;
                    }
                }
            }else{
                //新记录
                $newRecord = new UserProduct();
                $newRecord->product_id = $productId;
                $newRecord->product_num = 1;
                $newRecord->uid = $uid;
                $newRecord->left_day = $theProductAttributes['productAvaDays'];
                $newRecord->expireTime = time() + 3600 * 24 * $theProductAttributes['productAvaDays'];

                if($newRecord->save()){
                    $return = 1;
                }

            }
        }

        if($return === 1){
            //发送消息
            $followArray = array(
                '1' => 'timeMachine',
                '2' => 'gotFirst',
            );
            $type = $followArray[$productId];
            $key = "firstBuy";
            Trigger::msgNotice($type, $key, $uid);
        }

        return $return;
    }

    /*
     * 用户是否有某个道具
     @param $productId 道具id
     @param $andReduceThat 读取后是否将数量减少
     */
    public static function isUserHaveThisProduct($productId, $andReductThat=0){
        $_return = 0;
        $userInfo = Userinfo::getUserId(0, 1);
        if(!empty($userInfo['userid']) && is_numeric($userInfo['userid']) && !empty($productId) && is_numeric($productId)){
            $found = self::model()->findByAttributes(array(
                'uid' => $userInfo['userid'],
                'product_id' => $productId,
            ));


            if(!empty($found)){
                //剩余天数
                $left_day = $found->getAttribute("left_day");
                //剩余产品数量
                $product_num = $found->getAttribute("product_num");

                if(!empty($product_num) && !empty($left_day)){
                    if(!empty($andReductThat)){
                        $left_num = $product_num - $andReductThat;
                    }
                    if(isset($left_num) && $left_num >= 0){
                        $found->setAttribute("product_num", $left_num);
                        if($found->save()){
                            Userinfo::getUserId(0, 1);
                        }else{
                            throw new HttpException('user record fail');
                        }
                    }
                    $_return = $left_day;
                }
            }
        }

        return $_return;
    }
}