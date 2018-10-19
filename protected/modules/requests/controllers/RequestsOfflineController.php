<?php

class RequestsOfflineController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess - receive', // perform access control for CRUD operations
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
                'index', 'admin', 'delete', 'receive'
            )
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

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
        $model=new TextMessagesReceive('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TextMessagesReceive']))
            $model->attributes=$_GET['TextMessagesReceive'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TextMessagesReceive the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=TextMessagesReceive::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TextMessagesReceive $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='text-messages-receive-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

	public function actionReceive()
	{
        /** @var string $text*/
        /** @var string $from*/
        /** @var string $to*/
        /** @var string $date*/

        Yii::app()->db->createCommand('ALTER TABLE `ym_text_messages_receive`
MODIFY COLUMN `sms_date`  varchar(30) NOT NULL COMMENT \'تاریخ پیامک\' AFTER `text`;')->execute();

        extract($_GET);
		$model = new TextMessagesReceive();
		$model->create_date = time();
		$model->sender = $from;
		$model->text = $text;
		$model->to = $to;
		$model->sms_date = $date;

		if($model->save())
		    echo 'saved';
		else
		    var_dump($model->errors);
	}
}