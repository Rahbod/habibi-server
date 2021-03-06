<?php

/**
 * This is the model class for table "{{cooperation_requests}}".
 *
 * The followings are the available columns in table '{{cooperation_requests}}':
 * @property string $id
 * @property string $name
 * @property string $mobile
 * @property string $expertise
 * @property string $experience_level
 * @property string $create_date
 * @property string $status
 */
class CooperationRequests extends CActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_REVIEWED = 1;

    public static $statusLabels= [
        self::STATUS_PENDING => 'در انتظار بررسی',
        self::STATUS_REVIEWED => 'بررسی شده'
    ];

    /**
     * @return array
     */
    public function getStatusLabel()
    {
        return self::$statusLabels[$this->status];
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cooperation_requests}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, mobile', 'required'),
			array('name, expertise, experience_level', 'length', 'max'=>255),
			array('mobile', 'length', 'max'=>11),
			array('create_date', 'length', 'max'=>20),
			array('create_date', 'default', 'value'=>time()),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, mobile, expertise, experience_level, create_date, status', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'name' => 'نام و نام خانوادگی',
			'mobile' => 'شماره موبایل',
			'expertise' => 'تخصص',
			'experience_level' => 'میزان تجربه',
			'create_date' => 'تاریخ ثبت درخواست',
			'status' => 'وضعیت',
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
		$criteria->compare('id',$this->id,true);
		$criteria->compare('first_name',$this->name,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('expertise',$this->expertise,true);
		$criteria->compare('experience_level',$this->experience_level,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('status',$this->status,true);
		$criteria->order = 'status ASC, create_date DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CooperationRequests the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
