<?php

class RequestsCategoriesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $logoPath = 'uploads/categories';
    public $fileOptions = [];

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
	* @return array actions type list
	*/
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'index', 'create', 'update', 'admin', 'delete', 'upload', 'deleteUpload', 'order'
			)
		);
	}

    public function actions()
    {
        return array(
            'upload' => array( // brand logo upload
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'logo',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => array('png')
                )
            ),
            'deleteUpload' => array( // delete brand logo uploaded
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'Categories',
                'attribute' => 'logo',
                'uploadDir' => "/$this->logoPath/",
                'storedMode' => 'field'
            ),
            'order' => array( // ordering models
                'class' => 'ext.yiiSortableModel.actions.AjaxSortingAction',
            ),
        );
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Categories;
        $logo = [];

        // Register codes
        if(isset($_POST['ajax'])){
            $errors = CActiveForm::validate($model);
            if(CJSON::decode($errors)){
                echo $errors;
                Yii::app()->end();
            }
        }

		if(isset($_POST['Categories'])) {
            $model->attributes = $_POST['Categories'];
            $logo = new UploadedFiles($this->tempPath, $model->logo, $this->fileOptions);
            if ($model->save()) {
                $logo->move($this->logoPath);
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode([
                        'status' => true,
                        'url' => $this->createAbsoluteUrl('admin')
                    ]);
                    Yii::app()->end();
                } else
                {
                    Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                    $this->redirect(array('admin'));
                }
            } else {
                if (isset($_POST['ajax'])) {
                    echo CJSON::encode(array('status' => false, 'msg' => 'متاسفانه در ثبت اطلاعات مشکلی بوجود آمده است. لطفا مجددا سعی کنید.'));
                    Yii::app()->end();
                } else
                    Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
            }
        }

		$this->render('create',array(
			'model'=>$model,
            'logo' => $logo
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        $logo = new UploadedFiles($this->logoPath, $model->logo, $this->fileOptions);
		if(isset($_POST['Categories']))
		{
            $oldLogo = $model->logo;
			$model->attributes=$_POST['Categories'];
            if($model->save()){
                $logo->update($oldLogo, $model->logo, $this->tempPath);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                if (Yii::app()->request->isAjaxRequest) {
                    echo CJSON::encode([
                        'status' => true,
                        'url' => $this->createAbsoluteUrl('admin'),
                    ]);
                    Yii::app()->end();
                } else
                    $this->redirect(array('admin'));
            } else {
                if (isset($_POST['ajax'])) {
                    echo CJSON::encode(array('status' => false, 'msg' => 'متاسفانه در ثبت اطلاعات مشکلی بوجود آمده است. لطفا مجددا سعی کنید.'));
                    Yii::app()->end();
                } else
                    Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
            }
		}

		$this->render('update',array(
			'model'=>$model,
            'logo' => $logo
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $model = $this->loadModel($id);
        $logo = new UploadedFiles($this->logoPath, $model->logo, $this->fileOptions);
        $logo->remove($model->logo, true);
        $model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
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
		$model=new Categories('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Categories']))
			$model->attributes=$_GET['Categories'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Categories the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Categories::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Categories $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='categories-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
