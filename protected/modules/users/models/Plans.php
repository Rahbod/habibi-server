<?php

/**
 * This is the model class for table "{{plans}}".
 *
 * The followings are the available columns in table '{{plans}}':
 * @property string $id
 * @property string $title
 * @property string $rules
 * @property string $status
 *
 * The followings are the available model relations:
 * @property UserPlans[] $userPlans
 */
class Plans extends CActiveRecord
{
	const STATUS_DISABLED = 0;
	const STATUS_ENABLED = 1;
	public static $statusLabels = [
		0 => 'غیر فعال',
		1 => 'فعال',
	];

    public static $roleLabels = [
        'dealership' => 'نمایشگاه',
        'user' => 'کاربر عادی',
    ];

	public static $rulesFields = [
        'dealership' => [
			[
				'title'=>'مدت آگهی',
				'name'=>'adsDuration',
				'type' => 'num',
				'addon' => 'روز'
			],
			[
				'title'=>'تعداد آگهی مجاز',
				'name'=>'adsCount',
				'type' => 'num'
			],
			[
				'title'=>'تعداد تصویر آگهی',
				'name'=>'adsImageCount',
				'type' => 'num'
			],
			[
				'title'=>'تعداد به روز رسانی آگهی',
				'name'=>'adsUpdateCount',
				'type' => 'num',
				'addon' => 'بار'
			],
			[
				'title'=>'ارسال ایمیل و پیامک',
				'name'=>'notifySend',
				'type' => 'check'
			],
			[
				'title'=>'نمایش در صدر',
				'name'=>'showOnTop',
				'type' => 'check'
			],
			[
				'title'=>'اولویت در تایید',
				'name'=>'confirmPriority',
				'type' => 'check'
			],
			[
				'title'=>'نمایش در شبکه های اجتماعی',
				'name'=>'socialNetworks',
				'type' => 'check'
			],
			[
				'title'=>'نمایش در آگهی های مرتبط',
				'name'=>'relatedCars',
				'type' => 'check'
			],
			[
				'title'=>'تعرفه',
				'name'=>'price',
				'type' => 'num',
				'addon' => 'تومان'
			],
        ],
        'user' => [
			[
				'title'=>'مدت آگهی',
				'name'=>'adsDuration',
				'type' => 'num',
				'addon' => 'روز'
			],
            [
                'title'=>'تعداد آگهی مجاز',
                'name'=>'adsCount',
				'type' => 'num'
            ],
            [
                'title'=>'تعداد تصویر آگهی',
                'name'=>'adsImageCount',
				'type' => 'num'
            ],
			[
				'title'=>'تعداد به روز رسانی آگهی',
				'name'=>'adsUpdateCount',
				'type' => 'num',
				'addon' => 'بار'
			],
			[
				'title'=>'ارسال ایمیل و پیامک',
				'name'=>'notifySend',
				'type' => 'check'
			],
			[
				'title'=>'نمایش در صدر',
				'name'=>'showOnTop',
				'type' => 'check'
			],
			[
				'title'=>'اولویت در تایید',
				'name'=>'confirmPriority',
				'type' => 'check'
			],
            [
                'title'=>'نمایش در شبکه های اجتماعی',
                'name'=>'socialNetworks',
                'type' => 'check'
            ],
            [
                'title'=>'نمایش در آگهی های مرتبط',
                'name'=>'relatedCars',
                'type' => 'check'
            ],
            [
                'title'=>'تعرفه',
                'name'=>'price',
				'type' => 'num',
				'addon' => 'تومان'
            ],
        ],
    ];

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{plans}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title', 'length', 'max' => 255),
			array('rules', 'length', 'max' => 1024),
			array('status', 'length', 'max' => 1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, rules, status', 'safe', 'on' => 'search'),
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
			'userPlans' => array(self::HAS_MANY, 'UserPlans', 'plan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'title' => 'عنوان',
			'rules' => 'قوانین',
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

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('rules', $this->rules, true);
		$criteria->compare('status', $this->status, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Plans the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave()
	{
		$this->rules = $this->rules && is_array($this->rules) ? CJSON::encode($this->rules) : $this->rules;
		return parent::beforeSave(); // TODO: Change the autogenerated stub
	}

	protected function afterFind()
	{
		$this->rules = $this->rules ? CJSON::decode($this->rules) : null;
		parent::afterFind(); // TODO: Change the autogenerated stub
	}

    public function getRule($role, $name)
    {
        return $this->rules && isset($this->rules[$role]) && isset($this->rules[$role][$name]) && !empty($this->rules[$role][$name]) ? $this->rules[$role][$name] : null;
    }

	public function getRules($role)
    {
        return $this->rules && isset($this->rules[$role])? $this->rules[$role]: null;
    }

	public function getPrice($role)
	{
		return $this->getRule($role, 'price');
	}
	
	public function getCssClass(){
		switch($this->id){
			case 1:
				return 'green';
			case 2:
				return 'bronze';
			case 3:
				return 'silver';
			case 4:
				return 'gold';
			default:
				return '';
		}
	}
}