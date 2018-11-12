<?php

/**
 * This is the model class for table "{{requests}}".
 *
 * The followings are the available columns in table '{{requests}}':
 * @property string $id
 * @property string $category_id
 * @property string $brand_id
 * @property string $model_id
 * @property string $user_id
 * @property string $user_address_id
 * @property string $operator_id
 * @property string $repairman_id
 * @property string $create_date
 * @property string $modified_date
 * @property string $description
 * @property integer $requested_date
 * @property string $requested_time
 * @property string $service_date
 * @property string $service_time
 * @property string $status
 * @property string $request_type
 *
 * The followings are the available model relations:
 * @property Invoices[] $invoices
 * @property Categories $category
 * @property Brands $brand
 * @property Models $model
 * @property Users $user
 * @property Admins $operator
 * @property Users $repairman
 * @property UserAddresses $userAddress
 */
class Requests extends CActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_PENDING = 1;
    const STATUS_OPERATOR_CHECKING = 2;
    const STATUS_CONFIRMED = 3;
    const STATUS_INVOICING = 4;
    const STATUS_AWAITING_PAYMENT = 5;
    const STATUS_PAID = 6;
    const STATUS_DONE = 7;

    const REQUEST_FROM_APP_ANDROID = 1;
    const REQUEST_FROM_APP_IOS = 2;
    const REQUEST_FROM_CALL = 3;
    const REQUEST_OFFLINE = 4;

    public $statusLabels = array(
        self::STATUS_DELETED => 'معلق',
        self::STATUS_PENDING => 'در انتظار بررسی',
        self::STATUS_OPERATOR_CHECKING => 'در حال بررسی اپراتور',
        self::STATUS_CONFIRMED => 'تایید شده',
        self::STATUS_INVOICING => 'صدور فاکتور',
        self::STATUS_AWAITING_PAYMENT => 'در انتظار پرداخت',
        self::STATUS_PAID => 'پرداخت شده',
        self::STATUS_DONE => 'انجام شده',
    );

    public $requestTypeLabels = array(
        self::REQUEST_FROM_APP_ANDROID => 'نرم افزار اندروید',
        self::REQUEST_FROM_APP_IOS => 'نرم افزار آی او اس',
        self::REQUEST_FROM_CALL => 'تماس تلفنی',
        self::REQUEST_OFFLINE => 'درخواست آفلاین',
    );

    public static $serviceTimes = ['am' => 'صبح - 8 تا 12', 'pm' => 'عصر - 12 تا 18', 'night' => 'شب - 18 تا 22'];

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{requests}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('request_type,category_id, user_id, user_address_id, operator_id, requested_date', 'required'),
            array('request_type,requested_date', 'numerical', 'integerOnly' => true),
            array('category_id, brand_id, model_id, user_id, user_address_id, operator_id, repairman_id', 'length', 'max' => 10),
            array('create_date, modified_date, service_date', 'length', 'max' => 12),
            array('create_date', 'default', 'value' => time()),
            array('modified_date', 'default', 'value' => time()),
            array('requested_time, service_time', 'length', 'max' => 255),
            array('request_type, status', 'length', 'max' => 1),
            array('description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, request_type, category_id, brand_id, model_id, user_id, user_address_id, operator_id, repairman_id, create_date, modified_date, description, requested_date, requested_time, service_date, service_time, status', 'safe', 'on' => 'search'),
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
            'invoices' => array(self::HAS_MANY, 'Invoices', 'request_id'),
            'category' => array(self::BELONGS_TO, 'Categories', 'category_id'),
            'brand' => array(self::BELONGS_TO, 'Brands', 'brand_id'),
            'model' => array(self::BELONGS_TO, 'Models', 'model_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'operator' => array(self::BELONGS_TO, 'Admins', 'operator_id'),
            'repairman' => array(self::BELONGS_TO, 'Users', 'repairman_id'),
            'userAddress' => array(self::BELONGS_TO, 'UserAddresses', 'user_address_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'شناسه درخواست',
            'category_id' => 'نوع لوازم',
            'brand_id' => 'برند دستگاه',
            'model_id' => 'مدل دستگاه',
            'user_id' => 'کاربر',
            'user_address_id' => 'آدرس محل',
            'operator_id' => 'اپراتور',
            'repairman_id' => 'تعمیرکار',
            'create_date' => 'تاریخ ثبت',
            'modified_date' => 'تاریخ تغییرات',
            'description' => 'توضیحات کاربر',
            'requested_date' => 'تاریخ حضور درخواستی',
            'requested_time' => 'زمان حضور درخواستی',
            'service_date' => 'تاریخ سرویس',
            'service_time' => 'زمان سرویس',
            'status' => 'وضعیت درخواست',
            'request_type' => 'نوع درخواست',
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
    public function search($recycleBin = false)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('brand_id', $this->brand_id, true);
        $criteria->compare('model_id', $this->model_id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('user_address_id', $this->user_address_id, true);
        $criteria->compare('operator_id', $this->operator_id, true);
        $criteria->compare('repairman_id', $this->repairman_id, true);
        $criteria->compare('create_date', $this->create_date, true);
        $criteria->compare('modified_date', $this->modified_date, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('requested_date', $this->requested_date);
        $criteria->compare('requested_time', $this->requested_time, true);
        $criteria->compare('service_date', $this->service_date, true);
        $criteria->compare('service_time', $this->service_time, true);
        $criteria->compare('request_type', $this->request_type);
        if ($recycleBin)
            $criteria->addCondition('status = -1');
        else {
            $criteria->compare('status', $this->status);
            $criteria->addCondition('status > 0');
        }

        $criteria->order = 'id';

        if (isset($_GET['pendingAjax'])) {
            if (isset($_GET['last']))
                $criteria->compare('id', ' >'.(int)$_GET['last']);

            $result = [];
            $result['count'] = self::model()->countByAttributes(['status' => Requests::STATUS_PENDING]);

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

        $config = [
            'criteria' => $criteria
        ];

        if(Yii::app()->controller->route === 'requests/manage/pending')
            $config['pagination'] = false;

        return new CActiveDataProvider($this, $config);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CActiveRecord
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function beforeSave()
    {
        $this->modified_date = time();
        return parent::beforeSave(); // TODO: Change the autogenerated stub
    }

    /**
     * @param bool $cssClass
     * @return mixed
     */
    public function getStatusLabel($cssClass = false)
    {
        if ($cssClass) {
            switch ($this->status) {
                case self::STATUS_PAID:
                case self::STATUS_CONFIRMED:
                    return 'success';
                case self::STATUS_DELETED:
                    return 'danger';
                case self::STATUS_OPERATOR_CHECKING:
                case self::STATUS_AWAITING_PAYMENT:
                    return 'warning';
                case self::STATUS_PENDING:
                case self::STATUS_INVOICING:
                    return 'info';
                case self::STATUS_DONE:
                    return 'primary';
                default:
                    return 'default';
            }
        }
        return $this->statusLabels[$this->status];
    }

    /**
     * @param bool $icon
     * @return mixed
     */
    public function getRequestTypeLabel($icon = false)
    {
        if ($icon) {
            switch ($this->request_type) {
                case self::REQUEST_FROM_CALL:
                    return "<span class='text-success fa fa-phone' data-toggle='tooltip' data-placement='top' title='{$this->getRequestTypeLabel()}'></span>";
                case self::REQUEST_FROM_APP_ANDROID:
                    return "<span class='text-success fa fa-android' data-toggle='tooltip' data-placement='top' title='{$this->getRequestTypeLabel()}'></span>";
                case self::REQUEST_FROM_APP_IOS:
                    return "<span class='text-gray fa fa-apple' data-toggle='tooltip' data-placement='top' title='{$this->getRequestTypeLabel()}'></span>";
                case self::REQUEST_OFFLINE:
                    return "<span class='text-danger fa fa-power-off' data-toggle='tooltip' data-placement='top' title='{$this->getRequestTypeLabel()}'></span>";
                default:
                    return '';
            }
        }
        return $this->requestTypeLabels[$this->request_type];
    }

    public function getLastInvoice()
    {
        return Invoices::model()->findByAttributes(['request_id' => $this->id, 'status' => Invoices::STATUS_UNPAID]);
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