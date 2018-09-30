<?php
/* @var $this SiteController */
/* @var $error array */
?>
<div class="page-error">
    <div class="code"><?php echo $code; ?></div>
    <div class="title" dir="auto">
        <?php echo CHtml::encode($message);?>
        <?php if(Yii::app()->request->hostInfo == 'http://localhost'):?>
            <small style="display: block;margin-top: 40px;"><?= Yii::app()->errorHandler->error['file'] . '(' . Yii::app()->errorHandler->error['line'] . ')'?></small>
        <?php endif;?>
    </div>

    <div class="buttons">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <a href="<?php echo Yii::app()->getBaseUrl(true);?>" class="btn btn-danger btn-block">صفحه اصلی <i class="arrow-icon right"></i></a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <button id="back-btn" onclick="history.back();" class="btn btn-info btn-block"><i class="arrow-icon left"></i> بازگشت</button>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copyright">
        <div class="ltr">
            <?php $this->renderPartial('//partial-views/_copyright');?>
        </div>
        <div>
            <a href="<?php echo $this->createUrl('/help')?>">راهنما</a> / <a href="#">تماس با ما</a>
        </div>
    </div>
    <!-- ./Copyright -->

</div>
<script>
    $(function () {
        if(history.length <= 1)
            $("#back-btn").attr("disabled", true);
    });
</script>