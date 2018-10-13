<?php

class RequestsBrandsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';
	public $logoPath = 'uploads/brands';
	public $modelImagePath = 'uploads/brands/models';
	public $fileOptions = ['thumbnail' => ['width' => 100, 'height' => 100], 'resize' => ['width' => 200, 'height' => 200]];
	public $modelFileOptions = ['resize' => ['width' => 545, 'height' => 270]];

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess - imager'
		);
	}

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'index', 'create', 'update', 'admin', 'delete', 'upload', 'deleteUpload',
				'models', 'modelAdd', 'modelEdit', 'modelDelete', 'fetchModels',
				'order', 'uploadModelImage', 'deleteUploadModelImage', 'imager'
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
					'acceptedTypes' => array('png', 'jpg', 'jpeg')
				)
			),
			'deleteUpload' => array( // delete brand logo uploaded
				'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
				'modelName' => 'Brands',
				'attribute' => 'logo',
				'uploadDir' => '/uploads/brands/',
				'storedMode' => 'field'
			),
			'uploadModelImage' => array( // model image upload
				'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
				'attribute' => 'images',
				'rename' => 'random',
				'validateOptions' => array(
					'acceptedTypes' => array('png', 'jpg', 'jpeg')
				)
			),
			'deleteUploadModelImage' => array( // delete model image uploaded
				'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
				'modelName' => 'ModelDetails',
				'attribute' => 'images',
				'uploadDir' => '/uploads/brands/models/',
				'storedMode' => 'json'
			),
			'order' => array( // ordering models
				'class' => 'ext.yiiSortableModel.actions.AjaxSortingAction',
			),
		);
	}

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     * @throws CHttpException
     */
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Brands;
		$logo = [];
		if(isset($_POST['Brands'])){
			$model->attributes = $_POST['Brands'];
			$logo = new UploadedFiles($this->tempPath, $model->logo, $this->fileOptions);
			if($model->save()){
				$logo->move($this->logoPath);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد. لطفا مدل های این برند را ثبت کنید.');
				$returnUrl = isset($_REQUEST['return']) && !empty($_REQUEST['return'])?"?return={$_REQUEST['return']}":"";
				$this->redirect(array("brands/models/{$model->id}{$returnUrl}"));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create', array(
			'model' => $model,
			'logo' => $logo
		));
	}

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		$logo = new UploadedFiles($this->logoPath, $model->logo, $this->fileOptions);
		if(isset($_POST['Brands'])){
			// store model image value in oldImage variable
			$oldLogo = $model->logo;
			$model->attributes = $_POST['Brands'];
			if($model->save()){
				$logo->update($oldLogo, $model->logo, $this->tempPath);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update', array(
			'model' => $model,
			'logo' => $logo
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
		$logo = new UploadedFiles($this->logoPath, $model->logo, $this->fileOptions);
		$logo->remove($model->logo, true);
		$model->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
			Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;آیتم با موفقیت حذف شد.');
			$this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
		}
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
		$model = new Brands('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Brands']))
			$model->attributes = $_GET['Brands'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @param bool $models
	 * @return Brands|Models the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id, $models = false)
	{
		$model = $models?Models::model()->findByPk($id):Brands::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}
	/**
	 * Performs the AJAX validation.
	 * @param Brands $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'brands-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * @param $id
	 * @throws CHttpException
	 */
	public function actionModels($id)
	{
		$model = $this->loadModel($id);
		$modelsSearch = new Models('search');
		if(isset($_GET['Models']))
			$modelsSearch->attributes = $_GET['Models'];
		$modelsSearch->brand_id = $id;

		$this->render('models', [
			'model' => $model,
			'modelsSearch' => $modelsSearch
		]);
	}

	public function actionModelAdd()
	{
		$model = new Models;

		if(isset($_GET['ajax']) && $_GET['ajax'] === 'create-model-form'){
			$model->attributes = $_POST['Models'];
			$errors = CActiveForm::validate($model);
			if(CJSON::decode($errors)){
				echo $errors;
				Yii::app()->end();
			}
		}
		if(isset($_POST['Models'])){
			$model->attributes = $_POST['Models'];
			if($model->save()){
                $returnUrl = isset($_REQUEST['return']) && !empty($_REQUEST['return'])?$_REQUEST['return']:"brands/modelEdit/{$model->id}";
				echo CJSON::encode(array('status' => true, 'msg' => 'اطلاعات با موفقیت ذخیره شد.',
					'url' => $this->createUrl($returnUrl)));
			}else
				echo CJSON::encode(array('status' => false, 'msg' => 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.'));
		}
		Yii::app()->end();
	}

	/**
	 * @param $id
	 * @throws CException
	 * @throws CHttpException
	 */
	public function actionModelEdit($id)
	{
		$model = $this->loadModel($id, true);

		if(isset($_POST['Models'])){
			$model->attributes = $_POST['Models'];
			if($model->save()){
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->refresh();
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update_model', array(
			'model' => $model
		));
	}

	public function actionModelDelete($id)
	{
		$model = $this->loadModel($id, true);
		$brID = $model->brand_id;
		$model->delete();

		if(!isset($_GET['ajax'])){
			Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;آیتم با موفقیت حذف شد.');
			$this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('brands/models/' . $brID));
		}
	}

    /**
     * @param int $id brandID
     * @return string
     */
    public function actionFetchModels($id)
    {
        $output = "<option value=''>مدل موردنظر را انتخاب کنید...</option>";
        $empty = "<option value=''>در این برند مدل ثبت نشده، لطفا برند دیگری انتخاب کنید...</option>";
        if ($models = Models::getList($id))
            foreach ($models as $id => $title)
                $output .= "<option value='$id'>$title</option>";
        echo $models?$output:$empty;
        return;
    }
}