<?php

class RequestsOfflineController extends Controller
{
	public function actionReceive()
	{
        /** @var string $text*/
        /** @var string $from*/
        /** @var string $to*/
        /** @var string $date*/
        extract($_GET);
		$model = new TextMessagesReceive();
		$model->create_date = time();
		$model->sender = $from;
		$model->text = $text;
		$model->to = $to;
		$model->sms_date = $date;
		$model->save();
	}


	public function actionAdmin()
	{
		$model = new TextMessagesReceive();
		$model->unsetAttributes();
		if(isset($_GET['TextMessagesReceive']))
		    $model->attributes = $_GET['TextMessagesReceive'];

		$this->render('admin');
	}
}