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
                'dealerships',
                'createDealership',
                'updateDealership',
                'upload',
                'deleteUpload',
                'dealershipRequests',
                'dealershipRequest',
                'deleteDealershipRequest',
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
    /*public function actionCreate()
    {
        $model = new Users();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Users'])){
            $model->attributes = $_POST['Users'];
            if($model->save())
                $this->redirect(array('views', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }*/

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'views' page.
     */
    public function actionCreateDealership($id = false)
    {
        $request = null;
        $model = new Users();
        $model->setScenario('create-dealership');
        $this->performAjaxValidation($model);
        if($id){
            $request = DealershipRequests::model()->findByPk($id);
            if(!isset($_POST['Users'])){
                $model->attributes = $request->attributes;
                $model->first_name = $request->manager_name;
                $model->last_name = $request->manager_last_name;
            }
        }
        $avatar = array();
        if(isset($_POST['Users'])){
            $model->attributes = $_POST['Users'];
            $model->role_id = 2;
            $model->status = 'active';
            $model->create_date = time();

            $avatar = new UploadedFiles($this->tempPath, $model->avatar);
            if($model->save()){
                $avatar->move($this->avatarPath);
                if($id && $request){
                    $request->status = DealershipRequests::STATUS_SAVED;
                    $request->save(false);
                }
                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
                $this->redirect(array('dealershipRequests'));
            }else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('create-dealership', compact('model', 'avatar', 'request'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'views' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $model->scenario = 'changeStatus';
        if(isset($_POST['Users'])){
            $model->attributes = $_POST['Users'];
            if($model->save()){
                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                if(isset($_POST['ajax'])){
                    echo CJSON::encode(['status' => 'ok']);
                    Yii::app()->end();
                }else
                    $this->redirect(array('admin'));
            }else{
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
                if(isset($_POST['ajax'])){
                    echo CJSON::encode(['status' => 'error']);
                    Yii::app()->end();
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'views' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateDealership($id)
    {
        $model = $this->loadModel($id);
        $model->loadPropertyValues();
        $request = DealershipRequests::model()->findByAttributes(array('email' => $model->email));

        $this->performAjaxValidation($model);

        $avatar = new UploadedFiles($this->avatarPath, $model->avatar);
        if(isset($_POST['Users'])){
            $oldAvatar = $model->avatar;
            $model->attributes = $_POST['Users'];
            if($model->save()){
                $avatar->update($oldAvatar, $model->avatar, $this->tempPath);
                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
                $this->refresh();
            }else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('update-dealership', compact('model', 'avatar', 'request'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
//        if($model->status == 'deleted')
//            $model->delete();
//        $model->updateByPk($model->id, array('status' => 'deleted'));
        if($model->userDetails->avatar && is_file($this->avatarPath . $model->userDetails->avatar)){
            $avatar = new UploadedFiles($this->avatarPath, $model->userDetails->avatar);
            $avatar->removeAll(true);
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid views), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
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
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Users']))
            $model->attributes = $_GET['Users'];
        $model->role_id = 1;
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionDealerships()
    {
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Users']))
            $model->attributes = $_GET['Users'];
        $model->role_id = 2;
        $this->render('dealerships', array(
            'model' => $model,
        ));
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
        if(isset($_GET['UserTransactions']))
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
        if(isset($_GET['UserTransactions']))
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
        if($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Users $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'users-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionDealershipRequests()
    {
        $model = new DealershipRequests('search');
        if(isset($_GET['DealershipRequests']))
            $model->attributes = $_GET['DealershipRequests'];
        $this->render('dealership_requests', compact('model'));
    }

    public function actionDealershipRequest($id)
    {
        $model = DealershipRequests::model()->findByPk($id);
        $this->render('view_dealership_request', compact('model'));
    }

    public function actionDeleteDealershipRequest($id)
    {
        DealershipRequests::model()->deleteByPk($id);
        $this->redirect(array('dealershipRequests'));
    }
}