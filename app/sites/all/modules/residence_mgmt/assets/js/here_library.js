/**
 * Here Map Management
 * Author : Rachid Aou
 * API KEY : XbtFBu4z4GHw4B_nIv1A-6d9OixFidUGKc_41OIxoN8
 * userrname : hafivij748@oncloud.ws
 * password : hafivij748
 */


/**
 * init Map
 * @param string apiKey
 * @param Element element
 */
function initHereMap(apikey, element) {

    var hereMap = {
      platform : null,
      defaultLayers : null,
      map : null,
      behavior : null,
      ui : null
    };

    hereMap.platform = new H.service.Platform({ 'apikey': apikey });
    hereMap.defaultLayers = hereMap.platform.createDefaultLayers();

    hereMap.map =  new H.Map(
        element,
        hereMap.defaultLayers.vector.normal.map,
        {
            zoom: 10,
            center: { lat: 48.8589507, lng: 2.2770198 },
            pixelRatio: window.devicePixelRatio || 1
        }
    );

    window.addEventListener('resize', function() { hereMap.map.getViewPort().resize(); });

    hereMap.behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(hereMap.map));
    hereMap.ui = H.ui.UI.createDefault(hereMap.map, hereMap.defaultLayers, 'fr-FR');

    return hereMap;

}

/**
 * change the default center map view
 * @param object coordinate : { lat: 33.590070, lng: -7.653931 }
 */
function updateCenter(hereMap, coordinate) {
    hereMap.map.setCenter(coordinate);
}

/**
 * add marker to the map
 * @param object coordinate: { lat: 33.590070, lng: -7.653931 }
 * @param H.map.Icon icon
 */
function addMarker(hereMap, coordinate, icon) {
    var marker = new H.map.Marker(coordinate, { icon: icon });
    hereMap.map.addObject(marker);
}

/**
 * Show Info bubble after the click event was triggered
 * @param object markerObject
 * @param string html
 */
function addInfoBubble(hereMap, markerObject, html) {
    if(!markerObject) {console.error('missing');return,}
    var group = new H.map.Group();
    hereMap.map.addObject(group);

    group.addEventListener('tap', function (evt) {
        var bubble =  new H.ui.InfoBubble(evt.target.getGeometry(), {
            content: evt.target.getData()
        });
        bubble.addClass('infoBubble-wrapper');
        hereMap.ui.addBubble(bubble);
    }, false);


    markerObject.setData(html);
    group.addObject(markerObject);
}


/**
 * add Full Screen UI Control
 */
function addFullScreenUIControl(hereMap, controlName = "myCustomControl") {
    var myCustomControl = new H.ui.Control();
    myCustomControl.addClass("custom-control");
    hereMap.ui.addControl(controlName, myCustomControl);
    myCustomControl.setAlignment(H.ui.LayoutAlignment.BOTTOM_LEFT);

    var myCustomPanel = new H.ui.base.OverlayPanel();
    myCustomPanel.addClass("custom-panel");
    myCustomControl.addChild(myCustomPanel);

    // store original styles
    var mapDiv = hereMap.ui.getMap().getElement();
    let divStyle = mapDiv.style;
    if (mapDiv.runtimeStyle) {
      divStyle = mapDiv.runtimeStyle;
    }

    const originalPos = divStyle.position;
    let originalWidth = divStyle.width;
    let originalHeight = divStyle.height;

    // ie8 hack
    if (originalWidth === "") { originalWidth = mapDiv.style.width; }
    if (originalHeight === "") { originalHeight = mapDiv.style.height; }

    var originalTop = divStyle.top;
    var originalLeft = divStyle.left;
    var originalZIndex = divStyle.zIndex;
    let bodyStyle = document.body.style;

    if (document.body.runtimeStyle) {
      bodyStyle = document.body.runtimeStyle;
    }

    var originalOverflow = bodyStyle.overflow;
    var myCustomButton = new H.ui.base.PushButton(
      {
        label: '<i class="fa fa-arrows-alt" aria-hidden="true"></i>',
        onStateChange: function(evt) {

          if (myCustomButton.getState() === H.ui.base.Button.State.DOWN) {
              // go full screen
              mapDiv.style.position = "fixed";
              mapDiv.style.top = "0";
              mapDiv.style.left = "0";
              mapDiv.style.right = "0";
              mapDiv.style.bottom = "0";
              mapDiv.style.zIndex = "1050";
              document.body.style.overflow = "hidden";
          } else {
            // exit full screen
            if (originalPos === "") {
              mapDiv.style.position = "relative";
            } else {
              mapDiv.style.position = originalPos;
            }

            mapDiv.style.width = originalWidth;
            mapDiv.style.height = originalHeight;
            mapDiv.style.top = originalTop;
            mapDiv.style.left = originalLeft;
            mapDiv.style.zIndex = originalZIndex;
            document.body.style.overflow = originalOverflow;
          }

          hereMap.ui.getMap().getViewPort().resize();
        }
      });

    myCustomPanel.addChild(myCustomButton);
    myCustomPanel.setState(H.ui.base.OverlayPanel.State.OPEN);
}

