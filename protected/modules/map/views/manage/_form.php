<?php
/* @var $model GoogleMaps */
$mapLat = $model->map_lat!=''?$model->map_lat:34.6327505;
$mapLng = $model->map_lng!=''?$model->map_lng:50.8644157;
$mapZoom = $model->map_zoom!=''?$model->map_zoom:12;
$mapScript = "var map;
	var marker;
	var myCenter=new google.maps.LatLng(".$mapLat.",".$mapLng.");
	function initialize()
	{
		var mapProp = {
		center:myCenter,
		zoom:".$mapZoom.",
		mapTypeId: google.maps.MapTypeId.TERRAIN
		};
		map = new google.maps.Map(document.getElementById('googleMap'),mapProp);
		".($model->map_lat!=''&&$model->map_lng!=''?'placeMarker(myCenter,'.$mapZoom.');':'')."
		google.maps.event.addListener(map, 'click', function(event) {
			placeMarker(event.latLng,map.getZoom());
		});
	}

	function placeMarker(location,z) {
		if(marker != undefined)
			marker.setMap(null);
	  marker = new google.maps.Marker({
		position: location,
		map: map,
	  });
	  var content ='".$model->getAttributeLabel('map_lat')." : ' + location.lat() + '<br>".$model->getAttributeLabel('map_lng')." : ' + location.lng();
	  var infowindow = new google.maps.InfoWindow({
		content: content
	  });
	  infowindow.open(map,marker);
	  document.getElementById('map_lat').value = location.lat();
	  document.getElementById('map_lng').value = location.lng();
	  document.getElementById('map_zoom').value = z;
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	";
// google map
Yii::app()->clientScript->registerScriptFile('http://maps.googleapis.com/maps/api/js?key=AIzaSyDbhMDAxCreEWc5Due7477QxAVuBAJKdTM');
Yii::app()->clientScript->registerScript('googleMap', $mapScript);
?>

<? $this->renderPartial('//partial-views/_flashMessage'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'google-maps-form',
	'enableAjaxValidation'=>false,
));

echo $form->hiddenField($model , 'map_lat' ,array('id' => 'map_lat'));
echo $form->hiddenField($model , 'map_lng' ,array('id' => 'map_lng'));
echo $form->hiddenField($model , 'map_zoom' ,array('id' => 'map_zoom'));
?>
	<div class="form-group">
		<div class="map pull-right">
			<div id="googleMap" style="width: 100%; height: 100%"></div>
		</div>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره' ,array('class' => 'btn btn-success')); ?>
	</div>
<?php $this->endWidget(); ?>
<?
Yii::app()->clientScript->registerCss('map','
.map{
	width:100%;
	border-radius: 5px;
    display: block;
    height: 500px;
    overflow: hidden;
    position: relative;
    margin-bottom:15px;
}
.map #googleMap{
	 display: inline-block;
    height: 100%;
    width: 100%;
}
');