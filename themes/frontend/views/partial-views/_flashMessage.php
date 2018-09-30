<?php
if(!isset($prefix))
    $prefix = '';
?>

<?php if(Yii::app()->user->hasFlash($prefix.'success')):?>
    <div class="alert alert-success view-flash">
        <p>
            <span><?php echo Yii::app()->user->getFlash($prefix.'success');?></span>
            <button class="close" type="button" data-dismiss="alert">&times;</button>
        </p>
    </div>
<?php elseif(Yii::app()->user->hasFlash($prefix.'failed')):?>
    <div class="alert alert-danger view-flash">
        <p>
            <span><?php echo Yii::app()->user->getFlash($prefix.'failed');?></span>
            <button class="close" type="button" data-dismiss="alert">&times;</button>
        </p>
    </div>
<?php elseif(Yii::app()->user->hasFlash($prefix.'warning')):?>
    <div class="alert alert-warning view-flash">
        <p>
            <span><?php echo Yii::app()->user->getFlash($prefix.'warning');?></span>
            <button class="close" type="button" data-dismiss="alert">&times;</button>
        </p>
    </div>
<?php endif;?>
<?php
Yii::app()->clientScript->registerScript('flash-hide', "
    setTimeout(function(){
        $('.view-flash').fadeOut(function(){
            $('.view-flash').remove();
        });
    }, 5000);
", CClientScript::POS_READY);