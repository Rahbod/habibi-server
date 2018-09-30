<div style="border: 1px solid #dadada; border-radius: 4px;display: block;overflow: hidden;" ><h2 style="margin-bottom:0;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: block;width: 100%;background-color: #0b3762;line-height:60px;color:#fff;font-size: 24px;text-align: right;padding-right: 50px"><?php echo Yii::app()->name ?><span style="font-size: 14px;color:#f0f0f0"><?php echo SiteSetting::getOption('site_description') ?></span></h2>
<div style="display: inline-block;width: 100%;font-family:tahoma;line-height: 28px;">
    <div style="direction:rtl;display:block;overflow:hidden;border:1px solid #efefef;text-align: center;padding:15px;">{MessageBody}</div>
</div>
<div style="font-size: 8pt;color: #bbb;text-align: right;font-family: tahoma;padding: 15px;">
    <a href="<?php echo ((strpos($_SERVER['SERVER_PROTOCOL'], 'https'))?'https://':'http://').$_SERVER['HTTP_HOST'].'/about';?>">درباره</a> | <a href="<?php echo ((strpos($_SERVER['SERVER_PROTOCOL'], 'https'))?'https://':'http://').$_SERVER['HTTP_HOST'].'/contact'; ?>">تماس با ما</a>
    <span style="float: left;"> همهٔ حقوق برای <?= Yii::app()->name ?> محفوظ است. ©‏ {CurrentYear} </span>
</div></div>