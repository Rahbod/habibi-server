<?php
/* @var $this UsersPublicController */
/* @var $plans Plans[] */
/* @var $user Users */
$this->breadcrumbs =[
    'داشبورد' => array('/dashboard'),
    'تغییر مشخصات' => array('/profile'),
    'کلمه عبور' => array('/changePassword'),
];
?>

<div class="content-box white-bg">
    <div class="center-box plans-page">
        <h4>ارتقای حساب کاربری</h4>
        <div class="plans">
            <?php foreach($plans as $plan): $price = $plan->getPrice($user->role->role);?>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="plan-box <?= $plan->getCssClass() ?>">
<!--                        <div class="clearfix text-center fa-2x">-->
<!--                            <div class="badge badge-circle badge-circle-2x">-->
<!--                                <i class="pf pf-tea fa-3x"></i>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="clearfix text-center plan-title">
                            <?= $plan->title ?>
                        </div>
                        <div class="clearfix text-center">
                            <?= $price !== null ?Controller::parseNumbers(number_format($price)).'  تومان ماهیانه':'رایگان' ?>
                            <br>
                        </div>
                        <div class="clearfix text-center">
                            <div class="col-sm-12">
                                <ul class="list-unstyled plan-details">
                                    <?php
                                    foreach(Plans::$rulesFields[$user->role->role] as $rulesField):
                                        $rule = $plan->getRule($user->role->role,$rulesField['name']);
                                        if($rulesField['name']!='price' && ($rulesField['type']=='check' || ($rulesField['type']!='check' && $rule))):
                                        ?>
                                            <li><b><?= $rulesField['title'] ?></b><span><?php if($rulesField['type'] != 'check'): ?><?= Controller::parseNumbers($rule).(isset($rulesField['addon'])?' '.$rulesField['addon']:'') ?><?php else: echo $rule?'<i class="icon-check-sign"></i>':'<i class="text-danger icon-remove-sign"></i>'; endif; ?></span></li>
                                        <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix text-center button-box">
                            <?php if($price && $user->activePlan->plan_id !== $plan->id): ?>
                                <a class="btn btn-default btn-sm" href="<?= $this->createUrl('/buyPlan/'.$plan->id) ?>">انتخاب عضویت</a>
                            <?php
                            elseif($plan->id == $user->activePlan->plan_id):
                            ?>
                                <p>عضویت فعلی شما</p>
                            <?endif;?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
