<?php

/**
 * This is the model class for table "{{categories}}".
 *
 * The followings are the available columns in table '{{categories}}':
 * @property string $id
 * @property string $title
 * @property string $logo
 * @property string $parent_id
 *
 * The followings are the available model relations:
 * @property Requests[] $requests
 * @property Categories $parent
 */
class Categories extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{categories}}';
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
            array('title, logo', 'length', 'max' => 255),
            array('parent_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, logo', 'safe', 'on' => 'search'),
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
            'requests' => array(self::HAS_MANY, 'Requests', 'category_id'),
            'parent' => array(self::BELONGS_TO, 'Categories', 'parent_id'),
            'childes' => array(self::HAS_MANY, 'Categories', 'parent_id'),
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
            'logo' => 'تصویر',
            'parent_id' => 'والد',
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
        $criteria->compare('logo', $this->logo, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->order = 'id DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Categories the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getList()
    {
        $data = Categories::model()->findAll();
        return $data ? CHtml::listData($data, 'id', function ($data){ return $data->getShowTitle(); }) : [];
    }

    public function getShowTitle()
    {
        return $this->parent_id ? "{$this->parent->title} / {$this->title}" : $this->title;
    }

    public function showParent()
    {
        return $this->parent ? $this->parent->title : '--';
    }

    public static function Parents($array = true)
    {
        $models = self::model()->findAll('parent_id IS NULL');
        return $array ? CHtml::listData($models, 'id', 'title') : $models;
    }

    protected function beforeSave(){
        if(!$this->parent_id)
            $this->parent_id = null;
        return parent::beforeSave();
    }
}