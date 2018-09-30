<?php
/* @var $this UsersPublicController */
/* @var $plan Plans */
/* @var $transaction UserTransactions */
/* @var $user Users */

$this->breadcrumbs =[
    'داشبورد' => array('/dashboard'),
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور' => array('/changePassword'),
];
?>

<div class="content-box white-bg">
    <div class="center-box plans-page col-lg-6 col-md-6 col-sm-8 col-xs-12 col-lg-push-3 col-md-push-3 col-sm-push-2">
        <h4>نتیجه پرداخت</h4>
        <div class="plans">
            <?php $this->renderPartial('//partial-views/_flashMessage') ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>عضویت جدید</th><td class="text-success"><b><?= $user->activePlan->plan->title ?></b></td>
                    </tr>
                    <tr>
                        <th>تاریخ انقضا عضویت</th><td class="text-danger"><b><?= JalaliDate::date('Y/m/d',$user->activePlan->expire_date) ?></b></td>
                    </tr>
                    <tr>
                        <th>شماره تراکنش</th><td><?= $transaction->id ?></td>
                    </tr>
                    <tr>
                        <th>کد رهگیری</th><td style="letter-spacing: 2px; font-weight: bold;"><?= $transaction->token ?></td>
                    </tr>
                    <tr>
                        <th>نام درگاه</th><td><?= $transaction->gateway_name ?></td>
                    </tr>
                    <tr>
                        <th>وضعیت تراکنش</th><td><span class="label label-<?= $transaction->status=='paid'?'success':'danger' ?>"><?= $transaction->statusLabels[$transaction->status]?></span></td>
                    </tr>
                    <tr>
                        <th>تاریخ تراکنش</th><td class="ltr text-right"><?= JalaliDate::date('Y/m/d - H:i', $transaction->date) ?></td>
                    </tr>
                    <tr>
                        <th>مبلغ پرداختی</th><td><?= Controller::parseNumbers(number_format($plan->getPrice($user->role->role))) ?> تومان</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <a href="<?= $this->createUrl('/dashboard') ?>" class="btn btn-info pull-left">بازگشت به داشبورد</a>
        </div>
    </div>
</div>
