<?php
trait SitemapTrait{
    private $sitemapClassConfig = [
        array(
            'baseModel'=>'Cars',
            'frequency' => 'daily',
            'routeRegex'=>'/car/{id}-{brand.slug}-{model.slug}-for-sale',
            'params' => array(
                'id' => 'id',
                'brand' => 'brand.slug',
                'model' => 'model.slug',
            )
        ),
        array(
            'baseModel'=>'News',
            'frequency' => 'daily',
            'routeRegex'=>'/news/{id}/{title}',
            'params' => array(
                'id' => 'id',
                'title:urlencode' => 'title',
            )
        ),
    ];
    
    public function getBaseSitePageList(){

        $list = array(
            array(
                'label' => 'صفحه اصلی',
                'loc'=>Yii::app()->createAbsoluteUrl('/'),
                'frequency'=>'weekly',
                'priority'=>'1',
            ),
            array(
                'label' => 'اخبار',
                'loc'=>Yii::app()->createAbsoluteUrl('/news'),
                'frequency'=>'daily',
                'priority'=>'1',
            ),
            array(
                'label' => 'تماس با ما',
                'loc'=>Yii::app()->createAbsoluteUrl('/contact'),
                'frequency'=>'yearly',
                'priority'=>'0.8',
            ),
            array(
                'label' => 'درباره ما',
                'loc'=>Yii::app()->createAbsoluteUrl('/about'),
                'frequency'=>'monthly',
                'priority'=>'0.8',
            ),
            array(
                'label' => 'شرایط',
                'loc'=>Yii::app()->createAbsoluteUrl('/terms'),
                'frequency'=>'yearly',
                'priority'=>'0.3',
            ),
        );
        return $list;
    }
}