<?php

class ContactRepliesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public static function actionsType()
	{
		return array(
			'backend' => array(
				'index', 'create', 'update', 'admin', 'delete', 'deleteSelected'
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
		$model = new ContactReplies;

		if(isset($_POST['ContactReplies'])){
			$model->attributes = $_POST['ContactReplies'];
			$message = ContactMessages::model()->findByPk($model->message_id);
			if($message && $model->validate()){
				$subject = "پاسخ از وبسايت " . Yii::app()->name . " - " . $message->subject;
				$body = "<div style='padding:15px;white-space: pre-line'>"
					. "<p>موضوع پیغام شما: \"" . $message->subject . "\"</p>"
					. "<p>پاسخ:</p>"
					. "<p>" . $model->body . "</p>"
					. "<p>"
					. "<strong>فرستنده: </strong>" . Yii::app()->name . "<br>"
					. "</p></div>";
				$result = Mailer::mail($message->email, $subject . Yii::app()->name, $body, Yii::app()->params['noReplyEmail']);
				if($result){
					$model->save();
					Yii::app()->user->setFlash('success', 'پاسخ شما با موفقیت ارسال شد.');
					ContactMessages::model()->updateByPk($model->message_id, array('reply' => 1));
				}else
					Yii::app()->user->setFlash('failed', 'خطا در ارسال پاسخ! لطفا مجددا تلاش کنید.');
			}else
				Yii::app()->user->setFlash('failed', 'خطا در مقادیر ورودی!');
			$this->redirect(array('/contact/messages/view?id=' . $model->message_id));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ContactReplies']))
		{
			$model->attributes=$_POST['ContactReplies'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success','ویرایش با موفقیت انجام شد');
				$this->refresh();
			}
			else
				Yii::app()->user->setFlash('failed','خطا در هنگام ویرایش!');
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id,$mode=NULL)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if($mode!="notAjax")
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	public function actionDeleteSelected()
    { 
		foreach ($_POST['selectedItems'] as $modelId)
		{
			$this->actionDelete($modelId,"notAjax");
		}
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ContactReplies');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ContactReplies('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ContactReplies']))
			$model->attributes=$_GET['ContactReplies'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ContactReplies the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ContactReplies::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ContactReplies $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contact-replies-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
