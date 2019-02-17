<?php

/**
 * This is the model class for table "{{tariffs}}".
 *
 * The followings are the available columns in table '{{tariffs}}':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $cost
 * @property int $type
 *
 * The followings are the available model relations:
 * @property Invoices[] $ymInvoices
 */
class Tariffs extends CActiveRecord
{
	const TYPE_TARIFF = 0;
	const TYPE_PIECE = 1;

	public static $typeLabels = [
		self::TYPE_TARIFF => 'اجرت',
		self::TYPE_PIECE => 'قطعه'
	];

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tariffs}}';
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
			array('title', 'length', 'max'=>255),
			array('description', 'length', 'max'=>1024),
			array('cost', 'length', 'max'=>10),
			array('type', 'length', 'max'=>1),
            array('type', 'numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, cost, type', 'safe', 'on'=>'search'),
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
			'invoices' => array(self::MANY_MANY, 'Invoices', '{{invoice_items}}(tariff_id, invoice_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'عنوان',
			'description' => 'توضیحات',
			'cost' => 'مبلغ',
			'type' => 'نوع',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('type',$this->type);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tariffs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave()
    {
        $this->cost = $this->cost?str_replace(',', '',$this->cost):0;
        return parent::beforeSave();
    }

	public function getTitleCost()
	{
		return $this->title . ($this->id != 1?' - ' . number_format($this->cost) . ' تومان':'');
	}
}
