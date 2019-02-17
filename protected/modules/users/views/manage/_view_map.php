<?
/** @var $map_model UserAddresses*/
/** @var $id string */
/** @var $cssClass string */
// google map
$mapLat = $map_model->map_lat;
$mapLng = $map_model->map_lng;
$mapZoom = $map_model->map_zoom;
$mapZoom = 15;

$cssClass = isset($cssClass)?$cssClass:"";
$id = isset($id)?$id:"google-map";

if($map_model->map_lat) {
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
            mapTypeId: google.maps.MapTypeId.TERRAIN
          };

	    map = new google.maps.Map(document.getElementById('".$id."'),mapProp);
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
<div class="map-view <?= $cssClass ?>" id="<?= $id ?>"></div>
<style>
    .map-view{
        width: 100%;
        height: 300px;
    }
</style>