<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class DealershipRequestForm extends CFormModel
{
    public $dealership_name;
    public $manager_name;
    public $manager_last_name;
    public $creator_name;
    public $creator_mobile;
    public $address;
    public $phone;
    public $email;
    public $description;
    public $state_id;
    public $verifyCode;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('dealership_name, creator_name, creator_mobile, address, phone, email, state_id', 'required'),
            array('email', 'email'),
            array('email', 'unique', 'className' => 'Users', 'message' => 'پست الکترونیک وارد شده قبلا در سیستم ثبت شده است.'),
            array('dealership_name, manager_name, manager_last_name, creator_name, email', 'length', 'max' => 255),
            array('creator_mobile, phone, state_id', 'length', 'max' => 11, 'message' => '{attribute} باید 11 رقم باشد.'),
            array('creator_mobile', 'length', 'is' => 11),
            array('description', 'length', 'max' => 512),
//            array('verifyCode', 'activeCaptcha'),
        );
    }

    public function activeCaptcha()
    {
        $code = Yii::app()->controller->createAction('captcha')->verifyCode;
        if(empty($code))
            $this->addError('verifyCode', 'کد امنیتی نمی تواند خالی باشد.');
        elseif($code != $this->verifyCode)
            $this->addError('verifyCode', 'کد امنیتی نامعتبر است.');
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'dealership_name' => 'نام نمایشگاه',
            'manager_name' => 'نام مدیر',
            'manager_last_name' => 'نام خانوادگی مدیر',
            'creator_name' => 'نام شما',
            'creator_mobile' => 'شماره همراه شما',
            'address' => 'نشانی نمایشگاه',
            'phone' => 'تلفن ثابت نمایشگاه (همراه با کد استان)',
            'email' => 'پست الکترونیک',
            'description' => 'توضیحات',
            'verifyCode' => 'کد امنیتی',
            'state_id' => 'استان',
        );
    }
}