/**
 * Display polygone on the map
 * @param array dataLine: [52, 13, 100, 48, 2, 100, 48, 16, 100, 48, 16, 100, 52, 13, 100]
 * @param string backgroundColor
 * @param string borderColor
 * @param integer lineWidth
 */
function addPolygonToMap(hereMap, dataLine, backgroundColor, borderColor, lineWidth = 2) {

    var lineString = new H.geo.LineString(dataLine);

    hereMap.map.addObject(
        new H.map.Polygon(lineString, {
          style: {
            fillColor: backgroundColor,
            strokeColor: borderColor,
            lineWidth: lineWidth
          }
        })
    );
}

/**
 * Display circle on the map
 * @param object centralPoint: { lat: 33.590070, lng: -7.653931 }
 * @param integer radius: value in meters
 * @param string backgroundColor
 * @param string borderColor
 * @param integer lineWidth
 */
function addCircleToMap(hereMap, centralPoint, radius, backgroundColor, borderColor, lineWidth = 2){
    hereMap.map.addObject(new H.map.Circle(
        centralPoint,
        radius,
        {
            style: {
                strokeColor: borderColor,
                lineWidth: lineWidth,
                fillColor: backgroundColor
            }
        }
    ));
}

/**
 * Adds a  draggable marker to the map.
 * @param {object} location : { lat: 48.8589507, lng: 2.2770198 }
 */
function addDraggableMarker(hereMap, markerIcon = null, location = { lat: 48.8589507, lng: 2.2770198 }){

    var marker = new H.map.Marker(location, { volatility: true, icon: markerIcon });
    marker.draggable = true;
    hereMap.map.addObject(marker);

    hereMap.map.addEventListener('dragstart', function(ev) {
      var target = ev.target,
          pointer = ev.currentPointer;
      if (target instanceof H.map.Marker) {
        var targetPosition = hereMap.map.geoToScreen(target.getGeometry());
        target['offset'] = new H.math.Point(pointer.viewportX - targetPosition.x, pointer.viewportY - targetPosition.y);
        hereMap.behavior.disable();
      }
    }, false);

    hereMap.map.addEventListener('dragend', function(ev) {
      var target = ev.target;
      if (target instanceof H.map.Marker) {
        hereMap.behavior.enable();

        // update fields
        document.querySelector("#latitude").value = marker.getGeometry().lat;
        document.querySelector("#longitude").value = marker.getGeometry().lng;

        $.post(
          "/ajax/geocoding-silverex",
          { latitude: marker.getGeometry().lat, longitude: marker.getGeometry().lng },
          function(data) {
            if( data != null ) {
              document.querySelector("#adresse").value = data.display_name;
            }
        }, "json");

      }
    }, false);

    hereMap.map.addEventListener('drag', function(ev) {
      var target = ev.target,
          pointer = ev.currentPointer;
      if (target instanceof H.map.Marker) {
        target.setGeometry(hereMap.map.screenToGeo(pointer.viewportX - target['offset'].x, pointer.viewportY - target['offset'].y));
      }
    }, false);

}

/**
 * alters the view bounds of the map to ensure that all markers are visible
 * @param {object} map
 * @param {array} markers
 */
function addMarkersAndSetViewBounds(hereMap, markers) {

  var group = new H.map.Group();

  var markersList = [];

  markers.forEach(function(m) {
      markersList.push(new H.map.Marker(m));
  });

  group.addObjects(markersList);
  //map.addObject(group);

  // get geo bounding box for the group and set it to the map
  hereMap.map.getViewModel().setLookAtData({
    bounds: group.getBoundingBox()
  });
}


/**
 * Reset the map
 */
function resetHereMap(hereMap) {
  hereMap.map.removeObjects(hereMap.map.getObjects());
}
