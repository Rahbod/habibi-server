<?php
class ContactReceiversController extends Controller
{
	public $layout = '//layouts/column2';
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'index', 'create', 'update', 'admin', 'delete'
			)
		);
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess', // perform access control for CRUD operations
			'postOnly + DeleteSelected', // we only allow deletion via POST request
		);
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new ContactReceivers;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['ContactReceivers'])){
			$model->attributes = $_POST['ContactReceivers'];
			if($model->save()){
				Yii::app()->user->setFlash('success', 'دریافت کننده جدید اضافه گردید!');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'خطا در هنگام ثبت!');
		}
		
		$this->render('create', array(
			'model' => $model,
		));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['ContactReceivers'])){
			$model->attributes = $_POST['ContactReceivers'];
			if($model->save()){
				Yii::app()->user->setFlash('success', 'ویرایش با موفقیت انجام شد');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'خطا در هنگام ویرایش!');
		}
		$this->render('update', array(
			'model' => $model,
		));
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id, $mode = NULL)
	{
		$this->loadModel($id)->delete();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if($mode != "notAjax")
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
	}
	public function actionDeleteSelected()
	{
		foreach($_POST['selectedItems'] as $modelId){
			$this->actionDelete($modelId, "notAjax");
		}
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('ContactReceivers');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new ContactReceivers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ContactReceivers']))
			$model->attributes = $_GET['ContactReceivers'];
		if(isset($_GET['ContactMessages']['department_id'])) 
			$model->department_id = (int)$_GET['ContactMessages']['department_id'];
		
		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ContactReceivers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = ContactReceivers::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param ContactReceivers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'contact-receivers-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}