<?php
/** @var $model Requests */
/** @var $invoice Invoices */
?>
<h3>اطلاعات درخواست</h3>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'itemCssClass'=>array('',''),
    'htmlOptions' => array('class'=>'detail-view table table-striped table-bordered'),
    'attributes'=>array(
        'id',
        [
            'label' => $model->getAttributeLabel('category_id'),
            'value' => $model->category?$model->category->title:'<span class="text-danger">حذف شده</span>',
        ],
        [
            'label' => $model->getAttributeLabel('user_id'),
            'value' => $model->user && $model->user->userDetails?$model->user->userDetails->getShowName():'<span class="text-danger">حذف شده</span>',
        ],
        [
            'label' => $model->getAttributeLabel('user_address_id'),
            'value' => $model->userAddress?$model->userAddress->showAddress():'<span class="text-danger">حذف شده</span>',
            'type' => 'raw'
        ],
        [
            'label' => $model->getAttributeLabel('operator_id'),
            'value' => $model->operator?$model->operator->name_family:'<span class="text-danger">حذف شده</span>',
            'type' => 'raw'
        ],
        [
            'label' => $model->getAttributeLabel('repairman_id'),
            'value' => $model->repairman_id?($model->repairman && $model->repairman->userDetails?$model->repairman->userDetails->getShowName(false):'<span class="text-danger">حذف شده</span>'):null,
            'type' => 'raw'
        ],

        [
            'label' => $model->getAttributeLabel('requested_date'),
            'value' => $model->requested_date?"<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d', $model->requested_date)."</span>":null,
            'type' => 'raw'
        ],
        [
            'label' => $model->getAttributeLabel('requested_time'),
            'value' => $model->requested_time?Requests::$serviceTimes[$model->requested_time]:null,
            'type' => 'raw'
        ],
        [
            'label' => $model->getAttributeLabel('service_date'),
            'value' => $model->service_date?"<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d', $model->service_date)."</span>":null,
            'type' => 'raw'
        ],
        [
            'label' => $model->getAttributeLabel('service_time'),
            'value' => $model->service_time?Requests::$serviceTimes[$model->service_time]:null,
            'type' => 'raw'
        ],
        [
            'label' => $model->getAttributeLabel('create_date'),
            'value' => "<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d H:i', $model->create_date)."</span>",
            'type' => 'raw'
        ],
        [
            'label' => $model->getAttributeLabel('modified_date'),
            'value' => "<span dir='ltr' class='text-right'>".JalaliDate::date('Y/m/d H:i', $model->modified_date)."</span>",
            'type' => 'raw'
        ]
    ),
)); ?>
<h3>اطلاعات فاکتور</h3>
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th width="5%">ردیف</th>
        <th>نام سرویس</th>
        <th width="15%">هزینه سرویس</th>
        <th width="15%">تخفیف</th>
        <th width="20%">هزینه با تخفیف</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($invoice->items as $key => $item):?>
        <tr>
            <td><?= $key+1 ?></td>
            <td><?= $item->tariff->title ?></td>
            <td><?= $item->tariff->id == 1?"--":Controller::parseNumbers(number_format($item->tariff->cost))." <small>تومان</small>" ?></td>
            <td><?= ($item->cost < $item->tariff->cost)?Controller::parseNumbers(number_format(intval($item->tariff->cost - $item->cost))) . " <small>تومان</small>":'--'; ?></td>
            <td><?= Controller::parseNumbers(number_format($item->cost)) ?> <small>تومان</small></td>
        </tr>
    <?php endforeach;?>
    <tr class="warning">
        <td><?= $key+2 ?></td>
        <td><b>هزینه جانبی</b><p style="margin: 0"><small><?= $invoice->additional_description ?></small></p></td>
        <td><?= Controller::parseNumbers(number_format($invoice->additional_cost)) ?> <small>تومان</small></td>
        <td>--</td>
        <td><?= Controller::parseNumbers(number_format($invoice->additional_cost)) ?> <small>تومان</small></td>
    </tr>
    <!--                <tr class="warning text-warning">-->
    <!--                    <td colspan="3" style="background-color: #FFF; border: 0px;">&nbsp;</td>-->
    <!--                    <th class="text-left">هزینه اضافی</th>-->
    <!--                    <td >--><?php //echo number_format($invoice->additional_cost)?><!-- <small>تومان</small></td>-->
    <!--                </tr>-->
    <tr class="info text-info">
        <td colspan="3" style="background-color: #FFF; border: 0px;">&nbsp;</td>
        <th class="text-left">مجموع</th>
        <td ><?php echo Controller::parseNumbers(number_format($invoice->totalCost() + intval($invoice->total_discount)))?> <small>تومان</small></td>
    </tr>
    <tr class="success text-success">
        <td colspan="3" style="background-color: #FFF; border: 0px;">&nbsp;</td>
        <th class="text-left">جمع تخفیفات</th>
        <td ><?php echo Controller::parseNumbers(number_format($invoice->total_discount))?> <small>تومان</small></td>
    </tr>
    <tr class="danger text-danger" style="font-size: 20px;font-weight: bold">
        <td colspan="3" style="background-color: #FFF; border: 0px;">&nbsp;</td>
        <th class="text-left">قیمت کل</th>
        <td><?php echo Controller::parseNumbers(number_format($invoice->totalCost()))?> <small>تومان</small></td>
    </tr>
    </tbody>
</table>


<script>
    window.print();
</script>