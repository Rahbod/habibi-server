<?php
/* @var $models CActiveRecord[] */
/* @var $attributes array */
/* @var $max integer */
/* @var $id string */
/* @var $template string */
/* @var $addBtnClass string */
/* @var $addBtnTitle string */
?>
<div id="<?php echo $id;?>">
    <?php foreach($models as $modelKey => $model):?>
        <div class="dynamic-input-container">
            <?php
            $temp = $template;
            foreach($attributes as $key => $attribute):
                $name = $attribute['name'];
                $inputType = $attribute['inputType'];
                $htmlOptions = isset($attribute['htmlOptions']) ? $attribute['htmlOptions'] : [];
                $input = CHtml::$inputType(get_class($model).'['.$name.']['.$modelKey.']', $model->$name, $htmlOptions);
                $temp = str_replace("{input-$key}", $input, $temp);
            endforeach;
            ?>
            <a href="#" class="remove-dynamic-field"><i class="icon icon-trash"></i></a>
            <?php echo $temp;?>
        </div>
    <?php endforeach;?>
</div>
<div class="form-group">
    <button class="<?php echo $addBtnClass;?> add-dynamic-input" data-input-container="#<?php echo $id;?>" data-count="1" type="button"><?php echo $addBtnTitle?></button>
</div>