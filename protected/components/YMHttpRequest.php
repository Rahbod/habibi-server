<?php
class YMHttpRequest extends CHttpRequest
{
    public $noValidationRoutes = array();

    protected function normalizeRequest()
    {
        parent::normalizeRequest();
        if($this->enableCsrfValidation){
            $url = Yii::app()->getUrlManager()->parseUrl($this);
            foreach($this->noValidationRoutes as $route){
                if(strpos($url, $route) === 0)
                    Yii::app()->detachEventHandler('onBeginRequest', array($this, 'validateCsrfToken'));
            }
        }
    }
}