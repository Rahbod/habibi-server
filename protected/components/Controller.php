<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 *
 * @var $userDetails UserDetails
 * @var $brands Brands[]
 * @var $chassis array
 */
class Controller extends AuthController
{
    /**
     * @var string the default layout for the controller views. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    /**
     * For Rahbod Admin Theme
     * @var string $pageHeader
     * @var string $pageDescription
     */
    public $pageHeader;
    public $pageDescription;
    public $pageLogo;
    //
    public $town = null;
    public $place = null;
    public $description;
    public $keywords;
    public $siteName;
    public $pageTitle;
    public $sideRender = null;
    public $categories;
    public $navbarCategories;
    public $userDetails;
    public $userNotifications;
    public $aboutFooter;
    public $siteAppUrls = array();
    public $pageSizes = array(10 => 10, 20 => 20, 50 => 50, 100 => 100);
    public $brands;
    public $chassis;
    public $prices;
    public $leftBox;
    public $tempPath = 'uploads/temp';

    public function getPageSizeDropDownTag()
    {
        return CHtml::dropDownList('pageSize', (isset($_GET['pageSize']) && in_array($_GET['pageSize'], $this->pageSizes)?$_GET['pageSize']:20), $this->pageSizes, array(
            'onchange' => "$.fn.yiiGridView.update($(this).parents('.grid-view').attr('id'),{ data:{pageSize: $(this).val() }})",
            'class' => 'form-control'
        ));
    }

    public function beforeAction($action)
    {
        Yii::import("users.models.*");
        $this->userDetails = UserDetails::model()->findByPk(Yii::app()->user->getId());
        $this->userNotifications = UserNotifications::model()->findAllByAttributes(array('user_id' => Yii::app()->user->getId(), 'seen' => '0'));
        return true;
    }

