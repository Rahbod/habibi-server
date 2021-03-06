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
        );
    }

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'backend' => array(
                'index', 'admin', 'delete', 'view', 'receive', 'my'
            )
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        if ($model->status == TextMessagesReceive::STATUS_PENDING) {
            $model->status = TextMessagesReceive::STATUS_OPERATOR_CHECKING;
            $model->save(false);
        }

        if (!$model->operator_id && Yii::app()->user->type == 'admin') {
            $model->operator_id = Yii::app()->user->getId();
            $model->save(false);
        }

        $this->render('view', array(
            'model' => $model,
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
        $model = new TextMessagesReceive('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TextMessagesReceive']))
            $model->attributes = $_GET['TextMessagesReceive'];

        if (isset($_GET['pendingAjax'])) {
            echo CJSON::encode($model->search());
            Yii::app()->end();
        }

        $this->render('admin', array(
            'model' => $model,
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
        $model = TextMessagesReceive::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TextMessagesReceive $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'text-messages-receive-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionReceive()
    {
        set_time_limit(0);
        /** @var string $text */
        /** @var string $from */
        /** @var string $to */
        /** @var string $date */

        extract($_GET);
        $model = new TextMessagesReceive();
        $model->create_date = time();
        $model->sender = $from;
        $model->text = $text;
        $model->to = $to;
        $model->sms_date = $date;

        if ($model->save())
            echo 'saved';
        else
            var_dump($model->errors);
    }

    /**
     * Manages all models.
     */
    public function actionMy()
    {
        $model = new TextMessagesReceive('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TextMessagesReceive']))
            $model->attributes = $_GET['TextMessagesReceive'];
        $model->operator_id = Yii::app()->user->getId();

        $this->render('my_requests', array(
            'model' => $model,
        ));
    }
}