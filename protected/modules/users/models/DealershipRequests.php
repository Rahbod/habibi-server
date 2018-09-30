<?php

/**
 * This is the model class for table "{{dealership_requests}}".
 *
 * The followings are the available columns in table '{{dealership_requests}}':
 * @property integer $id
 * @property string $dealership_name
 * @property string $manager_name
 * @property string $manager_last_name
 * @property string $creator_name
 * @property string $creator_mobile
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $description
 * @property string $status
 * @property string $create_date
 * @property string $state_id
 */
class DealershipRequests extends CActiveRecord
{
	const STATUS_PENDING = 0;
	const STATUS_SAVED = 1;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dealership_requests}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dealership_name, creator_name, creator_mobile, address, phone, email, state_id', 'required'),
			array('dealership_name, manager_name, manager_last_name, creator_name, email', 'length', 'max'=>255),
			array('creator_mobile, phone, state_id', 'length', 'max'=>11),
			array('create_date', 'length', 'max'=>20),
			array('create_date', 'default', 'value'=>time()),
			array('status', 'length', 'max'=>1),
			array('status', 'default', 'value'=>0),
			array('description', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dealership_name, manager_name, state_id, manager_last_name, creator_name, creator_mobile, address, phone, email, description', 'safe', 'on'=>'search'),
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
			'state' => array(self::BELONGS_TO, 'Towns', 'state_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'dealership_name' => 'نام نمایشگاه',
			'manager_name' => 'نام مدیر',
			'manager_last_name' => 'نام خانوادگی مدیر',
			'creator_name' => 'نام ثبت کننده',
			'creator_mobile' => 'شماره تماس',
			'address' => 'نشانی نمایشگاه',
			'phone' => 'تلفن ثابت نمایشگاه',
			'email' => 'پست الکترونیک',
			'description' => 'توضیحات',
			'create_date' => 'تاریخ ثبت',
			'state_id' => 'استان',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('dealership_name',$this->dealership_name,true);
		$criteria->compare('manager_name',$this->manager_name,true);
		$criteria->compare('manager_last_name',$this->manager_last_name,true);
		$criteria->compare('creator_name',$this->creator_name,true);
		$criteria->compare('creator_mobile',$this->creator_mobile,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('state_id',$this->state_id);
		$criteria->addCondition('status = :pending');
		$criteria->params[':pending'] = DealershipRequests::STATUS_PENDING;
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => 20)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealershipRequests the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
