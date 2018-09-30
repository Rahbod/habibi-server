<?php
foreach( $list as $row ):
echo CHtml::link($row['label'], $row['loc']);
echo CHtml::tag('br');
endforeach;