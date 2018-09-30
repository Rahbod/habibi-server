<?
// google map
Yii::import('map.models.GoogleMaps');
$map_model = GoogleMaps::model()->findByPk(1);
$mapLat = $map_model->map_lat;
$mapLng = $map_model->map_lng;
$mapZoom = $map_model->map_zoom;
if($map_model) {
    Yii::app()->clientScript->registerScriptFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDbhMDAxCreEWc5Due7477QxAVuBAJKdTM');
    Yii::app()->clientScript->registerScript('googleMap', "
    var map;
	var marker;
	var myCenter=new google.maps.LatLng(" . $mapLat . "," . $mapLng . ");
	function initialize()
	{
		var mapProp = {
          center:myCenter,
          zoom:" . $mapZoom . ",
          mapTypeId: google.maps.MapTypeId.TERRAIN,
         
          };

	    map = new google.maps.Map(document.getElementById('google-map'),mapProp);
		placeMarker(myCenter ,map);
	}

	function placeMarker(location ,map) {

		if(marker != undefined)
			marker.setMap(null);
	    marker = new google.maps.Marker({
            position: location,
            map: map,
        });
	}
	google.maps.event.addDomListener(window, 'load', initialize);",CClientScript::POS_READY);
}
?>
<div id="google-map"></div>