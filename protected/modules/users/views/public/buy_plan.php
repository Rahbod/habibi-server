<?php
/* @var $this UsersPublicController */
/* @var $plan Plans */
/* @var $transaction UserTransactions */
/* @var $active_gateway string */
/* @var $user Users */

$this->breadcrumbs =[
    'داشبورد' => array('/dashboard'),
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور' => array('/changePassword'),
];
?>

<div class="content-box white-bg">
    <div class="center-box plans-page col-lg-6 col-md-6 col-sm-8 col-xs-12 col-lg-push-3 col-md-push-3 col-sm-push-2">
        <h4>پیش فاکتور پرداخت</h4>
        <div class="plans">
            <?php $this->renderPartial('//partial-views/_flashMessage') ?>
            <?php
            if($plan):
            ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th>عضویت موردنظر</th><td><?= $plan->title ?></td>
                        </tr>
                        <?php
                        if($transaction):
                            ?>
                            <tr>
                                <th>شماره تراکنش</th><td><?= $transaction->id ?></td>
                            </tr>
                        <?php
                        endif;
                        ?>
                        <tr>
                            <th>درگاه پرداخت</th><td><b><?= UserTransactions::model()->gateways[$active_gateway]?></b></td>
                        </tr>
                        <tr>
                            <th>مبلغ قابل پرداخت</th><td><?= Controller::parseNumbers(number_format($plan->getPrice($user->role->role))) ?> تومان</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <?php
                echo CHtml::beginForm('','post',array('csrf' => true));
                ?>
                <button type="submit" name="buy" class="btn btn-success pull-left">پرداخت</button>
                <?php
                echo CHtml::endForm();
                ?>
            <?php
            else:
                ?>
                <a href="<?= $this->createUrl('/upgradePlan') ?>" class="btn btn-info pull-left">بازگشت</a>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>
