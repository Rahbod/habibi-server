<?php

/**
 * This is the model class for table "{{invoices}}".
 *
 * The followings are the available columns in table '{{invoices}}':
 * @property string $id
 * @property string $request_id
 * @property string $creator_id
 * @property string $additional_cost
 * @property string $additional_description
 * @property string $payment_method
 * @property string $create_date
 * @property string $modified_date
 * @property string $final_cost
 * @property string $status
 * @property string $total_discount
 * @property string $discount_percent
 * @property string $credit_increase_percent
 * @property string $decrease_credit
 * @property string $decreased_credit
 *
 * The followings are the available model relations:
 * @property InvoiceItems[] $items
 * @property Tariffs[] $tariffs
 * @property Requests $request
 * @property Users $creator
 */
class Invoices extends CActiveRecord
{
    const STATUS_PREPARE = 2;
    const STATUS_ISSUING = 3;
    const STATUS_UNPAID = 0;
    const STATUS_PAID = 1;

	const PAYMENT_METHOD_CASH = 'cash';
	const PAYMENT_METHOD_GATEWAY = 'gateway';
	const PAYMENT_METHOD_POS = 'pos';

    public static $paymentMethodLabels = [
        self::PAYMENT_METHOD_CASH => 'پرداخت نقدی',
        self::PAYMENT_METHOD_POS => 'پرداخت با کارتخوان',
    ];

    public $formItems;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{invoices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_id, creator_id, create_date, modified_date', 'required'),
			array('total_discount, request_id, creator_id, additional_cost, final_cost, decreased_credit', 'length', 'max'=>10),
			//array('discount_percent, credit_increase_percent', 'length', 'max'=>3),
			array('payment_method', 'length', 'max'=>7),
			array('status, decrease_credit', 'length', 'max'=>1),
			array('create_date, modified_date', 'length', 'max'=>12),
			array('additional_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, total_discount, discount_percent, credit_increase_percent, request_id, creator_id, additional_cost, additional_description, payment_method, create_date, modified_date, final_cost', 'safe', 'on'=>'search'),
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
			'items' => array(self::HAS_MANY, 'InvoiceItems', 'invoice_id'),
			'tariffs' => array(self::MANY_MANY, 'Tariffs', '{{invoice_items}}(invoice_id, tariff_id)'),
			'request' => array(self::BELONGS_TO, 'Requests', 'request_id'),
			'creator' => array(self::BELONGS_TO, 'Users', 'creator_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'request_id' => 'شناسه درخواست',
            'creator_id' => 'صادرکننده',
            'additional_cost' => 'هزینه جانبی',
            'additional_description' => 'توضیحات',
            'payment_method' => 'نوع پرداخت',
            'create_date' => 'تاریخ صدور',
            'modified_date' => 'تاریخ تغییرات',
            'final_cost' => 'هزینه کل',
            'status' => 'وضعیت',
            'total_discount' => 'جمع تخفیفات',
            'discount_percent' => 'تخفیف',
            'credit_increase_percent' => 'تخصیص اعتبار به کاربر',
            'decrease_credit' => 'کسر از اعتبار',
            'decreased_credit' => 'مبلغ کسر شده از اعتبار',
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
		$criteria->compare('request_id',$this->request_id,true);
		$criteria->compare('creator_id',$this->creator_id,true);
		$criteria->compare('additional_cost',$this->additional_cost,true);
		$criteria->compare('additional_description',$this->additional_description,true);
		$criteria->compare('payment_method',$this->payment_method,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('final_cost',$this->final_cost,true);
		$criteria->compare('total_discount',$this->total_discount,true);
		$criteria->compare('discount_percent',$this->discount_percent,true);
		$criteria->compare('credit_increase_percent',$this->credit_increase_percent,true);
		$criteria->compare('decrease_credit',$this->decrease_credit,true);
		$criteria->compare('decreased_credit',$this->decreased_credit,true);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Invoices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	protected function afterSave()
    {
        parent::afterSave();

        if ($this->formItems) {
            if(!$this->isNewRecord) {
                // delete not in form
                foreach ($this->items as $item) {
                    if (!in_array($item->tariff_id, array_keys($this->formItems)))
                        $item->delete();
                }
            }

            foreach ($this->formItems as $tariffID => $value){
                if($tariff = Tariffs::model()->findByPk($tariffID)) {
                    $model = new InvoiceItems();
                    $model->invoice_id = $this->id;
                    $model->tariff_id = $tariffID;
                    $model->cost = $tariff->cost;
                    @$model->save();
                }
            }
        }
    }

	public function totalCost()
	{
		$itemsCost = 0;
		foreach($this->items as $item)
			$itemsCost += floatval($item->cost);

		return $itemsCost + floatval($this->additional_cost);
	}

	public function totalTariffs()
	{
		$itemsCost = 0;
		foreach($this->items as $item)
			if($item->tariff->type == Tariffs::TYPE_TARIFF)
				$itemsCost += floatval($item->cost);

		return $itemsCost;
	}

    public function finalCost()
	{
        return $this->totalCost() - $this->totalDiscount();
	}

    public function totalDiscount()
	{
        $total = $this->totalTariffs();
		return ($total * $this->discount_percent) / 100;
	}

    public function creditIncrease()
    {
        return ($this->totalTariffs() * $this->credit_increase_percent) / 100;
    }
}