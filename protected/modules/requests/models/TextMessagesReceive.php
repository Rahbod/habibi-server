<?php

/**
 * This is the model class for table "{{text_messages_receive}}".
 *
 * The followings are the available columns in table '{{text_messages_receive}}':
 * @property string $id
 * @property string $sender
 * @property string $to
 * @property string $text
 * @property string $sms_date
 * @property string $create_date
 * @property string $status
 */
class TextMessagesReceive extends CActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_CHECKED = 1;


    public $statusLabels = [
        self::STATUS_PENDING => 'در انتظار بررسی',
        self::STATUS_CHECKED => 'بررسی شده',
    ];

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{text_messages_receive}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sender, to, text, create_date, sms_date', 'required'),
			array('create_date', 'numerical', 'integerOnly'=>true),
			array('sender, to', 'length', 'max'=>15),
			array('sms_date', 'length', 'max'=>30),
			array('status', 'length', 'max'=>1),
			array('status', 'default', 'value'=>0),
			array('text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sender, to, text, create_date, sms_date', 'safe', 'on'=>'search'),
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
			'sender' => 'فرستنده',
			'to' => 'دریافت کننده',
			'text' => 'متن',
			'create_date' => 'تاریخ دریافت',
			'sms_date' => 'تاریخ پیامک',
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
	 * @return array|CActiveDataProvider
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('sender',$this->sender,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('sms_date',$this->sms_date,true);

		$criteria->order = 'id';

        if (isset($_GET['pendingAjax'])) {
            if (isset($_GET['last']))
                $criteria->compare('id', ' >'.(int)$_GET['last']);

            $result = [];
            $result['count'] = self::model()->countByAttributes(['status' => TextMessagesReceive::STATUS_PENDING]);

            if(isset($_GET['table'])) {
                Yii::app()->controller->beginClip('table');
                foreach (self::model()->findAll($criteria) as $data) {
                    Yii::app()->controller->renderPartial('_item_view', array('data' => $data));
                }
                Yii::app()->controller->endClip();
                $result['table'] = Yii::app()->controller->clips['table'];
            }

            if(isset($_GET['push'])) {
                Yii::app()->controller->beginClip('push');
                foreach (self::model()->findAll($criteria) as $data) {
                    Yii::app()->controller->renderPartial('_push_view', array('data' => $data));
                }
                Yii::app()->controller->endClip();
                $result['push'] = Yii::app()->controller->clips['push'];
            }

            $result['last'] = $this->getMaxID();
            return $result;
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TextMessagesReceive the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @return mixed
     */
    public static function getMaxID()
    {
        $max = self::model()->find(array('order' => 'id DESC'));
        return $max ? $max->id : 0;
    }
}