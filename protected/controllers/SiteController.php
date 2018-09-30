<?php

class SiteController extends Controller
{
    use SitemapTrait;
    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'frontend' => array(
                'index',
                'error',
                'contact',
                'about',
                'terms',
                'contactUs',
                'help',
                'sitemap',
            )
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&views=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
            'sitemap'=>array(
                'class'=>'ext.sitemap.ESitemapAction',
                'importListMethod'=>'getBaseSitePageList',
                'classConfig'=>$this->sitemapClassConfig,
                'theme' => 'frontend',
                'layout' => '//layouts/sitemap',
            ),
            'sitemapxml'=>array(
                'class'=>'ext.sitemap.ESitemapXMLAction',
                'classConfig'=>$this->sitemapClassConfig,
                'importListMethod'=>'getBaseSitePageList',
            ),
        );
    }

    

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        Yii::app()->theme = "frontend";
        $this->layout = "public";
        Yii::app()->getModule("slideshow");
        $slideShow = Slideshow::model()->findAll();
        $criteria = new CDbCriteria();
        $criteria->select = 't.*, COUNT(cars.id) as c';
        $criteria->together = true;
        $criteria->with = array('cars');
        $criteria->group = 't.id';
        $criteria->order = 'c DESC';
        $topBrands = Brands::model()->findAll($criteria);
        $this->render('index', array(
            'slideShow' => $slideShow,
            'topBrands' => $topBrands
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/error';
        if($error = Yii::app()->errorHandler->error){
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        Yii::app()->getModule('contact');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $model = new ContactForm();
        if(isset($_POST['ContactForm'])){
            $model->attributes = $_POST['ContactForm'];
            $contactModel = new ContactMessages();
            $contactModel->attributes = $_POST['ContactForm'];
            $dep = ContactDepartment::model()->findByPk($contactModel->department_id);
            if($model->validate() && $contactModel->save()){
                $siteName = Yii::app()->name;
                $subject = 'وبسايت آراخودرو - پیغام در بخش ' . $dep->title . ($model->subject && !empty($model->subject)?' - ' . $model->subject:'');
                $body = "<div style='padding:15px;white-space: pre-line'>"
                    . "<p>متن پیام:</p>"
                    . "<p>" . $model->body . "</p>"
                    . "<p>"
                    . "<strong>نام فرستنده : </strong>" . $model->name . "<br>"
                    . "<strong>شماره تماس : </strong>" . $model->tel
                    . "</p><br><br>
                    <p>"
                    . "<strong>برای ارسال پاسخ روی لینک زیر کلیک کنید: </strong><br>" .
                    CHtml::link(Yii::app()->createAbsoluteUrl('/contact/messages/view?id=' . $contactModel->id),
                        Yii::app()->createAbsoluteUrl('/contact/messages/view?id=' . $contactModel->id), array(
                            'style' => 'color:#1aa4de;font-size:12px'
                        ))
                    . "</p>
                    <hr>
                    <span style='font-size:10px'>
                    ارسال شده توسط وبسايت {$siteName}
                    </span>
                    </div>                  
                    ";
                $receivers = [];
                $receivers[] = SiteSetting::getOption('master_email');
                foreach($contactModel->department->receivers as $receiver)
                    $receivers[] = $receiver->email;
                Mailer::mail($receivers, $subject, $body, $model->email);
                Yii::app()->user->setFlash('success', 'باتشکر. پیغام شما با موفقیت ارسال شد.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    public function actionAbout()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/public';
        $model = Pages::model()->findByPk(1);
        $this->render('//site/pages/page', array('model' => $model));
    }

    public function actionTerms()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/public';
        $model = Pages::model()->findByPk(2);
        $this->render('//site/pages/page', array('model' => $model));
    }

    public function actionContactUs()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/public';
        $model = Pages::model()->findByPk(8);
        $this->render('//site/pages/page', array('model' => $model));
    }

    public function actionHelp()
    {
        Yii::import('pages.models.*');
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/public';
        $model = Pages::model()->findByPk(3);
        $this->render('//site/pages/page', array('model' => $model));
    }
}