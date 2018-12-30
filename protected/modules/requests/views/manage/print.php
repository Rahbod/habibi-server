<?php
/** @var $model Requests */
/** @var $invoice Invoices */
?>

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
        <td><b>هزینه اضافی</b><p style="margin: 0"><small><?= $invoice->additional_description ?></small></p></td>
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