<?php

/**
 * This is the model class for table "{{users_addresses}}".
 *
 * The followings are the available columns in table '{{users_addresses}}':
 * @property string $id
 * @property string $user_id
 * @property string $transferee
 * @property string $emergency_tel
 * @property string $landline_tel
 * @property string $town_id
 * @property string $place_id
 * @property string $district
 * @property string $postal_address
 * @property string $postal_code
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Towns $town
 * @property Places $place
 */
class UserAddresses extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user_addresses}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, transferee, emergency_tel, landline_tel, town_id, place_id, postal_address, postal_code', 'required'),
            array('user_id, town_id, place_id, postal_code', 'length', 'max' => 10),
            array('transferee', 'length', 'max' => 255),
            array('emergency_tel', 'length', 'max' => 11),
            array('landline_tel', 'length', 'max' => 15),
            array('district', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, transferee, emergency_tel, landline_tel, town_id, place_id, district, postal_address, postal_code', 'safe', 'on' => 'search'),
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
            'town' => array(self::BELONGS_TO, 'Towns', 'town_id'),
            'place' => array(self::BELONGS_TO, 'Places', 'place_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'کاربر',
            'transferee' => 'نام کامل میزبان',
            'emergency_tel' => 'شماره تماس اضطراری',
            'landline_tel' => 'تلفن ثابت',
            'town_id' => 'استان',
            'place_id' => 'شهرستان',
            'district' => 'محله',
            'postal_address' => 'آدرس پستی',
            'postal_code' => 'کد پستی',
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
        $criteria->compare('transferee', $this->transferee, true);
        $criteria->compare('emergency_tel', $this->emergency_tel, true);
        $criteria->compare('landline_tel', $this->landline_tel, true);
        $criteria->compare('town_id', $this->town_id, true);
        $criteria->compare('place_id', $this->place_id, true);
        $criteria->compare('district', $this->district, true);
        $criteria->compare('postal_address', $this->postal_address, true);
        $criteria->compare('postal_code', $this->postal_code, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserAddresses the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param $userID
     * @param bool $count
     * @return UserAddresses[]|string
     */
    public static function getList($userID, $count = false)
    {
        if ($count)
            return self::model()->countByAttributes(['user_id' => $userID]);
        $data = self::model()->findAllByAttributes(['user_id' => $userID]);
        return $data;
    }
}
