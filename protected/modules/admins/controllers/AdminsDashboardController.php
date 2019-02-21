<?php

class AdminsDashboardController extends Controller
{
    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'backend' => array(
                'index'
            )
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess - index', // perform access control for CRUD operations
        );
    }

    public function actionIndex()
    {
        Yii::app()->getModule('contact');
        $trCr = new CDbCriteria();
        $trCr->compare('status', UserTransactions::TRANSACTION_STATUS_PAID);
        $trCr->addCondition('date >= :today');
        $trCr->params[':today'] = strtotime(date('Y/m/d 00:00', time()));

        $appRequestsCr = new CDbCriteria();
        $appRequestsCr->compare('status', Requests::STATUS_PENDING);
        $appRequestsCr->compare('request_type', '<>' . Requests::REQUEST_OFFLINE);

        $todayRequestsCr = new CDbCriteria();
        $todayRequestsCr->addCondition('status < :paidStatus');
        $todayRequestsCr->addBetweenCondition('service_date', strtotime(date('Y/m/d 00:00')), strtotime(date('Y/m/d 23:59')));
        $todayRequestsCr->params[':paidStatus'] = Requests::STATUS_INVOICING;

        $statistics = [
            //'contact' => ContactMessages::model()->count('seen = 0'),
            'todayRequests' => Requests::model()->count($todayRequestsCr),
            'appRequests' => Requests::model()->count($appRequestsCr),
            'offlineRequests' => Requests::model()->countByAttributes(['status' => Requests::STATUS_PENDING, 'request_type' => Requests::REQUEST_OFFLINE]),
            'cooperationRequests' => CooperationRequests::model()->count('status = 0'),
            'transactions' => UserTransactions::model()->count($trCr)
        ];
        $this->render('index', compact('statistics'));
    }
}