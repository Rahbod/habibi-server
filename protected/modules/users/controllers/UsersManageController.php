<?php

class UsersManageController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';
    public $avatarPath = 'uploads/users/avatar';
    public $avatarOptions = ['thumbnail' => ['width' => 100, 'height' => 100], 'resize' => ['width' => 250, 'height' => 250]];

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'backend' => array(
                'index',
                'view',
                'create',
                'update',
                'admin',
                'delete',
                'userTransactions',
                'transactions',
                'upload',
                'deleteUpload',
                'cooperationRequests',
                'viewRequest',
                'deleteRequest',
                'fetchAddresses',
                'addAddress',
                'quickUser'
            )
        );
    }

    public function actions()
    {
        return array(
            'upload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'avatar',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ),
            'deleteUpload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'UserDetails',
                'attribute' => 'avatar',
                'uploadDir' => '/uploads/users/avatar/',
                'storedMode' => 'field'
            ),
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'views' page.
     */
    public function actionCreate()
    {
        $model = new Users('create');
        $model->role_id = isset($_GET['role']) ? $_GET['role'] : 1;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->status = 'active';
            $model->password = $model->generatePassword();
            $model->repeatPassword = $model->generatePassword();
            $model->role_id = isset($_GET['role']) ? $_GET['role'] : 1;
            if ($model->avatar)
                $avatar = new UploadedFiles($this->tempPath, $model->avatar, $this->avatarOptions);
            if ($model->save()) {
                if ($model->avatar)
                    $avatar->move($this->avatarPath);
                $this->sendDownload($model->mobile);
                $this->redirect(array('admin', 'role' => isset($_GET['role']) && !empty($_GET['role']) ? $_GET['role'] : 1));
            }
        }

        if ($model->avatar)
            $avatar = new UploadedFiles($this->tempPath, $model->avatar, $this->avatarOptions);

        $this->render('create', compact('model', 'avatar'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'views' page.
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $avatar = new UploadedFiles($this->avatarPath, $model->avatar, $this->avatarOptions);
        if (isset($_POST['Users'])) {
            $oldAvatar = $model->avatar;
            $model->attributes = $_POST['Users'];
            if ($model->save()) {
                if ($model->avatar)
                    $avatar->update($oldAvatar, $model->avatar, $this->tempPath);
                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                if (isset($_POST['ajax'])) {
                    echo CJSON::encode(['status' => 'ok']);
                    Yii::app()->end();
                } else
                    $this->redirect(array('admin', 'role' => $model->role_id));
            } else {
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
                if (isset($_POST['ajax'])) {
                    echo CJSON::encode(['status' => 'error']);
                    Yii::app()->end();
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
            'avatar' => $avatar,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model->userDetails && $model->userDetails->avatar && is_file($this->avatarPath . $model->userDetails->avatar)) {
            $avatar = new UploadedFiles($this->avatarPath, $model->userDetails->avatar);
            $avatar->removeAll(true);
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid views), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->actionAdmin();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        // users
        $model = new Users('search');
        $model->unsetAttributes();
        if (isset($_GET['Users']))
            $model->attributes = $_GET['Users'];
        $model->role_id = isset($_GET['role']) ? $_GET['role'] : 1;

        $role = UserRoles::model()->findByPk($model->role_id);
        $this->render('admin', compact('model', 'role'));
    }

    /**
     * Show User Transactions
     *
     * @param $id
     */
    public function actionUserTransactions($id)
    {
        $model = new UserTransactions('search');
        $model->unsetAttributes();
        if (isset($_GET['UserTransactions']))
            $model->attributes = $_GET['UserTransactions'];
        $model->user_id = $id;
        //

        $this->render('user_transactions', array(
            'model' => $model
        ));
    }

    public function actionTransactions()
    {
        Yii::app()->theme = 'abound';
        $this->layout = '//layouts/main';

        $model = new UserTransactions('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserTransactions']))
            $model->attributes = $_GET['UserTransactions'];

        $this->render('admin_transactions', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Users the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Users::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Users $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCooperationRequests()
    {
        $model = new CooperationRequests('search');
        $model->unsetAttributes();
        if (isset($_GET['CooperationRequests']))
            $model->attributes = $_GET['CooperationRequests'];

        $this->render('cooperation_requests', compact('model'));
    }

    public function actionViewRequest($id)
    {
        $model = CooperationRequests::model()->findByPk($id);
        $model->status = CooperationRequests::STATUS_REVIEWED;
        $model->save(false);
        $this->render('view_cooperation_request', compact('model'));
    }

    public function actionDeleteRequest($id)
    {
        CooperationRequests::model()->deleteByPk($id);
        $this->redirect(array('cooperationRequests'));
    }

    /**
     * @param int $id brandID
     * @return string
     */
    public function actionFetchAddresses($id)
    {
        $output = "<option value=''>آدرس موردنظر را انتخاب کنید...</option>";
        $empty = "<option value=''>برای این مشتری آدرسی ثبت نشده است...</option>";
        if ($addresses = UserAddresses::getList($id))
            foreach ($addresses as $address)
                $output .= "<option value='{$address->id}'>
                                <div>{$address->town->name} - {$address->place->name}</div>
                                <small>{$address->postal_address}</small>
                            </option>";
        echo $addresses ? $output : $empty;
        return;
    }

    public function actionAddAddress()
    {
        $model = new UserAddresses();

        if (isset($_POST['UserAddresses'])) {
            $model->attributes = $_POST['UserAddresses'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'آدرس برای مشتری با موفقیت ثبت شد.');

                $return = $_GET['return'];
                if (strpos($return, '?', 0) !== false) {
                    list($uri, $query) = explode("?", $return);
                    parse_str($query, $params);
                    unset($params['address_id']);
                } else {
                    $uri = $return;
                    $params = [];
                }
                $params['address_id'] = $model->id;
                $return = $uri . "?" . http_build_query($params);

                $this->redirect(array($return));
            } else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('add_address', compact('model'));
    }

    public function actionQuickUser()
    {
        $model = new Users('quick');
        $address = new UserAddresses('quick');

        if (isset($_GET['mobile'])) {
            $mobile = $_GET['mobile'];
            $mobile = TextMessagesReceive::NormalizePhone($mobile);
            $user = Users::model()->findByAttributes(['username' => $mobile]);
            if ($user) {
                $model = $user;
                $model->scenario = 'quick';
            }
//                $this->redirect(array($_GET['return'], 'user_id' => $user->id));
        }

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if($model->isNewRecord) {
                $model->username = $model->mobile;
                $model->password = $model->mobile;
                $model->status = 'active';
            }
            if ($model->save()) {

                $return = $_GET['return'];
                if (strpos($return, '?', 0) !== false) {
                    list($uri, $query) = explode("?", $return);
                    parse_str($query, $params);
                    unset($params['user_id']);
                    unset($params['address_id']);
                } else {
                    $uri = $return;
                    $params = [];
                }
                $params['user_id'] = $model->id;
                if($model->isNewRecord)
                    $this->sendDownload($model->mobile);
                else {
                    $return = $uri . "?" . http_build_query($params);
                    $this->redirect(array($return));
                }

                if (isset($_POST['UserAddresses'])) {
                    $address->attributes = $_POST['UserAddresses'];
                    $address->user_id = $model->id;
                    if ($address->save()) {
                        Yii::app()->user->setFlash('success', 'مشتری با موفقیت ثبت شد.');

                        $params['address_id'] = $address->id;
                        $return = $uri . "?" . http_build_query($params);

                        $this->redirect(array($return));
                    } else
                        Yii::app()->user->setFlash('failed', 'مشتری با موفقیت ثبت شد. در ثبت آدرس خطایی رخ داده است! لطفا مجددا تلاش کنید.');
                }
            } else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('quick_user', compact('model', 'address'));
    }

    private function sendDownload($phone)
    {
        $link = "http";
        $text = "حساب کاربری شما در سامانه آچارچی با موفقیت ایجاد شد.";
//        $text = "حساب کاربری شما با موفقیت ایجاد شد، جهت ثبت و پیگیری درخواست اپلیکیشن آچارچی را از لینک زیر دانلود کنید.
//{$link}";
        Notify::SendSms($text, $phone);
    }
}