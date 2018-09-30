<?php

/**
 * UsersLogin class.
 * UsersLogin is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UsersForgetPassword extends CFormModel
{
	public $email;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('email', 'required'),
			array('email', 'CEmailValidator'),
			array('email','isRegistereduser'),
		);
	}
	public function isRegistereduser()
	{
		$user = Users::model()->find("`email`=:email", array(":email" => $this->email));
		if($user === null){
			$this->addError('email', 'پست الکترونیک وارد شده وجود ندارد.');
			return false;
		}else{
			return $this->hasToken($user);
		}
	}

	/**
	 * @param $user Users
	 * @return bool
	 */
	public function hasToken($user)
	{
		if($user->change_password_request_count == 3){
			$this->addError('email', 'بیش از 3 بار نمی توانید درخواست تغییر کلمه عبور بدهید.');
			return false;
		}else{
			return true;
		}
	}
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'ایمیل',
		);
	}
}
