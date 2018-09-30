<?php

/**
 * This is the model class for table "{{user_plans}}".
 *
 * The followings are the available columns in table '{{user_plans}}':
 * @property string $id
 * @property string $user_id
 * @property string $plan_id
 * @property string $expire_date
 * @property string $join_date
 * @property integer $price
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Plans $plan
 */
class UserPlans extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_plans}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price', 'numerical', 'integerOnly' => true),
			array('user_id, plan_id', 'length', 'max' => 10),
			array('expire_date, join_date', 'length', 'max' => 20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, plan_id, expire_date, join_date, price', 'safe', 'on' => 'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'plan' => array(self::BELONGS_TO, 'Plans', 'plan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'plan_id' => 'Plan',
			'expire_date' => 'Expire Date',
			'join_date' => 'Join Date',
			'price' => 'Price',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('plan_id', $this->plan_id, true);
		$criteria->compare('expire_date', $this->expire_date, true);
		$criteria->compare('join_date', $this->join_date, true);
		$criteria->compare('price', $this->price);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserPlans the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function isExpired()
	{
		if($this->expire_date === -1)
			return false;
		else if($this->expire_date && $this->expire_date < time())
			return false;
		return true;
	}
}