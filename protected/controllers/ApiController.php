<?php
class ApiController extends ApiBaseController
{
    protected $request = null;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'RestAccessControl + register, verify',
            'RestAuthControl - register, verify',
        );
    }

    public function beforeAction($action)
    {
        $this->request = $this->getRequest();
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * Register user by mobile number
     */
    public function actionRegister()
    {
        if (isset($this->request['mobile'])) {
            $mobile = $this->request['mobile'];
            $user = Users::model()->find('username = :mobile', [':mobile' => $mobile]);

            $code = Controller::generateRandomInt();
            if (!$user) {
                $user = new Users();
                $user->username = $mobile;
                $user->password = $mobile;
                $user->status = Users::STATUS_PENDING;
            }

            $user->verification_token = $code;
            $user->save();

            Notify::SendSms("کد فعال سازی شما در آچاره:\n" . $code, $mobile);

            $this->_sendResponse(200, CJSON::encode(['status' => true]), 'application/json');
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'Mobile variable is required.']), 'application/json');
    }

    /**
     * Verify sent code
     */
    public function actionVerify()
    {
        if (isset($this->request['mobile']) and isset($this->request['code'])) {
            $mobile = $this->request['mobile'];
            $code = $this->request['code'];
            $user = Users::model()->find('username = :mobile', [':mobile' => $mobile]);

            if (!$user)
                $this->_sendResponse(404, CJSON::encode([
                    'status' => false,
                    'message' => 'User not found.'
                ]), 'application/json');

            if ($user->verification_token == $code) {
                // Change user status
                $user->status = Users::STATUS_ACTIVE;
                $user->save();

                // Login user
                $login = new UserLoginForm;
                $login->scenario = 'app_login';
                $login->verification_field_value = $mobile;
                $login->password = $mobile;
                if ($login->validate() && $login->login()) {
                    $this->_sendResponse(200, CJSON::encode([
                        'status' => true,
                        'authorization_code' => session_id()
                    ]), 'application/json');
                } else
                    $this->_sendResponse(400, CJSON::encode([
                        'status' => false,
                        'message' => $login->getError('authenticate_field')
                    ]), 'application/json');
            } else
                $this->_sendResponse(400, CJSON::encode([
                    'status' => false,
                    'message' => 'کد وارد شده اشتباه است.'
                ]), 'application/json');
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'Mobile and Code variables is required.']), 'application/json');
    }

    /**
     * Set name and token to user profile
     */
    public function actionSetName()
    {
        if (isset($this->request['name']) and isset($this->request['token'])) {
            /* @var $userDetails UserDetails */
            $userDetails = UserDetails::model()->findByAttributes(['user_id' => $this->user->id]);
            $userDetails->first_name = $this->request['name'];
            $userDetails->mobile = $this->user->username;
            $userDetails->push_token = $this->request['token'];
            if ($userDetails->save())
                $this->_sendResponse(200, CJSON::encode(['status' => true, 'message' => 'اطلاعات با موفقیت ثبت شد.']), 'application/json');
            else
                $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'در ثبت اطلاعات خطایی رخ داده است. لطفا مجددا تلاش کنید.']), 'application/json');
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'Name and Token variables is required.']), 'application/json');
    }

    /**
     * Set token to user profile
     */
    public function actionSetToken()
    {
        if (isset($this->request['token'])) {
            /* @var $userDetails UserDetails */
            $userDetails = UserDetails::model()->findByAttributes(['user_id' => $this->user->id]);
            $userDetails->push_token = $this->request['token'];
            if ($userDetails->save())
                $this->_sendResponse(200, CJSON::encode(['status' => true]), 'application/json');
            else
                $this->_sendResponse(400, CJSON::encode(['status' => false]), 'application/json');
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'Token variable is required.']), 'application/json');
    }

    /**
     * Get list of devices
     */
    public function actionDevices()
    {
        Yii::import('application.modules.requests.models.*');
        $devices = [];

        foreach (Categories::model()->findAll() as $category)
            $devices[] = [
                'id' => intval($category->id),
                'title' => $category->title,
                'icon' => Yii::app()->getBaseUrl(true) . '/uploads/categories/' . $category->logo,
            ];

        $this->_sendResponse(200, CJSON::encode([
            'status' => true,
            'list' => $devices
        ]), 'application/json');
    }

    /**
     * Get list of user addresses
     */
    public function actionAddresses()
    {
        $addresses = [];

        foreach ($this->user->addresses as $address)
            $addresses[] = [
                'id' => intval($address->id),
                'telephone' => $address->emergency_tel,
                'address' => $address->postal_address,
            ];

        $this->_sendResponse(200, CJSON::encode([
            'status' => true,
            'list' => $addresses
        ]), 'application/json');
    }

    /**
     * Insert new address
     */
    public function actionNewAddress()
    {
        if (isset($this->request['telephone']) and isset($this->request['address'])) {
            /* @var $address UserAddresses */
            $address = new UserAddresses();
            $address->user_id = $this->user->id;
            $address->town_id = 19;
            $address->place_id = 274;
            $address->emergency_tel = $this->request['telephone'];
            $address->postal_address = $this->request['address'];
            if ($address->save())
                $this->_sendResponse(200, CJSON::encode([
                    'status' => true,
                    'message' => 'اطلاعات با موفقیت ثبت شد.',
                    'address' => [
                        'id' => intval($address->id),
                        'telephone' => $address->emergency_tel,
                        'address' => $address->postal_address,
                    ]
                ]), 'application/json');
            else
                $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'در ثبت اطلاعات خطایی رخ داده است. لطفا مجددا تلاش کنید.']), 'application/json');
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'Telephone and Address variables is required.']), 'application/json');
    }

    /**
     * Insert new request
     */
    public function actionRequest()
    {
        if (isset($this->request['deviceID'])
            and isset($this->request['addressID'])
            and isset($this->request['description'])
            and isset($this->request['date'])
            and isset($this->request['time'])
        ) {
            Yii::app()->getModule('requests');

            $jDate = explode('/', $this->request['date']);
            $gDate = JalaliDate::toGregorian($jDate[0], $jDate[1], $jDate[2]);

            $request = new Requests();
            $request->setScenario('request_by_app');
            $request->category_id = $this->request['deviceID'];
            $request->user_id = $this->user->id;
            $request->user_address_id = $this->request['addressID'];
            $request->description = $this->request['description'];
            $request->requested_date = strtotime($gDate[0] . '/' . $gDate[1] . '/' . $gDate[2]);
            $request->requested_time = $this->request['time'];
            $request->status = Requests::STATUS_PENDING;
            $request->request_type = Requests::REQUEST_FROM_APP_ANDROID;

            if ($request->save())
                $this->_sendResponse(200, CJSON::encode([
                    'status' => true,
                    'message' => 'اطلاعات با موفقیت ثبت شد.',
                ]), 'application/json');
            else
                $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'در ثبت اطلاعات خطایی رخ داده است. لطفا مجددا تلاش کنید.']), 'application/json');
        } else
            $this->_sendResponse(400, CJSON::encode([
                'status' => false,
                'message' => 'Device ID, Address ID, Description, Date and Time variables is required.']), 'application/json');
    }

    /**
     * Get list of user requests
     */
    public function actionRequests()
    {
        $requests = [];

        foreach ($this->user->requests as $request) {
            $date = $request->service_date ?: $request->requested_date;

            $temp = [
                'id' => intval($request->id),
                'device' => $request->category->title,
                'date' => JalaliDate::date("d F Y", $date),
                'status' => intval($request->status),
            ];

            $requests[] = $temp;
        }

        $this->_sendResponse(200, CJSON::encode([
            'status' => true,
            'list' => $requests,
        ]), 'application/json');
    }

    /**
     * Get request model
     */
    public function actionRequestInfo()
    {
        if (isset($this->request['id'])) {
            /* @var Requests $request */
            $request = Requests::model()->find('id = :id AND user_id = :userID', [':id' => $this->request['id'], ':userID' => $this->user->id]);

            if(!$request)
                $this->_sendResponse(404, CJSON::encode([
                    'status' => false,
                    'message' => 'Request not found.'
                ]), 'application/json');

            $temp = [
                'id' => intval($request->id),
                'deviceID' => intval($request->category_id),
                'device' => $request->category->title,
                'addressID' => intval($request->user_address_id),
                'createDate' => JalaliDate::date("d F Y - H:i", $request->create_date),
                'description' => $request->description,
                'requestedDate' => JalaliDate::date("d F Y", $request->requested_date),
                'requestedTime' => $request->requested_time,
                'status' => intval($request->status),
            ];

            if ($request->user_address_id) {
                $temp['address'] = $request->userAddress->postal_address;
                $temp['phone'] = $request->userAddress->emergency_tel;
            }

            if ($request->service_date) {
                $temp['serviceDate'] = JalaliDate::date("d F Y", $request->service_date);
                $temp['serviceTime'] = $request->service_time;
            }

            if ($request->repairman_id) {
                $request->repairman->loadPropertyValues();
                $temp['repairMan'] = [
                    'name' => $request->repairman->first_name . ' ' . $request->repairman->last_name,
                    'avatar' => Yii::app()->getBaseUrl(true) . '/uploads/users/avatar/' . $request->repairman->avatar,
                ];
            }

//            $temp['status'] = true;

            $this->_sendResponse(200, CJSON::encode($temp), 'application/json');
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'ID variable is required.']), 'application/json');
    }

    public function actionTransactions()
    {
        $transactions = [];

        foreach($this->user->transactions as $transaction) {
            $temp = [
                'amount' => number_format($transaction->amount) . ' ريال',
                'date' => JalaliDate::date("d F Y", $transaction->date),
                'code' => $transaction->token,
                'status' => $transaction->status,
            ];

            $transactions[] = $temp;
        }

        $this->_sendResponse(200, CJSON::encode([
            'status' => true,
            'list' => $transactions,
        ]), 'application/json');
    }
}