<?php

/**
 * This is the model class for table "{{contact_messages}}".
 *
 * The followings are the available columns in table '{{contact_messages}}':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $tel
 * @property string $subject
 * @property string $body
 * @property string $date
 * @property string $department_id
 * @property integer $seen
 * @property integer $reply
 *
 * The followings are the available model relations:
 * @property ContactDepartment $department
 */
class ContactMessages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contact_messages}}';
	}

	public $seenLabels =array(
		0 => 'مشاهده نشده',
		1 => 'مشاهده شده'
	);

	public $replyLabels =array(
		0 => 'پاسخ داده نشده',
		1 => 'پاسخ داده شده'
	);
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email,body,department_id', 'required'),
			array('seen, reply', 'numerical', 'integerOnly'=>true),
			array('name, email, tel, subject', 'length', 'max'=>255),
			array('body', 'length', 'max'=>1000),
			array('date', 'length', 'max'=>20),
			array('date', 'default', 'value'=>time()),
			array('department_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, email, tel, subject, body, date, department_id, seen, reply', 'safe', 'on'=>'search'),
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
			'department' => array(self::BELONGS_TO, 'ContactDepartment', 'department_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'name' => 'نام و نام خانوادگی',
			'email' => 'پست الکترونیک',
			'tel' => 'شماره تماس',
			'subject' => 'موضوع',
			'body' => 'متن پیام',
			'date' => 'تاریخ ارسال',
			'department_id' => 'بخش مورد نظر',
			'seen' => 'وضعیت مشاهده',
			'reply' => 'وضعیت پاسخ',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('department_id',$this->department_id,true);
		$criteria->compare('seen',$this->seen);
		$criteria->compare('reply',$this->reply);

		$criteria->order = 'seen, reply, date DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContactMessages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getRowCssClass(){
		if(!$this->seen)
			return 'unread';
		if(!$this->reply)
			return 'no-reply';
		return'';
	}
}
