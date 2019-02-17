<?php
class dynamicField extends CInputWidget
{
    public $id;
    public $attributes = [];
    public $template = '{input-0}';
    public $addButton = [];
    public $afterAdd = null;
    public $max = false;
    public $models;

    private $publishedAssetsPath;

    public function init()
    {
        if (empty($this->attributes))
            throw new CHttpException(500, 'attributes تنظیم نشده است.');

        foreach ($this->attributes as $key => $value)
            if (strpos($this->template, "{input-$key}") === false)
                throw new CHttpException(500, "رشته {input-$key} در مشخصه template وجود ندارد.");

        if (Yii::getPathOfAlias('dynamicField') === false)
            Yii::setPathOfAlias('dynamicField', realpath(dirname(__FILE__) . '/..'));

        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile($this->getAssetsUrl() . DIRECTORY_SEPARATOR . 'dynamic-field.js');
        $cs->registerCssFile($this->getAssetsUrl() . DIRECTORY_SEPARATOR . 'dynamic-field.css');

        if (!is_null($this->afterAdd))
            $cs->registerScript(__CLASS__ . $this->id, 'window.dynamicFieldCallback = ' . $this->afterAdd, CClientScript::POS_END);

        if(!isset($this->addButton['class']))
            $this->addButton['class'] = 'btn btn-primary';

        if(!isset($this->addButton['title']))
            $this->addButton['title'] = 'افزودن ردیف جدید';

        $this->render('html', array(
            'models' => $this->models,
            'attributes' => $this->attributes,
            'max' => $this->max,
            'id' => $this->id,
            'template' => $this->template,
            'addBtnClass' => $this->addButton['class'],
            'addBtnTitle' => $this->addButton['title'],
        ));
    }

    public function getAssetsUrl()
    {
        if (!isset($this->publishedAssetsPath)) {
            $assetsSourcePath = Yii::getPathOfAlias('ext.dynamicField.assets');

            $publishedAssetsPath = Yii::app()->assetManager->publish($assetsSourcePath, false, -1);

            return $this->publishedAssetsPath = $publishedAssetsPath;
        } else return $this->publishedAssetsPath;
    }
}