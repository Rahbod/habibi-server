<?php
/* @var $this Controller */
?>
<div class="page-header inner-page">
    <div class="top">
        <div class="center-box">
            <?php if($this->pageLogo):?><img src="<?= $this->pageLogo ?>" class="brand-logo" alt="<?= strip_tags($this->pageHeader) ?>"><?php endif; ?>
            <h2 class="brand-name<?= $this->layout == '//layouts/panel'?' user-detail':'' ?>"><?php echo $this->pageHeader ?><small><?php echo $this->pageDescription ?></small></h2>
        </div>
    </div>
    
    <div class="bottom overflow-fix">
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
            'homeLink' => $this->layout == '//layouts/panel'?false:'<li class="breadcrumb-item">'.CHtml::link(Yii::app()->name, Yii::app()->homeUrl).'</li>',
            'htmlOptions'=>array('class'=>'breadcrumb pull-right'.($this->layout == '//layouts/panel'?' blue':'')),
            'tagName' => 'ul',
            'activeLinkTemplate' => '<li class="breadcrumb-item"><a href="{url}">{label}</a></li>',
            'inactiveLinkTemplate' => '<li class="breadcrumb-item"><span>{label}</span></li>',
            'separator' => ''
        )); ?>
        <?php
        if(!$this->leftBox && ($this->layout == '//layouts/panel' || Yii::app()->request->url == Yii::app()->request->baseUrl.'/sell')):
        ?>
            <a href="<?= $this->createUrl('/upgradePlan') ?>"><div class="pull-left page-info bg-success upgrade-user-btn"><i class="honor-icon"></i><b>ارتقای عضویت</b></div></a>
        <?php
        else:
            echo $this->leftBox;
        endif;
        ?>
    </div>
</div>