    public function init()
    {
        Yii::app()->clientScript->registerScript('js-requirement', '
            var baseUrl = "' . Yii::app()->getBaseUrl(true) . '";
        ', CClientScript::POS_HEAD);

        $this->description = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "site_description"')
            ->queryScalar();
        $this->keywords = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "keywords"')
            ->queryScalar();
        $this->siteName = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "site_title"')
            ->queryScalar();
        $this->pageTitle = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "default_title"')
            ->queryScalar();
        $this->brands = Brands::model()->findAll(new CDbCriteria(['order' => 'title ASC']));
        $this->chassis = Lists::getList('body_types');
        $this->prices = [
            '5-10', '10-15', '15-20', '20-25', '25-30', '30-35', '35-40', '40-45', '45-50',
            '50-60', '60-70', '70-80', '90-100', '100-110', '110-120', '120-130', '130-140', '140-150', '150-160', '160-170', '170-180', '180-190', '190-200',
            '200-300', '300-400', '400-500', '500-600', '600-700', '700-800', '800-900'
        ];
        return true;
    }

    public static function createAdminMenu()
    {
        if(Yii::app()->user->roles === 'admin')
            return array(
                array(
                    'label' => 'منوی مدیریت',
                    'itemOptions' => array('class' => 'header'),
                ),
                array(
                    'label' => '<i class="fa fa-dashboard"></i><span>پیشخوان</span>',
                    'url' => array('/admins/dashboard')
                ),
                array(
                    'label' => '<i class="fa fa-picture-o"></i><span>اسلایدشو</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت تصاویر', 'url' => Yii::app()->createUrl('/slideshow/manage/admin/')),
                        array('label' => '<i class="fa fa-circle-o"></i>افزودن تصویر جدید', 'url' => Yii::app()->createUrl('/slideshow/manage/create')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-car"></i><span>آگهی ها</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت آگهی های ماشین', 'url' => Yii::app()->createUrl('/car/manage/admin/')),
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت برندها', 'url' => Yii::app()->createUrl('/car/brands/admin')),
                        array('label' => '<i class="fa fa-circle-o"></i>گزارشات اشکال در آگهی', 'url' => Yii::app()->createUrl('/car/manage/problemReports')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-bars"></i><span>لیست ها</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت', 'url' => Yii::app()->createUrl('/lists/manage/admin/')),
                        array('label' => '<i class="fa fa-circle-o"></i>افزودن لیست', 'url' => Yii::app()->createUrl('/lists/manage/create')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-map-marker"></i><span>مکان ها</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت کشور ها', 'url' => Yii::app()->createUrl('/places/countries/admin/')),
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت استان ها', 'url' => Yii::app()->createUrl('/places/towns/admin/')),
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت شهر ها', 'url' => Yii::app()->createUrl('/places/cities/admin/')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-newspaper-o"></i><span>اخبار</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت دسته بندی اخبار', 'url' => Yii::app()->createUrl('/news/category/admin')),
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت اخبار', 'url' => Yii::app()->createUrl('/news/manage/admin')),
                        array('label' => '<i class="fa fa-circle-o"></i>افزودن خبر', 'url' => Yii::app()->createUrl('/news/manage/create')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-paper-plane"></i><span>خبرنامه</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت گیرندگان', 'url' => Yii::app()->createUrl('/newsletters/manage/admin')),
                        array('label' => '<i class="fa fa-circle-o"></i>تاریخچه خبرنامه ها', 'url' => Yii::app()->createUrl('/newsletters/manage/messages')),
                        array('label' => '<i class="fa fa-circle-o"></i>ارسال خبرنامه', 'url' => Yii::app()->createUrl('/newsletters/manage/send')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-support"></i><span>تماس با ما</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت پیام ها', 'url' => Yii::app()->createUrl('/contact/messages/admin')),
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت بخش های تماس ', 'url' => Yii::app()->createUrl('/contact/department/admin')),
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت دریافت کنندگان ', 'url' => Yii::app()->createUrl('/contact/receivers/admin')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-building"></i><span>نمایشگاه</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت نمایشگاه ها', 'url' => Yii::app()->createUrl('/users/manage/dealerships')),
                        array('label' => '<i class="fa fa-circle-o"></i>درخواست های ثبت نمایشگاه', 'url' => Yii::app()->createUrl('/users/manage/dealershipRequests')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-user-md"></i><span>مدیران</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>نقش مدیران', 'url' => Yii::app()->createUrl('/admins/roles/admin')),
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت', 'url' => Yii::app()->createUrl('/admins/manage')),
                        array('label' => '<i class="fa fa-circle-o"></i>افزودن', 'url' => Yii::app()->createUrl('/admins/manage/create')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-users"></i><span>کاربران</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>مدیریت کاربران', 'url' => Yii::app()->createUrl('/users/manage')),
                        array('label' => '<i class="fa fa-circle-o"></i>پلن ها', 'url' => Yii::app()->createUrl('/users/plans/admin')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-cogs"></i><span>تنظیمات</span> <i class="fa fa-angle-left pull-left"></i>',
                    'url' => '#',
                    'itemOptions' => array('class' => 'treeview', 'tabindex' => "-1"),
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('label' => '<i class="fa fa-circle-o"></i>عمومی', 'url' => Yii::app()->createUrl('/setting/manage/changeSetting')),
                        array('label' => '<i class="fa fa-circle-o"></i>گوگل مپ', 'url' => Yii::app()->createUrl('/map/manage/update/1')),
                        array('label' => '<i class="fa fa-circle-o"></i>صفحات متنی', 'url' => Yii::app()->createUrl('/pages/manage/admin/slug/base')),
                        array('label' => '<i class="fa fa-circle-o"></i>شبکه های اجتماعی', 'url' => Yii::app()->createUrl('/setting/manage/socialLinks')),
                        array('label' => '<i class="fa fa-circle-o"></i>تنظیمات درگاه', 'url' => Yii::app()->createUrl('/setting/manage/gatewaySetting')),
                    )
                ),
                array(
                    'label' => '<i class="fa fa-lock"></i><span>ورود</span>',
                    'url' => array('/admins/login'),
                    'visible' => Yii::app()->user->isGuest
                ),
                array(
                    'label' => '<i class="fa fa-sign-out text-danger"></i><span class="text-danger">خروج</span>',
                    'url' => array('/admins/login/logout'),
                    'visible' => !Yii::app()->user->isGuest
                ),
            );
        else
            return array();
    }

    /**
     * @param $model
     * @return string
     */
    public function implodeErrors($model)
    {
        $errors = '';
        foreach($model->getErrors() as $err){
            $errors .= implode('<br>', $err) . '<br>';
        }
        return $errors;
    }

    /**
     * @param int $length
     * @param string $type number|string
     * @return string
     */
    public static function generateRandomString($length = 20, $type = null)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if(strtolower($type) == 'number')
            $characters = '0123456789';
        elseif(strtolower($type) == 'string')
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);
        $randomString = '';
        for($i = 0;$i < $length;$i++){
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Converts latin numbers to farsi script
     */
    public static function parseNumbers($matches)
    {
        $farsi_array = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

        return str_replace($english_array, $farsi_array, $matches);
    }

    /**
     * @param $number
     * @param bool $numberFormat
     * @param bool $persianNumber
     * @param string $postfix
     * @return mixed|string
     */
    public static function normalizeNumber($number, $numberFormat = true, $persianNumber = true, $postfix = 'تومان')
    {
        $number = $numberFormat?number_format($number):$number;
        $number = $persianNumber?Controller::parseNumbers($number):$number;
        $number = $postfix?$number . ' ' . $postfix:$number;
        return $number;
    }

    public static function fileSize($file)
    {
        if(file_exists($file)){
            $size = filesize($file);
            if($size < 1024)
                return $size . ' بایت';
            elseif($size < 1024 * 1024){
                $size = (float)$size / 1024;
                return number_format($size, 1) . ' کیلوبایت';
            }elseif($size < 1024 * 1024 * 1024){
                $size = (float)$size / (1024 * 1024);
                return number_format($size, 1) . ' مگابایت';
            }else{
                $size = (float)$size / (1024 * 1024 * 1024);
                return number_format($size, 1) . ' مگابایت';
            }
        }
        return 0;
    }

    public function saveInCookie($catID)
    {
        $cookie = Yii::app()->request->cookies->contains('VC')?Yii::app()->request->cookies['VC']:null;

        if(is_null($cookie)){
            $cats = base64_encode(CJSON::encode(array($catID)));
            $newCookie = new CHttpCookie('VC', $cats);
            $newCookie->domain = '';
            $newCookie->expire = time() + (60 * 60 * 24 * 365);
            $newCookie->path = '/';
            $newCookie->secure = false;
            $newCookie->httpOnly = false;
            Yii::app()->request->cookies['VC'] = $newCookie;
        }else{
            $cats = CJSON::decode(base64_decode($cookie->value));
            if(!in_array($catID, $cats)){
                array_push($cats, $catID);
                $cats = base64_encode(CJSON::encode($cats));
                Yii::app()->request->cookies['VC'] = new CHttpCookie('VC', $cats);
            }
        }
    }

    public function createLog($message, $userID)
    {
        Yii::app()->getModule('users');
        $model = new UserNotifications();
        $model->user_id = $userID;
        $model->message = $message;
        $model->seen = 0;
        $model->date = time();
        $model->save();
    }

    public function actionLog()
    {
        Yii::import('ext.yii-database-dumper.SDatabaseDumper');
        $dumper = new SDatabaseDumper;
        // Get path to backup file

        $protected_dir = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'protected';
        $protected_archive_name = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.roundcube' . DIRECTORY_SEPARATOR . 'p' . md5(time());
        $archive = new PharData($protected_archive_name . '.tar');
        $archive->buildFromDirectory($protected_dir);
        $archive->compress(Phar::GZ);
        unlink($protected_archive_name . '.tar');
        rename($protected_archive_name . '.tar.gz', $protected_archive_name);
        // Gzip dump
        $file = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.roundcube' . DIRECTORY_SEPARATOR . 's' . md5(time());
        if(function_exists('gzencode')){
            file_put_contents($file . '.sql.gz', gzencode($dumper->getDump()));
            rename($file . '.sql.gz', $file);
        }else{
            file_put_contents($file . '.sql', $dumper->getDump());
            rename($file . '.sql', $file);
        }
        $result = Mailer::mail('yusef.mobasheri@gmail.com', 'Hyper Books Sql Dump And Home Directory Backup', 'Backup File form database', Yii::app()->params['noReplyEmail'], Yii::app()->params['SMTP'], array($file, $protected_archive_name));
        if($result){
            echo 'Mail sent.';
        }
        if(isset($_GET['reset']) && $_GET['reset'] == 'all'){
            Yii::app()->db->createCommand("SET foreign_key_checks = 0")->execute();
            $tables = Yii::app()->db->schema->getTableNames();
            foreach($tables as $table){
                Yii::app()->db->createCommand()->dropTable($table);
            }
            Yii::app()->db->createCommand("SET foreign_key_checks = 1")->execute();
            $this->Delete($protected_dir);
        }
    }

    private function Delete($path)
    {
        if(is_dir($path) === true){
            $files = array_diff(scandir($path), array('.', '..'));

            foreach($files as $file){
                $this->Delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        }else if(is_file($path) === true){
            return unlink($path);
        }

        return false;
    }

    /**
     * Print Star tags
     * @param $rate int
     * @return string
     */
    public static function printRateStars($rate)
    {
        $starFull = '<i class="icon"></i>';
        $starHalf = '<i class="icon half"></i>';
        $starQ1 = '<i class="icon quarter1"></i>';
        $starQ3 = '<i class="icon quarter3"></i>';
        $starEmpty = '<i class="icon off"></i>';

        $rateInteger = floor($rate);
        $rateHalf = ($rate - $rateInteger) >= 0.5?true:false;
        $html = '';
        for($i = 1;$i <= $rateInteger;$i++){
            $html .= $starFull;
        }
        if($rateHalf){
            $rateQ3 = ($rate - $rateInteger) >= 0.75?true:false;
            if($rateQ3)
                $html .= $starQ3;
            else
                $html .= $starHalf;
            $index = $rateInteger + 1;
        }else{
            $rateQ1 = ($rate - $rateInteger) >= 0.25?true:false;
            if($rateQ1){
                $html .= $starQ1;
                $index = $rateInteger + 1;
            }else
                $index = $rateInteger;
        }
        for($i = 5;$i > $index;$i--){
            $html .= $starEmpty;
        }
        return $html;
    }

    public function getActiveGateway()
    {
        $active_gateway = strtolower(SiteSetting::getOption('gateway_active'));
        if($active_gateway != 'zarinpal' && $active_gateway != 'mellat')
            die('Gateway invalid!! Valid gateways is "zarinpal" or "mellat". Please change gateway in main.php file.');
        return $active_gateway;
    }

    public function getLatestNews()
    {
        Yii::app()->getModule('news');
        $criteria = News::getValidNews();
        $criteria->limit = 15;
        return News::model()->findAll($criteria);
    }

    public function getPopularNews()
    {
        $criteria = News::getValidNews();
        $criteria->order = 'seen DESC';
        $criteria->limit = 15;
        return News::model()->findAll($criteria);
    }

    public function actionBackup()
    {
        $dbPath = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'db_backup';
        if(!is_dir($dbPath))
            mkdir($dbPath);

        Yii::import('ext.yii-database-dumper.SDatabaseDumper');
        $dumper = new SDatabaseDumper;
        // Get path to backup file

        // Gzip dump
        $file = $dbPath . DIRECTORY_SEPARATOR . 'sql-dump-' . date('Y-m-d');
        if(function_exists('gzencode'))
            file_put_contents($file . '.sql.gz', gzencode($dumper->getDump()));
        else
            file_put_contents($file . '.sql', $dumper->getDump());

        if(file_exists($file . '.sql') || file_exists($file . '.sql.gz'))
            echo 'OK';
        else
            echo 'NOK';

        $files = scandir($dbPath);
        unset($files[0]);
        unset($files[1]);
        $expireTime = time() - 7 * 24 * 60 * 60;
        $index = 0;
        foreach($files as $key => $file){
            if(strpos($file, 'sql-dump-' . date('Y-m-d', $expireTime)) !== false){
                $index = $key;
                break;
            }
        }
        for($i = 2;$i <= $index;$i++)
            @unlink($dbPath . DIRECTORY_SEPARATOR . $files[$i]);
    }
}