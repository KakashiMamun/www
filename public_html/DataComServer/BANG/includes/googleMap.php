    <script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAA0TTKDGcDU_CSTRSzZZIIZhQGDwfolOEAvUGmNN27MQhUpy2Y5RSgCA_4loiiZ7E0f85KUAkzMcNEFQ" type="text/javascript"></script>
    <script type="text/javascript">

    var map = null;
    var geocoder = null;

    function initialize() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(37.4419, -122.1419), 13);     
              map.setUIToDefault();
        geocoder = new GClientGeocoder();
      }
    }

    function showAddress(address) {
      if (geocoder) {
        geocoder.getLatLng(
          address,
          function(point) {
            if (!point) {
              alert(address + " not found");
            } else {
              map.setCenter(point, 13);      
              map.setUIToDefault();
              var marker = new GMarker(point);
              map.addOverlay(marker);
              marker.openInfoWindowHtml(address);

            }
          }
        );
      }
    }
    </script>

    
  <body onload="initialize()" onunload="GUnload()">
    <form action="#" onsubmit="showAddress(this.address.value); return false">
      <p>
        <input type="text" size="60" name="address" value="1600 Amphitheatre Pky, Mountain View, CA" />
        <input type="submit" value="Go!" />
      </p>
      <div id="map_canvas" style="width: 1000px; height: 500px"></div>
    </form>

