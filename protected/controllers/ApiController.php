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
                $user->mobile = $mobile;
            }

            $user->verification_token = $code;
            if($user->save()){
                $userDetails = UserDetails::model()->findByAttributes(['user_id' => $user->id]);
                $userDetails->credit = SiteSetting::getOption('base_credit');
                $userDetails->save();
            }

            Notify::SendSms("کد فعال سازی شما در آچارچی:\n" . $code, $mobile);

            $this->_sendResponse(200, CJSON::encode(['status' => true]));
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'Mobile variable is required.']));
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
                ]));

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
                    ]));
                } else
                    $this->_sendResponse(400, CJSON::encode([
                        'status' => false,
                        'message' => $login->getError('authenticate_field')
                    ]));
            } else
                $this->_sendResponse(400, CJSON::encode([
                    'status' => false,
                    'message' => 'کد وارد شده اشتباه است.'
                ]));
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'Mobile and Code variables is required.']));
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

            $reagent = null;
            if(isset($this->request['reagent']) and !empty($this->request['reagent'])){
                $reagentID = substr($this->request['reagent'], 2);
                if($reagent = Users::model()->findByPk($reagentID))
                    $userDetails->reagent_id = $reagentID;
            }
            if ($userDetails->save()) {
                if($reagent){
                    /* @var UserDetails $reagentDetails */
                    $reagentDetails = UserDetails::model()->findByAttributes(['user_id' => $reagent->id]);
                    $reagentReward = SiteSetting::getOption('reagent_reward');
                    $reagentDetails->credit += $reagentReward;
                    if($reagentDetails->save())
                        PushNotification::sendNotificationToUser($reagentDetails->push_token, 'افزایش اعتبار', 'مبلغ '.number_format($reagentReward).' تومان بابت معرفی "'.$userDetails->first_name.'" به کیف پول شما اضافه گردید.');
                }

                $this->_sendResponse(200, CJSON::encode(['status' => true, 'message' => 'اطلاعات با موفقیت ثبت شد.']));
            }else
                $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'در ثبت اطلاعات خطایی رخ داده است. لطفا مجددا تلاش کنید.']));
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'Name and Token variables is required.']));
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
                $this->_sendResponse(200, CJSON::encode(['status' => true]));
            else
                $this->_sendResponse(400, CJSON::encode(['status' => false]));
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'Token variable is required.']));
    }

    public function actionCredit()
    {
        $userDetails = UserDetails::model()->findByAttributes(['user_id' => $this->user->id]);
        $this->_sendResponse(200, CJSON::encode(['status' => true,'credit' => (int)$userDetails->credit ,'showCredit' => number_format($userDetails->credit).' تومان']));
    }

    /**
     * Get list of devices
     */
    public function actionDevices()
    {
        Yii::import('application.modules.requests.models.*');
        $devices = [];

        if (isset($this->request['parent'])) {
            $cr = new CDbCriteria();
            $cr->addCondition('parent_id = :pid');
            $cr->params = array(':pid' => $this->request['parent']);
            $cr->order = 't.order';
            $models = Categories::model()->findAll($cr);
        }else
            $models = Categories::Parents(false);

        foreach ($models as $category)
            $devices[] = [
                'id' => intval($category->id),
                'title' => $category->title,
                'icon' => Yii::app()->getBaseUrl(true) . '/uploads/categories/' . $category->logo,
                'hasChild' => $category->childes ? true : false,
            ];

        $this->_sendResponse(200, CJSON::encode([
            'status' => true,
            'list' => $devices
        ]));
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
        ]));
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
            $address->map_lat = isset($this->request['map_lat'])?$this->request['map_lat']:"";
            $address->map_lng = isset($this->request['map_lng'])?$this->request['map_lng']:"";
            $address->map_zoom = isset($this->request['map_zoom'])?$this->request['map_zoom']:15;

            if ($address->save())
                $this->_sendResponse(200, CJSON::encode([
                    'status' => true,
                    'message' => 'اطلاعات با موفقیت ثبت شد.',
                    'address' => [
                        'id' => intval($address->id),
                        'telephone' => $address->emergency_tel,
                        'address' => $address->postal_address,
                    ]
                ]));
            else
                $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'در ثبت اطلاعات خطایی رخ داده است. لطفا مجددا تلاش کنید.']));
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'Telephone and Address variables is required.']));
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
                ]));
            else
                $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'در ثبت اطلاعات خطایی رخ داده است. لطفا مجددا تلاش کنید.']));
        } else
            $this->_sendResponse(400, CJSON::encode([
                'status' => false,
                'message' => 'Device ID, Address ID, Description, Date and Time variables is required.']));
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
        ]));
    }

    /**
     * Get request model
     */
    public function actionRequestInfo()
    {
        if (isset($this->request['id'])) {
            /* @var Requests $request */
            $request = Requests::model()->find('id = :id AND user_id = :userID', [':id' => $this->request['id'], ':userID' => $this->user->id]);

            if (!$request)
                $this->_sendResponse(404, CJSON::encode([
                    'status' => false,
                    'message' => 'Request not found.'
                ]));

            $temp = [
                'id' => intval($request->id),
                'deviceID' => intval($request->category_id),
                'device' => $request->category->title,
                'address' => null,
                'phone' => null,
                'serviceDate' => null,
                'serviceTime' => null,
                'createDate' => JalaliDate::date("d F Y - H:i", $request->create_date),
                'description' => $request->description,
                'requestedDate' => JalaliDate::date("d F Y", ($request->requested_date ?: $request->service_date)),
                'requestedTime' => $request->requested_time ?: $request->service_time,
                'status' => intval($request->status),
                'repairMan' => null,
                'invoice' => null,
                'rating' => null,
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
                $temp['repairMan'] = [
                    'name' => $request->repairman->userDetails->getShowName(false),
                    'code' => $request->repairman->id,
                    'avatar' => $request->repairman->avatar ? Yii::app()->getBaseUrl(true) . '/uploads/users/avatar/' . $request->repairman->avatar : '',
                ];
            }

            if ($request->rate) {
                $temp['rating'] = [
                    'rates' => $request->rate->rates,
                    'comment' => $request->rate->comment,
                ];
            }

            if ($invoice = $request->getLastInvoice() and $request->status != Requests::STATUS_DELETED) {
                $tariffs = [];

                foreach ($invoice->items as $item)
                    $tariffs[] = [
                        'title' => $item->tariff->title,
                        'cost' => number_format($item->cost) . ' تومان',
                    ];

                $temp['invoice'] = [
                    'cost' => number_format($invoice->final_cost) . ' تومان',
                    'totalDiscount' => $invoice->total_discount ? number_format($invoice->total_discount) . ' تومان' : 0,
                    'additionalCost' => $invoice->additional_cost ? number_format($invoice->additional_cost) . ' تومان' : 0,
                    'description' => $invoice->additional_description,
                    'paymentMethod' => $invoice->payment_method,
                    'status' => $invoice->status,
                    'tariffs' => $tariffs,
                ];
            }

            $this->_sendResponse(200, CJSON::encode($temp));
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'ID variable is required.']));
    }

    public function actionTransactions()
    {
        $transactions = [];

        foreach ($this->user->transactions as $transaction) {
            $temp = [
                'amount' => number_format($transaction->amount) . ' تومان',
                'date' => JalaliDate::date("d F Y", $transaction->date),
                'code' => $transaction->token,
                'status' => $transaction->status,
            ];

            $transactions[] = $temp;
        }

        $this->_sendResponse(200, CJSON::encode([
            'status' => true,
            'list' => $transactions,
        ]));
    }

    public function actionCooperation()
    {
        if (isset($this->request['name']) and isset($this->request['phone']) and isset($this->request['expertise']) and isset($this->request['experience'])) {
            $model = new CooperationRequests();
            $model->name = $this->request['name'];
            $model->mobile = $this->request['phone'];
            $model->expertise = $this->request['expertise'];
            $model->experience_level = $this->request['experience'];
            $model->status = CooperationRequests::STATUS_PENDING;

            if ($model->save())
                $this->_sendResponse(200, CJSON::encode(['status' => true, 'message' => 'درخواست شما با موفقیت ثبت شد. این درخواست به زودی توسط کارشناسان ما رسیدگی خواهد شد.']));
            else
                $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'در ثبت اطلاعات خطایی رخ داده است. لطفا مجددا تلاش کنید.']));
        } else
            $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'Name and Phone and Expertise and Experience variables is required.']));
    }

    public function actionRepairman($id)
    {
        $user = Users::model()->findByPk($id);
        if ($user)
            $this->_sendResponse(200, CJSON::encode([
                'code' => $user->id,
                'name' => $user->userDetails->getShowName(false),
                'mobile' => $user->mobile,
                'avatar' => $user->avatar ? Yii::app()->getBaseUrl(true) . '/uploads/users/avatar/' . $user->avatar : '',
                'expertise' => $user->getAdditionalDetails('expertise'),
                'experience' => $user->getAdditionalDetails('experience'),
                'description' => $user->getAdditionalDetails('description')
            ]));
        $this->_sendResponse(400, CJSON::encode(['status' => false, 'message' => 'Repairman not found.']));
    }

    public function actionRate()
    {
        $requestId = $this->request['requestID'];
        $comment = isset($this->request['comment'])?strip_tags($this->request['comment']):"";
        $rates = isset($this->request['rates'])?$this->request['rates']:[];
        /** @var $request Requests */
        $request = Requests::model()->findByPk($requestId);
        if ($request) {
            $rate = new RepairmanRatings();
            $rate->request_id = $request->id;
            $rate->repairman_id = $request->repairman_id;
            $rate->rates = $rates;
            $rate->comment = $comment;
            if($rate->save())
                $this->_sendResponse(200, CJSON::encode([
                    'status' => true,
                    'message' => 'نظر شما با موفقیت ثبت شد.',
                ]));
            else
                $this->_sendResponse(200, CJSON::encode([
                    'status' => false,
                    'message' => 'ثبت نظر با مشکل مواجه شد، لطفا بعدا تلاش فرمایید.',
                ]));
        }
        $this->_sendResponse(200, CJSON::encode([
            'status' => true
        ]));
    }

    // Payment
    public function actionPayment()
    {
        if (isset($this->request['id'])) {
            /* @var $model Requests */
            $model = Requests::model()->findByPk($this->request['id']);
            if ($model) {
                $transaction = new UserTransactions();
                $transaction->user_id = $model->user_id;
                $transaction->amount = $model->getLastInvoice()->totalCost();
                $transaction->description = "پرداخت فاکتور آچارچی";
                $transaction->date = time();
                $transaction->gateway_name = UserTransactions::GATEWAY_ZARINPAL;
                $transaction->model_name = Requests::class;
                $transaction->model_id = $model->id;
                if($transaction->save()) {
                    $CallbackURL = Yii::app()->getBaseUrl(true) . '/verifyPlan/' . $id;
                    $result = Yii::app()->zarinpal->PayRequest(
                        doubleval($transaction->amount),
                        $transaction->description,
                        $CallbackURL
                    );
                    $transaction->authority = Yii::app()->zarinpal->getAuthority();
                    $transaction->save(false);
                    if ($result->getStatus() == 100)
                        $this->redirect(Yii::app()->zarinpal->getRedirectUrl());
                    else
                        Yii::app()->user->setFlash('failed', Yii::app()->zarinpal->getError());
                }

                $this->_sendResponse(200, CJSON::encode([
                    'status' => true,
                    'id' => intval($transaction->id),
                    'url' => $this->createAbsoluteUrl('bill', ['id' => $transaction->id]),
                ]));
            } else
                $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'درخواست وجود ندارد.']));
        } else
            $this->_sendResponse(200, CJSON::encode(['status' => false, 'message' => 'ID variable is required.']));
    }

    public function actionBill($id)
    {
        $this->layout = 'payment';
        /* @var $transaction UserTransactions */
        $transaction = UserTransactions::model()->findByPk($id);
        if ($transaction and $transaction->status == 'unpaid') {
            $Amount = doubleval($transaction->amount);
            if($transaction->user_id == 150)
                $Amount = 100 * 10; //Amount will be based on Toman  - Required
            $CallbackURL = Yii::app()->getBaseUrl(true) . '/api/verifyTransaction';  // Required
            if ($transaction->gateway == UserTransactions::GATEWAY_MELLAT) {
                $result = Yii::app()->MellatPayment->PayRequest($Amount, $transaction->id, $CallbackURL);
                if (!$result['error']) {
                    $transaction->ref_id = $result['responseCode'];
                    $transaction->update();
                    $this->render('ext.mellatPayment.views._redirect', array('ReferenceId' => $result['responseCode']));
                } else {
                    echo '<meta charset="utf-8">';
                    echo 'ERR: ' . Yii::app()->MellatPayment->getResponseText($result['responseCode']);
                }
            }
        }
    }

    public function actionVerifyTransaction()
    {
        $this->layout = 'payment';
        $result = NULL;
        if (isset($_POST['RefId'])) {
            $orderId = $_POST['RefId'];
            /* @var $model UserTransactions */
            $model = UserTransactions::model()->findByAttributes(array('ref_id' => $orderId));
            if ($_POST['ResCode'] == 0) {
                $result = Yii::app()->MellatPayment->VerifyRequest($model->id, $_POST['SaleOrderId'], $_POST['SaleReferenceId']);
            }
            if ($result != NULL) {
                $RecourceCode = (!is_array($result) ? $result : $result['responseCode']);
                if ($RecourceCode == 0) {
                    $model->status = 'paid';
                    // Settle Payment
                    $settle = Yii::app()->MellatPayment->SettleRequest($model->order_id, $_POST['SaleOrderId'], $_POST['SaleReferenceId']);
                    if ($settle) {
                        $model->settle = 1;

                        $user = $user = User::model()->findByPk($model->user_id);
                        $user->activated = 1;
                        $user->update();
                    }
                }
            } else {
                $RecourceCode = $_POST['ResCode'];
            }
            $model->res_code = $RecourceCode;
            $model->sale_reference_id = $_POST['SaleReferenceId'];
            $model->update();
        } else
            throw new CHttpException(404, 'تراکنش پرداختی شما یافت نشد، در صورتی که مبلغی از حساب شما کسر شده طی 72 ساعت آینده به حساب شما برگردانده خواهد شد.');
    }

    public function actionCheckTransaction()
    {
        if (isset($this->request['id'])) {
            $transaction = UserTransactions::model()->findByPk($this->request['id']);

            if ($transaction) {
                $output = [
                    'status' => ($transaction->res_code == 0),
                    'message' => Yii::t('rezvan', $transaction->res_code)
                ];

                if ($transaction->res_code == 0) {
                    $output['amount'] = intval($transaction->amount);
                    $output['orderID'] = intval($transaction->order_id);
                    $output['code'] = $transaction->sale_reference_id;
                    $output['userID'] = $transaction->user_id;
                }

                $this->_sendResponse(200, CJSON::encode($output));
            } else
                $this->_sendResponse(200, CJSON::encode([
                    'status' => false,
                    'message' => 'تراکنش یافت نشد!'
                ]));
        } else
            $this->_sendResponse(200, CJSON::encode([
                'status' => false,
                'message' => 'ID variable is required.'
            ]));
    }
}