<?php

/**
 * This is the model class for table "{{invoice_items}}".
 *
 * The followings are the available columns in table '{{invoice_items}}':
 * @property string $invoice_id
 * @property string $piece_id
 * @property string $tariff_id
 * @property string $cost
 * @property string $piece_title
 * @property string $piece_cost
 * @property string $tariff_title
 * @property string $tariff_cost
 *
 * The followings are the available model relations:
 * @property Invoices $invoice
 * @property Tariffs $tariff
 */
class InvoiceItems extends CActiveRecord
{
	public $piece_title;
	public $piece_cost;
	public $tariff_title;
	public $tariff_cost;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{invoice_items}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('invoice_id, tariff_id, cost', 'required'),
			array('invoice_id, tariff_id, cost', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('invoice_id, tariff_id, cost', 'safe', 'on'=>'search'),
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
			'tariff' => array(self::BELONGS_TO, 'Tariffs', 'tariff_id'),
			'invoice' => array(self::BELONGS_TO, 'Invoices', 'invoice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'invoice_id' => 'شناسه فاکتور',
            'piece_id' => 'قطعه',
            'tariff_id' => 'اجرت',
            'cost' => 'مبلغ',
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

		$criteria->compare('invoice_id',$this->invoice_id,true);
		$criteria->compare('tariff_id',$this->tariff_id,true);
		$criteria->compare('cost',$this->cost,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InvoiceItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function afterFind()
	{
		parent::afterFind();

		if ($this->tariff->type == Tariffs::TYPE_PIECE) {
			$this->piece_title = $this->tariff->title;
			$this->piece_cost = $this->cost;
		} else {
			$this->tariff_title = $this->tariff->title;
			$this->tariff_cost = $this->cost;
		}
	}
}
