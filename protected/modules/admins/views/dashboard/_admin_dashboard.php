<?php
/* @var $this AdminsDashboardController */
/* @var $statistics []*/
$permissions = [
    'contact' => false,
    'appRequests' => false,
    'offlineRequests' => false,
    'dealerRequests' => false,
    'transactionStatistics' => false,
    'statistics' => false,
];
if(Yii::app()->user->roles == 'admin'){
    $permissions['contact'] = true;
    $permissions['appRequests'] = true;
    $permissions['offlineRequests'] = true;
    $permissions['dealerRequests'] = true;
    $permissions['statistics'] = true;
    $permissions['transactionStatistics'] = true;
}
if(Yii::app()->user->roles == 'operator'){
    $permissions['contact'] = true;
    $permissions['appRequests'] = true;
    $permissions['offlineRequests'] = true;
    $permissions['dealerRequests'] = true;
    $permissions['statistics'] = true;
    $permissions['transactionStatistics'] = true;
}
?>
<div class="row boxed-statistics">
    <!--App AND Offline Requests-->
    <?php
    if($permissions['appRequests']):
        ?>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php echo $statistics['appRequests'];?></h3>
                    <p>درخواست های تعمیرات جدید</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document-text"></i>
                </div>
                <a href="<?php echo $this->createUrl('/requests/manage/pending');?>" class="small-box-footer">مشاهده درخواست ها <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <?php
    endif;
    ?>

    <!--Dealership Requests-->
    <?php
    if($permissions['dealerRequests']):
        ?>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo $statistics['dealerRequests'];?></h3>
                    <p>درخواست همکاری</p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-car"></i>
                </div>
                <a href="<?php echo $this->createUrl('/users/manage/dealershipRequests');?>" class="small-box-footer">مشاهده درخواست ها <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <?php
    endif;
    ?>

    <!-- Contact Us Messages-->
    <?php
    if($permissions['contact']):
        ?>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?php echo $statistics['contact'];?></h3>
                    <p>پیام خوانده نشده</p>
                </div>
                <div class="icon">
                    <i class="ion ion-headphone"></i>
                </div>
                <a href="<?php echo $this->createUrl('/contact/messages/admin');?>" class="small-box-footer">مشاهده پیام ها <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <?php
    endif;
    ?>

    <!--Transaction Statistics-->
    <?php
    if($permissions['transactionStatistics']):
        ?>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3><?php echo $statistics['transactions'];?></h3>
                    <p>تراکنش های امروز</p>
                </div>
                <div class="icon">
                    <i class="ion ion-cash"></i>
                </div>
                <a href="<?php echo $this->createUrl('/users/manage/transactions');?>" class="small-box-footer">مشاهده تراکنش ها <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <?php
    endif;
    ?>
</div>
<div class="row">
    <section class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <!--Statistics-->
        <?php
        if($permissions['statistics']):
            ?>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title" >آمار بازدیدکنندگان</h3>
                </div>
                <div class="box-body">
                    <p>
                        افراد آنلاین : <?php echo Yii::app()->userCounter->getOnline(); ?><br />
                        بازدید امروز : <?php echo Yii::app()->userCounter->getToday(); ?><br />
                        بازدید دیروز : <?php echo Yii::app()->userCounter->getYesterday(); ?><br />
                        تعداد کل بازدید ها : <?php echo Yii::app()->userCounter->getTotal(); ?><br />
                        بیشترین بازدید : <?php echo Yii::app()->userCounter->getMaximal(); ?><br />
                    </p>
                </div>
            </div>
            <?php
        endif;
        ?>
    </section>
</div>
