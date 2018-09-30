<?php

class UsersPlansController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $defaultAction = 'admin';

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'update',
				'admin',
			)
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

        $this->performAjaxValidation($model);

		if(isset($_POST['Plans']))
		{
			$model->attributes=$_POST['Plans'];
            $model->rules = CJSON::encode($model->rules);
			if($model->save())
                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ذخیره شد.');
            else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است!');

            $model->rules = $model->rules ? CJSON::decode($model->rules) : null;
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Plans('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Plans']))
			$model->attributes=$_GET['Plans'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Plans the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Plans::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Plans $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='plans-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
