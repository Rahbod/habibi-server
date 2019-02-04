<?php

class RequestsManageController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess - print', // perform access control for CRUD operations
        );
    }

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'backend' => array(
                'index',
                'create',
                'update',
                'admin',
                'pending',
                'recycleBin',
                'restore',
                'delete',
                'view',
                'invoicing',
                'approvePayment',
                'my',
                'deleteInvoiceItem',
                'print',
                'searchPiece',
                'searchTariff',
            )
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     * @throws CHttpException
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        if ($model->status >= Requests::STATUS_PENDING &&
            $model->status < Requests::STATUS_OPERATOR_CHECKING
        ) {
            $model->status = Requests::STATUS_OPERATOR_CHECKING;
            $model->save(false);
        }

        if (!$model->operator_id && Yii::app()->user->type == 'admin') {
            $model->operator_id = Yii::app()->user->getId();
            $model->save(false);
        }

        if (isset($_POST['Requests'])) {
            $model->status = Requests::STATUS_CONFIRMED;
            $model->service_date = $_POST['Requests']['service_date'];
            $model->service_time = $_POST['Requests']['service_time'];
            $model->repairman_id = $_POST['Requests']['repairman_id'];
            if ($model->save()) {
                PushNotification::sendDataToUser($model->user->userDetails->push_token, [
                    'action' => 'selectRepairMan',
                    'id' => $model->id,
                    'message' => 'درخواست شما در آچارچی تایید شد.'
                ]);

                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
            } else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $model->refresh();
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Requests;

        if (isset($_POST['Requests'])) {
            $model->attributes = $_POST['Requests'];
            $model->status = Requests::STATUS_CONFIRMED;
            $model->requested_date = $model->service_date;
            $model->request_type = Requests::REQUEST_FROM_CALL;
            $model->operator_id = Yii::app()->user->type == 'admin' ? Yii::app()->user->getId() : null;
            if ($model->save()) {
                PushNotification::sendDataToUser($model->user->userDetails->push_token, [
                    'action' => 'selectRepairMan',
                    'id' => $model->id,
                    'message' => 'درخواست شما در آچارچی تایید شد.'
                ]);

                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                $this->redirect(array('admin'));
            } else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('create', array(
            'model' => $model,
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

        if (isset($_POST['Requests'])) {
            $model->attributes = $_POST['Requests'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                $this->redirect(array('admin'));
            } else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('update', array(
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
        $model = $this->loadModel($id);
        $model->delete();
//        if ($model->status == Requests::STATUS_DELETED)
//            $model->delete();
//        else {
//            $model->status = Requests::STATUS_DELETED;
//            if ($model->save(false))
//                Yii::app()->user->setFlash("success", "درخواست به زباله دان منتقل شد.");
//            else
//                Yii::app()->user->setFlash("success", "متاسفانه در حذف درخواست مشکلی بوجود آمده است.");
//        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (isset($_GET['pending']))
            $this->redirect(array('pending'));

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
        $model = new Requests('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Requests']))
            $model->attributes = $_GET['Requests'];
        $model->operator_id = Yii::app()->user->roles == 'operator' ? Yii::app()->user->getId() : null;

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionMy()
    {
        $model = new Requests('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Requests']))
            $model->attributes = $_GET['Requests'];
        $model->operator_id = Yii::app()->user->getId();

        $this->render('my_requests', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionPending()
    {
        $model = new Requests('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Requests']))
            $model->attributes = $_GET['Requests'];
        $model->status = Requests::STATUS_PENDING;

        if (isset($_GET['pendingAjax'])) {
            echo CJSON::encode($model->search());
            Yii::app()->end();
        }

        $this->render('pending', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionRecycleBin()
    {
        $model = new Requests('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Requests']))
            $model->attributes = $_GET['Requests'];
        $model->status = Requests::STATUS_DELETED;

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Requests the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Requests::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Requests $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'requests-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionRestore($id)
    {
        $model = $this->loadModel($id);
        if ($model->status == Requests::STATUS_DELETED) {
            if (!$model->getLastInvoice())
                $model->status = Requests::STATUS_OPERATOR_CHECKING;
            else
                $model->status = Requests::STATUS_AWAITING_PAYMENT;

            if ($model->save(false))
                Yii::app()->user->setFlash("success", "درخواست بازیابی شد.");
            else
                Yii::app()->user->setFlash("success", "متاسفانه در تغییر وضعیت مشکلی بوجود آمده است.");
        }
        $this->redirect(array('recycleBin'));
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionApprovePayment($id)
    {
        $model = $this->loadModel($id);
        if ($model->status == Requests::STATUS_AWAITING_PAYMENT) {
            $model->status = Requests::STATUS_PAID;
            if ($model->save(false))
                Yii::app()->user->setFlash("success", "فاکتور باموفقیت پرداخت شد.");
            else
                Yii::app()->user->setFlash("success", "متاسفانه در تغییر وضعیت مشکلی بوجود آمده است.");
        }
        $this->redirect(array('view', 'id' => $model->id));
    }

    /**
     * @param $id
     */
    public function actionInvoicing($id)
    {
        $model = $this->loadModel($id);

        if ($model->status >= Requests::STATUS_PAID) {
            Yii::app()->user->setFlash("failed", "فاکتور این درخواست قبلا صادر شده است، پس از پرداخت امکان تغییر فاکتور وجود ندارد.");
            $this->redirect(array('admin'));
        }

        $invoice = $model->getLastInvoice();
        if (!$invoice)
            $invoice = new Invoices();

        // Save invoice items
        if (isset($_POST['saveItems'])) {
            InvoiceItems::model()->deleteAll('invoice_id = :id', [':id' => $invoice->id]);

            // Save pieces
            foreach ($_POST['InvoiceItems']['piece_title'] as $key => $invoiceItem) {
                /* @var Tariffs $piece */
                $piece = Tariffs::model()->find('title = :title', [':title' => $invoiceItem]);

                if (!$piece) {
                    $piece = new Tariffs();
                    $piece->title = $invoiceItem;
                    $piece->type = Tariffs::TYPE_PIECE;
                    $piece->save();
                }

                $invoiceItem = new InvoiceItems();
                $invoiceItem->tariff_id = $piece->id;
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->cost = $_POST['InvoiceItems']['piece_cost'][$key];
                $invoiceItem->save();
            }

            // Save tariffs
            foreach ($_POST['InvoiceItems']['tariff_title'] as $key => $invoiceItem) {
                /* @var Tariffs $tariff */
                $tariff = Tariffs::model()->find('title = :title', [':title' => $invoiceItem]);

                if (!$tariff) {
                    $tariff = new Tariffs();
                    $tariff->title = $invoiceItem;
                    $tariff->type = Tariffs::TYPE_TARIFF;
                    $tariff->save();
                }

                $invoiceItem = new InvoiceItems();
                $invoiceItem->tariff_id = $tariff->id;
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->cost = $_POST['InvoiceItems']['tariff_cost'][$key];
                $invoiceItem->save();
            }

            $invoice->additional_cost = $_POST['Invoices']['additional_cost'] ?: 0;
            $invoice->discount_percent = $_POST['Invoices']['discount_percent'] ?: 0;
            $invoice->credit_increase_percent = $_POST['Invoices']['credit_increase_percent'] ?: 0;
            $invoice->total_discount = $invoice->totalDiscount();

            if ($invoice->save()) {
                Yii::app()->user->setFlash("success", "اجرت با موفقیت ثبت شد.");
                $this->refresh();
            } else
                Yii::app()->user->setFlash("failed", "متاسفانه در ثبت اطلاعات مشکلی بوجود آمده است.");
        }

        // Save invoice
        if (isset($_POST['Invoices']['payment_method'])) {
            $model->status = Requests::STATUS_INVOICING;
            $model->save();

            $invoice->request_id = $id;
            $invoice->creator_id = Yii::app()->user->getId();
            $invoice->payment_method = $_POST['Invoices']['payment_method'];
            $invoice->modified_date = time();
            $invoice->status = Invoices::STATUS_UNPAID;

            if ($invoice->getIsNewRecord())
                $invoice->create_date = time();

            if ($invoice->save()) {
                Yii::app()->user->setFlash("success", "اطلاعات با موفقیت ثبت شد.");
                $this->refresh();
            } else
                Yii::app()->user->setFlash("failed", "متاسفانه در ثبت اطلاعات مشکلی بوجود آمده است.");
        }

        // Confirm invoice
        if (isset($_POST['confirm'])) {
            $model->status = Requests::STATUS_PAID;
            $model->save();

            $invoice->final_cost = $invoice->finalCost();
            $invoice->save();

            PushNotification::sendDataToUser($model->user->userDetails->push_token, [
                'action' => 'invoicing',
                'id' => $id,
                'message' => 'فاکتور درخواست شما در آچارچی صادر شد.'
            ]);
            Yii::app()->user->setFlash('invoice-success', 'فاکتور با موفقیت تایید نهایی و برای مشتری ارسال گردید.');
            $this->redirect(array('/requests/' . $model->id . '#invoice-panel'));
        }

        $pieceModels = [new InvoiceItems()];
        $tariffModels = [new InvoiceItems()];
        if (!$invoice->getIsNewRecord() and $invoice->items) {
            $pieceModels = [];
            $tariffModels = [];
            foreach ($invoice->items as $item) {
                if ($item->tariff->type == Tariffs::TYPE_PIECE)
                    $pieceModels[] = $item;
                else
                    $tariffModels[] = $item;
            }
        }

        $this->render('create_invoice', compact('model', 'invoice', 'pieceModels', 'tariffModels'));
    }

    public function actionDeleteInvoiceItem()
    {
        $tariffID = Yii::app()->request->getParam('tariff_id');
        $invoiceID = Yii::app()->request->getParam('invoice_id');
        /* @var InvoiceItems $model */
        $model = InvoiceItems::model()->find('invoice_id = :inID AND tariff_id = :tID', [':inID' => $invoiceID, ':tID' => $tariffID]);

        if ($model->cost < $model->tariff->cost) {
            $model->invoice->total_discount -= intval($model->tariff->cost - $model->cost);
            $model->invoice->save(false);
        }

        if ($model->delete() && !Yii::app()->request->isAjaxRequest)
            $this->redirect(array('/requests/manage/invoicing/5'));
    }

    public function actionPrint($id)
    {
        $this->layout = '//layouts/print';
        $model = $this->loadModel($id);
        $invoice = $model->getLastInvoice();
        $this->render('print', compact('model', 'invoice'));
    }

    public function actionSearchPiece()
    {
        $term = $_GET['term'];

        /* @var Tariffs[] $tariffs */
        $tariffs = Tariffs::model()->findAll('title LIKE :term AND type = 1', [':term' => "%$term%"]);

        $result = [];
        foreach($tariffs as $tariff)
            $result[] = $tariff->title;

        echo json_encode($result);
    }

    public function actionSearchTariff()
    {
        $term = $_GET['term'];

        /* @var Tariffs[] $tariffs */
        $tariffs = Tariffs::model()->findAll('title LIKE :term AND type = 0', [':term' => "%$term%"]);

        $result = [];
        foreach($tariffs as $tariff)
            $result[] = $tariff->title;

        echo json_encode($result);
    }
}
