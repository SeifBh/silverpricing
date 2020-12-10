<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/jquery/jquery.min.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/jqvmap/maps/jquery.vmap.france.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/feather-icons/feather.min.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/prismjs/prism.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/js/sorting_natural.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/select2/js/select2.min.js"></script>

<script src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/js/dashforge.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/js/dashforge.aside.js"></script>

<!-- SilverPricing JS SCRIPTS -->
<!-- CHART JS -->
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/chart.js/Chart.bundle.min.js"></script>
<!-- HERE MAP DEPENDENCIES -->
<script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-clustering.js" type="text/javascript"></script>

<!-- HERE MAP LIBRARY -->
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/js/here_library.js"></script>
<!-- LEAFLET MAP -->
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
<!-- SLIDER RANGE -->
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/ion-rangeslider/js/ion.rangeSlider.min.js"></script>

<!-- GAUGE CHART  -->
<?php if( $currentMenu == "residences" ): ?>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/js/raphael-2.1.4.min.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/js/justgage.js"></script>
<?php endif; ?>

<!-- SERVICES JS -->
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/js/services.js"></script>
<!-- MAIN JS -->
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/js/main.js"></script>


<script type="text/javascript">

    // Create an icon:
    var BASE_ICON_PATH = "<?php echo RESIDENCE_MGMT_URI; ?>/assets/img/";
    var icon = {
        public : new H.map.Icon(BASE_ICON_PATH + 'public_marker.png'),
        associatif: new H.map.Icon(BASE_ICON_PATH + 'associatif_marker.png'),
        prive: new H.map.Icon(BASE_ICON_PATH + 'prive_marker.png'),
        search: new H.map.Icon(BASE_ICON_PATH + 'search_marker.png'),
        hospital: new H.map.Icon(BASE_ICON_PATH + 'hospital_marker.png')
    };

    <?php if( $currentMenu == "dashboard" ): ?>

        // DATA TABLES
        $('#dashboard-quick-win-table').DataTable( {
            "language": {
                url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
            },
            "searching": false,
            "lengthChange": false,
            "paging": false,
            "info": false,
            "pageLength": 5,
            "columnDefs": [
                { type: 'natural-nohtml', targets: [1,2,3] }
            ]
        });

        $('#dashboard-mes-maquettes-table').DataTable( {
            "language": {
                url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
            },
            "searching": false,
            "lengthChange": false,
            "paging": false,
            "info": false,
            "pageLength": 5,
            "columnDefs": [
                { type: 'natural-nohtml', targets: [3, 4, 5] }
            ]
        });

        $('#mes-residences-table').DataTable( {
            "language": {
                url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
            },
            "searching": false,
            "columnDefs": [
                { type: 'natural-nohtml', targets: [4,5] }
            ]
        });

        // REQUEST FORM
        $('#departements-field').select2({
            placeholder: 'Choisissez-en un',
        });

        $('#recherche-residence').on('change', function(e) {
            var residenceName  = $('#recherche-residence').val();

            console.log(residenceName);
        });

        // MAP

        var markers = [];

        var hereMap = initHereMap("XbtFBu4z4GHw4B_nIv1A-6d9OixFidUGKc_41OIxoN8", document.getElementById('dashboard-map-result'));

        // Create a marker using the previously instantiated icon and add marker to the map:

        <?php $a='home dashboard';
        foreach( $dataMarkers as $dataMarker ): ?>
            var marker = { lat: <?php echo $dataMarker->field_latitude_value; ?>, lng: <?php echo $dataMarker->field_longitude_value; ?> };
            markers.push(marker);

            var markerObject = null;

            <?php

                switch($dataMarker->field_statut_value) {
                case "Public":
                    echo "markerObject = new H.map.Marker(marker, { icon: icon.public });";
                    break;
                case "Associatif":
                    echo "markerObject = new H.map.Marker(marker, { icon: icon.associatif });";
                    break;
                case "Privé":
                    echo "markerObject = new H.map.Marker(marker, { icon: icon.prive });";
                    break;
                }

            ?>

            <?php
                $groupeLogo = "";
                if( isset($dataMarker->field_logo_fid) ) {
                    $groupeLogo = "<img src='" . file_create_url(file_load($dataMarker->field_logo_fid)->uri) . "' width='24' alt='' />";
                }
            ?>

            addInfoBubble(hereMap, markerObject,
            "<?php
                echo $groupeLogo . " <br />";
                echo "<a href='/residence/$dataMarker->nid'>" . htmlspecialchars($dataMarker->title) . "</a><br /> ";
                echo "$dataMarker->field_location_postal_code, $dataMarker->field_location_locality <br /> ";
                echo "<strong>$dataMarker->field_tarif_chambre_simple_value €</strong>";
            ?>"
            );

            //map.addObject(markerObject);

        <?php endforeach; ?>

        updateCenter(hereMap, markers[0]);

        addFullScreenUIControl(hereMap);

        addMarkersAndSetViewBounds(hereMap, markers);


    <?php elseif( $currentMenu == "quick_win" ): ?>

        // DATA TABLES
        $('#quick-win-table').DataTable( {
            "language": {
                url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
            },
            "searching": true,
            "lengthChange": false,
            "pageLength": 50,
            "columnDefs": [
                { type: 'natural-nohtml', targets: [1,2,3,4] }
            ]
        });

    <?php elseif(  $currentMenu == "profile-view" ): ?>

        // DATA TABLES
        $('#profile-residences-table').DataTable( {
            "language": {
                url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
            },
            "searching": true,
            "lengthChange": false,
            "pageLength": 10,
            "columnDefs": [
                { type: 'natural-nohtml', targets: [3,4] }
            ]
        });

    <?php elseif( $currentMenu == "mes_maquettes" ): ?>

        // DATA TABLES
        $('#mes-maquettes-table').DataTable( {
            "language": {
                url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
            },
            "searching": true,
            "lengthChange": false,
            "pageLength": 10,
            "columnDefs": [
                { type: 'natural-nohtml', targets: [3, 4, 5] }
            ]
        });

    <?php elseif( $currentMenu == "ma_maquette" ): 

    elseif( $currentMenu == "departements" ): ?>

    // BAR CHART / FRENCH DEPARTMENTS
    var barChartCanvas = new Chart(document.getElementById('bar_chart_canvas').getContext('2d'), {
        type: 'bar',
        data: {
            datasets: [
                {
                    yAxisID: 'departements',
                    label: 'Départements',
                    backgroundColor: '#6dbaf5',
                    data: [
                        <?php foreach( $departements as $departement ):
                            echo "\"$departement->count\","; 
                        endforeach; ?>
                    ],
                },
                {
                    type: 'line',
                    yAxisID: 'departement-tarif',
                    label: 'Tarif Moyen',
                    backgroundColor: '#65e0e0',
                    borderColor: '#65e0e0',
                    fill: false,
                    data: [
                        <?php foreach( $departements as $departement ):
                            echo "\"$departement->tarif_moyen\","; 
                        endforeach; ?>
                    ]
                },
            ],
            labels: [
                <?php foreach( $departements as $departement ):
                    echo "\"$departement->name\","; 
                endforeach; ?>
            ]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false,
            },
            scales: {
                yAxes: [
                    {
                        id: 'departements',
                        position: 'left',
                        ticks: {
                            beginAtZero:true,
                            fontSize: 10,
                            fontColor: '#182b49',
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Nombre de résidences',
                            fontSize: 10
                        }
                    },
                    {
                        id: 'departement-tarif',
                        position: 'right',
                        ticks: {
                            beginAtZero:true,
                            fontSize: 10,
                            fontColor: '#182b49',
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Tarif moyen',
                            fontSize: 10
                        }
                    },
                ],
                xAxes: [{
                    barPercentage: 0.6,
                    ticks: {
                        beginAtZero:true,
                        fontSize: 10,
                        fontColor: '#182b49',
                        maxRotation: 90,
                        minRotation: 90
                    }
                }]
            }
        }
    });

    // DATA TABLE:

    $(document).ready(function() {
    $('#department-table').DataTable( {
        "language": {
            url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
        },
        "searching": true,
        columnDefs: [
                { type: 'natural-nohtml', targets: [1, 2, 3, 4] }
        ]
    });
    });

    // FRENCH SVG MAP

    var colors = ["#a5d7fd", "#66a4fd", "#4d95fb", "#0168fa", "#325a98"];
    //var colors = ["rgb(239, 240, 22)","rgb(70, 194, 38)","rgb(20, 114, 10)","rgb(32, 215, 242)","rgb(23, 32, 216)", "rgb(133, 100, 4)"];

    var departments = [];

    <?php foreach( $departements as $departement ):?>
    departments.push({ tid: <?php echo $departement->tid ?>, number: "<?php echo $departement->number; ?>", name: "<?php echo $departement->name; ?>", count: <?php echo $departement->count; ?> });
    <?php endforeach; ?>

    var frenchMap = document.querySelector('#french_vmap');
    var departmentInfo = document.querySelector(".department-info");

    jQuery('#french_vmap').vectorMap({
        map: 'france_fr',
        enableZoom: true,
        showTooltip: true,
        backgroundColor: "#fff",
        onLoad : function(event, map) {

            departmentInfo.classList.add('d-none');

            for (var key in map.countries) {
                if (map.countries.hasOwnProperty(key)) {

                    var currentDepartment = departments.filter( (department) => {
                        return key.replace('fr-', '').toUpperCase() == department.number;
                    });

                    if( currentDepartment.length > 0 ) {
                        if( currentDepartment[0].count <= 25 ) {
                        map.countries[key].setFill(colors[0]);
                        map.countries[key].setAttribute("original", colors[0]);
                        } else if( currentDepartment[0].count <= 50 ) {
                        map.countries[key].setFill(colors[1]);
                        map.countries[key].setAttribute("original", colors[1]);
                        } else if( currentDepartment[0].count <= 100 ) {
                        map.countries[key].setFill(colors[2]);
                        map.countries[key].setAttribute("original", colors[2]);
                        } else if( currentDepartment[0].count <= 150 ) {
                        map.countries[key].setFill(colors[3]);
                        map.countries[key].setAttribute("original", colors[3]);
                        } else {
                        map.countries[key].setFill(colors[4]);
                        map.countries[key].setAttribute("original", colors[4]);
                        }
                    }
                }
            }

        },
        onRegionClick: function(event, code, region) {
            // var currentDepartment = departments.filter( (department) => {
            //   return code.replace('fr-', '') == department.number.toLowerCase();
            // });

            // window.location.href = window.location.protocol + "//" + window.location.host + "/departement/" + currentDepartment[0].tid;

        },
        onRegionSelect: function(event, code, region) {
            var currentDepartment = departments.filter( (department) => {
            return code.replace('fr-', '') == department.number.toLowerCase();
            });

            if( currentDepartment.length > 0 ) {

                getDepartmentDetail( currentDepartment[0] );

            }

        },
        onRegionDeselect: function(event, code, region) {
            departmentInfo.classList.add('d-none');

            departmentInfo.querySelector('.departement-name').textContent = "";
            departmentInfo.querySelector('.dep-nbre-maisons').textContent = 0;
            departmentInfo.querySelector('.dep-tarif-min').textContent = 0;
            departmentInfo.querySelector('.dep-tarif-moyen').textContent = 0;
            departmentInfo.querySelector('.dep-tarif-max').textContent = 0;
        }
    });

    document.querySelectorAll('.map-wrapper .legend .label').forEach( (e, i) => {
        e.querySelector('span').style.backgroundColor = colors[i];
    });

    <?php elseif( $currentMenu == "residences" ): ?>

    $(document).ready(function() {
        $('#request-table').DataTable( {
            "language": {
                url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
            },
            "searching": false,
            columnDefs: [
                { type: 'natural-nohtml', targets: [4, 5, 6] }
            ]
        });
    });


    var barChartCanvas = new Chart(document.getElementById('bar_chart_canvas').getContext('2d'), {
        type: 'bar',
        data: {
            datasets: [
                {
                    yAxisID: 'nombre-residences',
                    label: 'Nombre de résidences',
                    backgroundColor: '#6dbaf5',
                    data: [
                        <?php foreach( $departementChartData as $data ): 
                            echo $data->count; ?>,
                        <?php endforeach;?>
                    ],
                },
                {
                    type: 'line',
                    yAxisID: 'departement-tarif',
                    label: 'Tarif Moyen',
                    backgroundColor: '#65e0e0',
                    borderColor: '#65e0e0',
                    fill: false,
                    data: [
                        <?php foreach( $departementChartData as $data ): 
                            echo round($data->totaltarif / $data->count, 2); ?>,
                        <?php endforeach;?>
                    ]
                },
                {
                    type: "line",
                    yAxisID: 'departement-tarif',
                    label: 'TARIF PLUS HAUT',
                    backgroundColor: '#008000',
                    borderColor: '#008000',
                    fill: false,
                    borderDash: [10,5],
                    pointRadius: 0,
                    borderWidth: 1,
                    data: [
                        <?php foreach( $departementChartData as $departement ):
                            echo $statistique_globale['Tarif plus haut'] . ","; 
                        endforeach; ?>
                    ],
                },
                {
                    type: "line",
                    yAxisID: 'departement-tarif',
                    label: 'TARIF MOYEN',
                    backgroundColor: '#808080',
                    borderColor: '#808080',
                    fill: false,
                    borderDash: [10,5],
                    pointRadius: 0,
                    borderWidth: 1,
                    data: [
                        <?php foreach( $departementChartData as $departement ):
                            echo $statistique_globale['Tarif moyen'] . ","; 
                        endforeach; ?>
                    ],
                },
                {
                    type: "line",
                    yAxisID: 'departement-tarif',
                    label: 'TARIF PLUS BAS',
                    backgroundColor: '#f60303',
                    borderColor: '#f60303',
                    fill: false,
                    borderDash: [10,5],
                    pointRadius: 0,
                    borderWidth: 1,
                    data: [
                        <?php foreach( $departementChartData as $departement ):
                            echo $statistique_globale['Tarif plus bas'] . ","; 
                        endforeach; ?>
                    ],
                },
            ],
            labels: [
                <?php foreach( $departementChartData as $data ): ?>
                    "<?php echo $data->ville; ?>",
                <?php endforeach;?>
            ]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true,
                position: 'bottom',
                align: 'center',
            },
            scales: {
                yAxes: [
                    {
                        id: 'nombre-residences',
                        position: 'left',
                        ticks: {
                            beginAtZero:true,
                            fontSize: 10,
                            fontColor: '#182b49',
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Nombre de résidences',
                            fontSize: 10
                        }
                    },
                    {
                        id: 'departement-tarif',
                        position: 'right',
                        ticks: {
                            beginAtZero:true,
                            fontSize: 10,
                            fontColor: '#182b49',
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Tarif moyen',
                            fontSize: 10
                        }
                    }
                ],
                xAxes: [{
                    barPercentage: 0.6,
                    ticks: {
                        beginAtZero:true,
                        fontSize: 10,
                        fontColor: '#182b49',
                        maxRotation: 90,
                        minRotation: 90
                    }
                }]
            }
        }
    });

    // MAP
    var markers = [],hereMap = initHereMap("XbtFBu4z4GHw4B_nIv1A-6d9OixFidUGKc_41OIxoN8", document.getElementById('french-residences-map'));

    // Create a marker using the previously instantiated icon and add marker to the map:
    <?php foreach( $dataMarkers as $k=>$dataMarker ): ?>
        var markerObject = null,marker = { lat: <?php echo $dataMarker->field_latitude_value; ?>, lng: <?php echo $dataMarker->field_longitude_value; ?> };
        markers.push(marker);
        <?php
$groupeLogo = "";
if( isset($dataMarker->field_logo_fid) ) {
    $groupeLogo = "<img src='" . file_create_url(file_load($dataMarker->field_logo_fid)->uri) . "' width='24' alt='' />";
}
switch($dataMarker->field_statut_value) {
    case "Public":$color='836983';
        echo "markerObject = new H.map.Marker(marker, { icon: icon.public });";
        break;
    case "Associatif":$color='EB9B6C';
        echo "markerObject = new H.map.Marker(marker, { icon: icon.associatif });";
        break;
    case "Privé":$color='584AB9';
        echo "markerObject = new H.map.Marker(marker, { icon: icon.prive });";
        break;
    default:$color='FFF';
        break;
}
$fs=14;
if($k>10);
if($k>100)$fs=12;#plus large
?>
var fs=<?=$fs?>,color='<?=$color?>',svg=document.createElement('div');svg.innerHTML='<svg xmlns="http://www.w3.org/2000/svg"  style="margin:-36px 0 0 -14px" width="28px" height="36px"><path d="M 19 31 C 19 32.7 16.3 34 13 34 C 9.7 34 7 32.7 7 31 C 7 29.3 9.7 28 13 28 C 16.3 28 19 29.3 19 31 Z" fill="#000" fill-opacity=".2"/><path d="M 13 0 C 9.5 0 6.3 1.3 3.8 3.8 C 1.4 7.8 0 9.4 0 12.8 C 0 16.3 1.4 19.5 3.8 21.9 L 13 31 L 22.2 21.9 C 24.6 19.5 25.9 16.3 25.9 12.8 C 25.9 9.4 24.6 6.1 22.1 3.8 C 19.7 1.3 16.5 0 13 0 Z" fill="#fff"/><path d="M 13 2.2 C 6 2.2 2.3 7.2 2.1 12.8 C 2.1 16.1 3.1 18.4 5.2 20.5 L 13 28.2 L 20.8 20.5 C 22.9 18.4 23.8 16.2 23.8 12.8 C 23.6 7.07 20 2.2 13 2.2 Z" fill="#'+color+'"/><text x="10" y="19" font-size="'+fs+'pt" font-weight="bold" text-anchor="middle" fill="#fff"><?=$k?></text></svg>';
markerObject=new H.map.DomMarker(marker,{icon:new H.map.DomIcon(svg)});//addInfoBubble(hereMap,markerObject,"hoho");

        addInfoBubble(hereMap, markerObject,
        "<?php
            echo $groupeLogo . " <br />";
            echo "<a href='/residence/$dataMarker->nid'>" . htmlspecialchars($dataMarker->title) . "</a><br /> ";
            echo "$dataMarker->field_location_postal_code, $dataMarker->field_location_locality <br /> ";
            echo "<strong>$dataMarker->field_tarif_chambre_simple_value €</strong>";
        ?>"
        );
//map.addObject(markerObject);
    <?php endforeach; ?>
    updateCenter(hereMap, markers[0]);
    addFullScreenUIControl(hereMap);
    addMarkersAndSetViewBounds(hereMap, markers);
    $("#collapse_global_info").on('show.bs.collapse', function(){
        setTimeout(function() {
        var resizeEvent = new Event('resize');
        window.dispatchEvent(resizeEvent);
        addMarkersAndSetViewBounds(hereMap, markers);
        }, 1000);
    });

    <?php if( residence_mgmt_user_plan_has_access('PAGE_DEPARTEMENT_SECTION_RECHERCHE') ):  ?>

    // REQUEST FORM

    $('#statut').select2({
        placeholder: 'Statut',
        maximumSelectionLength: 3
    });

    // REQUEST MAP

    var requestHereMap = initHereMap(
        "XbtFBu4z4GHw4B_nIv1A-6d9OixFidUGKc_41OIxoN8",
        document.getElementById('french-residences-map-result')
    );

    var requestMarkers = [];

    <?php
    foreach( $residences as $r ): ?>
        var m = { lat: <?php echo $r->field_latitude_value; ?>, lng: <?php echo $r->field_longitude_value; ?> };
        requestMarkers.push(m);

        var markerObject = null;

        <?php

            switch($r->field_statut_value) {
            case "Public":
                echo "markerObject = new H.map.Marker(m, { icon: icon.public });";
                break;
            case "Associatif":
                echo "markerObject = new H.map.Marker(m, { icon: icon.associatif });";
                break;
            case "Privé":
                echo "markerObject = new H.map.Marker(m, { icon: icon.prive });";
                break;
            }

        ?>

        addInfoBubble(requestHereMap, markerObject,
        "<?php
            echo "<a href='/residence/$r->nid'>" . htmlspecialchars($r->title) . "</a><br /> ";
            echo "$r->field_location_postal_code, $r->field_location_locality <br /> ";
            echo "<strong>$r->field_tarif_chambre_simple_value €</strong>";
        ?>"
        );

    <?php endforeach; ?>

    updateCenter(requestHereMap, requestMarkers[0]);

    addFullScreenUIControl(requestHereMap);

    addMarkersAndSetViewBounds(requestHereMap, requestMarkers);

    <?php endif ?>

    // GAUGE CHART
    // Pression Concurrentielle
    var pressionConcurrentielle = new JustGage({
    id: "pression_concurrentielle",
    value: <?php echo round( 100 - (($mesLits / $capaciteDepartement->nombre_lits) * 100) , 2); ?>,
    min: 0,
    max: 100,
    levelColors: ['#a7d500', '#e4cb00', '#f90d00'],
    hideValue: true,
    hideMinMax: true,
    relativeGaugeSize: true
    });

    var pressionConcurrentielle2 = new JustGage({
    id: "pression_concurrentielle_2",
    value: <?php echo round( 100 - (($statistique_globale['Nbre de maisons'] / $totalPopulation) * 100) , 2); ?>,
    min: 0,
    max: 100,
    levelColors: ['#a7d500', '#e4cb00', '#f90d00'],
    hideValue: true,
    hideMinMax: true,
    relativeGaugeSize: true
    });

    // Pression lits par +75 ans
    var pressionLits = new JustGage({
    id: "pression_lits",
    value: <?php echo round( 100 - (( $capaciteDepartement->nombre_lits / $totalPopulation ) * 100) , 2 ); ?>,
    min: 0,
    max: 100,
    levelColors: ['#a7d500', '#e4cb00', '#f90d00'],
    hideValue: true,
    hideMinMax: true,
    relativeGaugeSize: true
    });


    <?php elseif( $currentMenu == "residence" ): ?>

    var evolutionChart = null;

    getEvolutionMenusuelleDesTarifs( <?php echo $residence->nid; ?> )

    // DATATABLES

    $(document).ready(function() {

        $('#table-residences-direct').DataTable( {
            "language": {
                url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
            },
            "info": false,
            "searching": false,
            "bPaginate": false,
            columnDefs: [
                { type: 'natural-nohtml', targets: [3,4] }
            ]
        });

        $('#table-residences-indirect').DataTable( {
            "language": {
                url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
            },
            "info": false,
            "searching": false,
            "bPaginate": false,
            columnDefs: [
                { type: 'natural-nohtml', targets: [3,4] }
            ]
        });
    });

    // MAP

    var residencesMap = {direct: null, indirect: null,};
    var markers = {direct : [], indirect : [],};
    // HERE MAP
    <?php
$a='https://ehpad.home/residence/45337';
    foreach( $residencesConcurrentes as $concurrence => $dataMarkers ): ?>

        residencesMap.<?php echo $concurrence; ?> = initHereMap(
            "XbtFBu4z4GHw4B_nIv1A-6d9OixFidUGKc_41OIxoN8",
            document.getElementById('residence-concurrente-<?php echo $concurrence; ?>-map')
        );

        <?php foreach( $dataMarkers as $dataMarker ): ?>
            var marker = { lat: <?php echo $dataMarker->field_latitude_value; ?>, lng: <?php echo $dataMarker->field_longitude_value; ?> };
            markers.<?php echo $concurrence; ?>.push(marker);

            var markerObject = null;

            <?php

            switch($dataMarker->field_statut_value) {
                case "Public":
                    echo "markerObject = new H.map.Marker(marker, { icon: icon.public });";
                    break;
                case "Associatif":
                    echo "markerObject = new H.map.Marker(marker, { icon: icon.associatif });";
                    break;
                case "Privé":
                    echo "markerObject = new H.map.Marker(marker, { icon: icon.prive });";
                    break;
            }

            ?>

            addInfoBubble(residencesMap.<?php echo $concurrence; ?>, markerObject,
                "<?php
                echo create_link($dataMarker->title, '/residence/' . $dataMarker->nid, residence_mgmt_user_plan_has_access("PAGE_DETAIL_RESIDENCE_CONCURRENTE")) . "<br/>";
                echo "$dataMarker->field_location_postal_code, $dataMarker->field_location_locality <br /> ";
                echo "<strong>$dataMarker->field_tarif_chambre_simple_value €</strong>";
            ?>");

        <?php endforeach; ?>

        var myMarkerObject = new H.map.Marker({ lat: <?php echo $residence->field_latitude['und'][0]['value']; ?>, lng: <?php echo $residence->field_longitude['und'][0]['value']; ?> }, { icon: new H.map.Icon(BASE_ICON_PATH + 'search_marker.png') });

        addInfoBubble(residencesMap.<?php echo $concurrence; ?>, myMarkerObject,
                "<?php
                echo create_link($residence->title, '/residence/' . $residence->nid, true);
            ?>");

        updateCenter(residencesMap.<?php echo $concurrence; ?>, markers.<?php echo $concurrence; ?>[0]);
        addFullScreenUIControl(residencesMap.<?php echo $concurrence; ?>);

    <?php endforeach; ?>

    $("#residence-concurrente-indirect, #residence-concurrente-direct").on('show.bs.modal', function(){

        setTimeout(function() {
        var resizeEvent = new Event('resize');
        window.dispatchEvent(resizeEvent);

        addMarkersAndSetViewBounds(residencesMap.direct, markers.direct);
        addMarkersAndSetViewBounds(residencesMap.indirect, markers.indirect);
        }, 1000);

    });

    //  INPUT RANGE

    var SLIDER_VALUE = 0;
    var maquetteCourante = null;
    var maquetteModifiee = null;

    var chambres = {
        simples : {
            entreeDeGamme : <?php echo ($chambre->field_nombre_cs_entre_de_gamme['und'][0]['value']) ? $chambre->field_nombre_cs_entre_de_gamme['und'][0]['value'] : 0; ?>,
            standard : <?php echo($chambre->field_nombre_cs_standard['und'][0]['value']) ? $chambre->field_nombre_cs_standard['und'][0]['value'] : 0; ?>,
            superieur : <?php echo ($chambre->field_nombre_cs_superieur['und'][0]['value']) ? $chambre->field_nombre_cs_superieur['und'][0]['value'] : 0; ?>,
            luxe : <?php echo ($chambre->field_nombre_cs_luxe['und'][0]['value']) ? $chambre->field_nombre_cs_luxe['und'][0]['value'] : 0; ?>,
            alzheimer : <?php echo ($chambre->field_nombre_cs_alzheimer['und'][0]['value']) ? $chambre->field_nombre_cs_alzheimer['und'][0]['value'] : 0; ?>,
            aideSociale : <?php echo ($chambre->field_nombre_cs_aide_sociale['und'][0]['value']) ? $chambre->field_nombre_cs_aide_sociale['und'][0]['value'] : 0; ?>,
        },
        doubles : {
            standard : <?php echo ($chambre->field_nombre_cd_standard['und'][0]['value']) ? $chambre->field_nombre_cd_standard['und'][0]['value'] : 0; ?>,
            aideSociale : <?php echo ($chambre->field_nombre_cd_aide_sociale['und'][0]['value']) ? $chambre->field_nombre_cd_aide_sociale['und'][0]['value'] : 0; ?>,
        }
    };

    $("#tmh_slider").ionRangeSlider({
        onStart: function (data) {
            SLIDER_VALUE = data.from;
        },
        onChange: function (data) {
            SLIDER_VALUE = data.from;
        }
    });

    function calculer_tarif(value, pourcentage) {
        return ( value != 0 ) ? Math.round((value + ( value * pourcentage )) * 100) / 100 : 0;
    }

    function genererLaMaquette( tarifBasique, chambres ) {

        var maquette =  {
            date : null,
            user : null,
            tmh : 0,
            chambresSimples: {
                entreeDeGamme : { nombreDeLits: 0,  tarif: 0},
                standard : { nombreDeLits: 0,  tarif: 0},
                superieur : { nombreDeLits: 0,  tarif: 0},
                luxe : { nombreDeLits: 0,  tarif: 0},
                alzheimer : { nombreDeLits: 0,  tarif: 0},
                aideSociale : { nombreDeLits: 0,  tarif: 0}
            },
            chambresDoubles: {
                standard : { nombreDeLits: 0,  tarif: 0},
                aideSociale : { nombreDeLits: 0,  tarif: 0}
            }
        };

        maquette.chambresSimples.entreeDeGamme.nombreDeLits = chambres.simples.entreeDeGamme;
        maquette.chambresSimples.entreeDeGamme.tarif = calculer_tarif(tarifBasique, 0);

        maquette.chambresSimples.standard.nombreDeLits = chambres.simples.standard;
        maquette.chambresSimples.standard.tarif = calculer_tarif(tarifBasique, 0.05);

        maquette.chambresSimples.superieur.nombreDeLits = chambres.simples.superieur;
        maquette.chambresSimples.superieur.tarif = calculer_tarif(tarifBasique, 0.11);

        maquette.chambresSimples.luxe.nombreDeLits = chambres.simples.luxe;
        maquette.chambresSimples.luxe.tarif = calculer_tarif(tarifBasique, 0.20);

        maquette.chambresSimples.alzheimer.nombreDeLits = chambres.simples.alzheimer;
        maquette.chambresSimples.alzheimer.tarif = calculer_tarif(tarifBasique, 0.11);

        maquette.chambresSimples.aideSociale.nombreDeLits = chambres.simples.aideSociale;
        maquette.chambresSimples.aideSociale.tarif = <?php echo ($chambre->field_tarif_cs_aide_sociale['und'][0]['value']) ? $chambre->field_tarif_cs_aide_sociale['und'][0]['value'] : 0; ?>;

        maquette.chambresDoubles.standard.nombreDeLits = chambres.doubles.standard;
        maquette.chambresDoubles.standard.tarif = calculer_tarif(tarifBasique, -0.09);

        maquette.chambresDoubles.aideSociale.nombreDeLits = chambres.doubles.aideSociale;
        maquette.chambresDoubles.aideSociale.tarif = <?php echo ($chambre->field_tarif_cd_aide_sociale['und'][0]['value']) ? $chambre->field_tarif_cd_aide_sociale['und'][0]['value'] : 0; ?>;

        var sommeTarifs = 0;
        var nombreTotale = 0;

        sommeTarifs += maquette.chambresSimples.entreeDeGamme.nombreDeLits * maquette.chambresSimples.entreeDeGamme.tarif;
        sommeTarifs += maquette.chambresSimples.standard.nombreDeLits * maquette.chambresSimples.standard.tarif;
        sommeTarifs += maquette.chambresSimples.superieur.nombreDeLits * maquette.chambresSimples.superieur.tarif;
        sommeTarifs += maquette.chambresSimples.luxe.nombreDeLits * maquette.chambresSimples.luxe.tarif;
        sommeTarifs += maquette.chambresSimples.alzheimer.nombreDeLits * maquette.chambresSimples.alzheimer.tarif;
        sommeTarifs += maquette.chambresSimples.aideSociale.nombreDeLits * maquette.chambresSimples.aideSociale.tarif;
        sommeTarifs += maquette.chambresDoubles.standard.nombreDeLits * maquette.chambresDoubles.standard.tarif * 2;
        sommeTarifs += maquette.chambresDoubles.aideSociale.nombreDeLits * maquette.chambresDoubles.aideSociale.tarif * 2;

        nombreTotale += maquette.chambresSimples.entreeDeGamme.nombreDeLits;
        nombreTotale += maquette.chambresSimples.standard.nombreDeLits;
        nombreTotale += maquette.chambresSimples.superieur.nombreDeLits;
        nombreTotale += maquette.chambresSimples.luxe.nombreDeLits;
        nombreTotale += maquette.chambresSimples.alzheimer.nombreDeLits;
        nombreTotale += maquette.chambresSimples.aideSociale.nombreDeLits;
        nombreTotale += maquette.chambresDoubles.standard.nombreDeLits * 2;
        nombreTotale += maquette.chambresDoubles.aideSociale.nombreDeLits * 2;

        var today = new Date();
        maquette.user = "<?php echo $user->name ?>";
        maquette.date = today.getDate() + "/" + (today.getMonth() + 1) + "/" + today.getFullYear();
        maquette.tmh = ( sommeTarifs >= 0 && nombreTotale > 0 ) ? Math.round( (sommeTarifs / nombreTotale) * 100) / 100 : 0;

        return maquette;

    }

    function updateMaquetteDOM( maquette, $maquetteRoot ) {

        additionOperation = "";
        subtractOperation = "";
        maquetteOperation = "";

        if( $maquetteRoot.hasClass('maquette-modifiee') ) {
            additionOperation = '<a href="#" class="d-block operation-maquette add-item-maquette pd-0 mg-0" style="height: 8px"><img src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/img/caret-arrow-up.svg" width="10" height="10"/></a>';
            subtractOperation = '<a href="#" class="d-block operation-maquette subtract-item-maquette pd-0 mg-0" ><img src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/img/caret-arrow-down.svg" width="10" height="10"/></a>';
            maquetteOperation = "<div class=\"btn-group-vertical pd-l-4\">" + additionOperation + subtractOperation + "</div>";
        }

        $maquetteRoot.find('.chambres-simples.chambres-entree-de-gamme .tarif-de-chambre').html( maquette.chambresSimples.entreeDeGamme.tarif + " € " + maquetteOperation );
        $maquetteRoot.find('.chambres-simples.chambres-entree-de-gamme .nombre-de-lits').html(maquette.chambresSimples.entreeDeGamme.nombreDeLits + maquetteOperation );
        $maquetteRoot.find('.chambres-simples.chambres-standard .tarif-de-chambre').html(maquette.chambresSimples.standard.tarif + " € " + maquetteOperation );
        $maquetteRoot.find('.chambres-simples.chambres-standard .nombre-de-lits').html(maquette.chambresSimples.standard.nombreDeLits + maquetteOperation );
        $maquetteRoot.find('.chambres-simples.chambres-superieur .tarif-de-chambre').html(maquette.chambresSimples.superieur.tarif + " € " + maquetteOperation );
        $maquetteRoot.find('.chambres-simples.chambres-superieur .nombre-de-lits').html(maquette.chambresSimples.superieur.nombreDeLits + maquetteOperation );
        $maquetteRoot.find('.chambres-simples.chambres-luxe .tarif-de-chambre').html(maquette.chambresSimples.luxe.tarif + " € " + maquetteOperation );
        $maquetteRoot.find('.chambres-simples.chambres-luxe .nombre-de-lits').html(maquette.chambresSimples.luxe.nombreDeLits + maquetteOperation );
        $maquetteRoot.find('.chambres-simples.chambres-alzheimer .tarif-de-chambre').html(maquette.chambresSimples.alzheimer.tarif + " € " + maquetteOperation );
        $maquetteRoot.find('.chambres-simples.chambres-alzheimer .nombre-de-lits').html(maquette.chambresSimples.alzheimer.nombreDeLits + maquetteOperation );
        $maquetteRoot.find('.chambres-simples.chambres-aide-sociale .tarif-de-chambre').html(maquette.chambresSimples.aideSociale.tarif + " € " + maquetteOperation );
        $maquetteRoot.find('.chambres-simples.chambres-aide-sociale .nombre-de-lits').html(maquette.chambresSimples.aideSociale.nombreDeLits + maquetteOperation );
        $maquetteRoot.find('.chambres-doubles.chambres-standard .tarif-de-chambre').html(maquette.chambresDoubles.standard.tarif + " € " + maquetteOperation );
        $maquetteRoot.find('.chambres-doubles.chambres-standard .nombre-de-lits').html(maquette.chambresDoubles.standard.nombreDeLits + maquetteOperation );
        $maquetteRoot.find('.chambres-doubles.chambres-aide-sociale .tarif-de-chambre').html(maquette.chambresDoubles.aideSociale.tarif + " € " + maquetteOperation );
        $maquetteRoot.find('.chambres-doubles.chambres-aide-sociale .nombre-de-lits').html(maquette.chambresDoubles.aideSociale.nombreDeLits + maquetteOperation );

        $maquetteRoot.find('.tmh-wrapper .tmh-circle .tmh-circle-body').html( maquette.tmh  + " €");

        if( $maquetteRoot.hasClass('maquette-modifiee') ) {
            document.querySelectorAll('.operation-maquette').forEach(function(item, index) {

                item.addEventListener('click', function(event) {
                    event.preventDefault();
                    if( item.classList.contains('add-item-maquette') ) {
                        console.log("ADD OPERATION");
                        if( item.parentElement.parentElement.parentElement.classList.contains('chambres-simples') ) {
                            console.log("Chambres Simples");
                            if( item.parentElement.parentElement.parentElement.classList.contains('chambres-entree-de-gamme') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresSimples.entreeDeGamme.nombreDeLits += 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresSimples.entreeDeGamme.tarif = parseFloat((maquette.chambresSimples.entreeDeGamme.tarif + 0.1).toFixed(2));
                                    console.log(maquette.chambresSimples.entreeDeGamme.tarif);
                                }
                            } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-standard') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresSimples.standard.nombreDeLits += 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresSimples.standard.tarif = parseFloat((maquette.chambresSimples.standard.tarif + 0.1).toFixed(2));
                                }
                            } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-superieur') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresSimples.superieur.nombreDeLits += 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresSimples.superieur.tarif = parseFloat((maquette.chambresSimples.superieur.tarif + 0.1).toFixed(2));
                                }
                            } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-luxe') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresSimples.luxe.nombreDeLits += 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresSimples.luxe.tarif = parseFloat((maquette.chambresSimples.luxe.tarif + 0.1).toFixed(2));
                                }
                            } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-alzheimer') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresSimples.alzheimer.nombreDeLits += 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresSimples.alzheimer.tarif = parseFloat((maquette.chambresSimples.alzheimer.tarif + 0.1).toFixed(2));
                                }
                            } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-aide-sociale') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresSimples.aideSociale.nombreDeLits += 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresSimples.aideSociale.tarif = parseFloat((maquette.chambresSimples.aideSociale.tarif + 0.1).toFixed(2));
                                }
                            }
                        } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-doubles') ) {
                            console.log("Chambres Doubles");
                            if( item.parentElement.parentElement.parentElement.classList.contains('chambres-standard') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresDoubles.standard.nombreDeLits += 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresDoubles.standard.tarif = parseFloat((maquette.chambresDoubles.standard.tarif + 0.1).toFixed(2));
                                }
                            } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-aide-sociale') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresDoubles.aideSociale.nombreDeLits += 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresDoubles.aideSociale.tarif = parseFloat((maquette.chambresDoubles.aideSociale.tarif + 0.1).toFixed(2));
                                }
                            }
                        }

                    } else if( item.classList.contains('subtract-item-maquette') ) {
                        console.log("SUBTRACT OPERATION");
                        if( item.parentElement.parentElement.parentElement.classList.contains('chambres-simples') ) {
                            console.log("Chambres Simples");
                            if( item.parentElement.parentElement.parentElement.classList.contains('chambres-entree-de-gamme') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresSimples.entreeDeGamme.nombreDeLits -= 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresSimples.entreeDeGamme.tarif = parseFloat((maquette.chambresSimples.entreeDeGamme.tarif - 0.1).toFixed(2));
                                }
                            } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-standard') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresSimples.standard.nombreDeLits -= 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresSimples.standard.tarif = parseFloat((maquette.chambresSimples.standard.tarif - 0.1).toFixed(2));
                                }
                            } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-superieur') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresSimples.superieur.nombreDeLits -= 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresSimples.superieur.tarif = parseFloat((maquette.chambresSimples.superieur.tarif - 0.1).toFixed(2));
                                }
                            } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-luxe') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresSimples.luxe.nombreDeLits -= 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresSimples.luxe.tarif = parseFloat((maquette.chambresSimples.luxe.tarif - 0.1).toFixed(2));
                                }
                            } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-alzheimer') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresSimples.alzheimer.nombreDeLits -= 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresSimples.alzheimer.tarif = parseFloat((maquette.chambresSimples.alzheimer.tarif - 0.1).toFixed(2));
                                }
                            } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-aide-sociale') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresSimples.aideSociale.nombreDeLits -= 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresSimples.aideSociale.tarif = parseFloat((maquette.chambresSimples.aideSociale.tarif - 0.1).toFixed(2));
                                }
                            }
                        } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-doubles') ) {
                            console.log("Chambres Doubles");
                            if( item.parentElement.parentElement.parentElement.classList.contains('chambres-standard') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresDoubles.standard.nombreDeLits -= 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresDoubles.standard.tarif = parseFloat((maquette.chambresDoubles.standard.tarif - 0.1).toFixed(2));
                                }
                            } else if( item.parentElement.parentElement.parentElement.classList.contains('chambres-aide-sociale') ) {
                                if( item.parentElement.parentElement.classList.contains('nombre-de-lits') ) {
                                    maquette.chambresDoubles.aideSociale.nombreDeLits -= 1;
                                } else if( item.parentElement.parentElement.classList.contains('tarif-de-chambre') ) {
                                    maquette.chambresDoubles.aideSociale.tarif = parseFloat((maquette.chambresDoubles.aideSociale.tarif - 0.1).toFixed(2));
                                }
                            }
                        }
                    }

                    updateMaquetteDOM(maquetteModifiee, $('.maquette-modifiee'));
                });

            });
        }

    }

    $('#calculer_maquette').on("click", function(event) {
        var $maquetteRoot = $('.maquette-courante');
        maquetteCourante = genererLaMaquette(SLIDER_VALUE, chambres);
        updateMaquetteDOM(maquetteCourante, $maquetteRoot);

        $maquetteRoot.removeClass('d-none');
    });

    $('#modifier_maquette').on('click', function(event) {
        var $maquetteRoot = $('.maquette-modifiee');
        maquetteModifiee = JSON.parse(JSON.stringify(maquetteCourante));;
        updateMaquetteDOM(maquetteModifiee, $maquetteRoot);

        $maquetteRoot.removeClass('d-none');

        $maquetteRoot.find('.tmh-wrapper .tmh-circle .tmh-circle-footer .maquette_diff').text( maquetteCourante.tmh - maquetteModifiee.tmh );

    });

    $('#calculer_maquette_modifiee').on("click", function(event) {
        var $maquetteRoot = $('.maquette-modifiee');

        var sommeTarifs = 0;
        var nombreTotale = 0;

        sommeTarifs += maquetteModifiee.chambresSimples.entreeDeGamme.nombreDeLits * maquetteModifiee.chambresSimples.entreeDeGamme.tarif;
        sommeTarifs += maquetteModifiee.chambresSimples.standard.nombreDeLits * maquetteModifiee.chambresSimples.standard.tarif;
        sommeTarifs += maquetteModifiee.chambresSimples.superieur.nombreDeLits * maquetteModifiee.chambresSimples.superieur.tarif;
        sommeTarifs += maquetteModifiee.chambresSimples.luxe.nombreDeLits * maquetteModifiee.chambresSimples.luxe.tarif;
        sommeTarifs += maquetteModifiee.chambresSimples.alzheimer.nombreDeLits * maquetteModifiee.chambresSimples.alzheimer.tarif;
        sommeTarifs += maquetteModifiee.chambresSimples.aideSociale.nombreDeLits * maquetteModifiee.chambresSimples.aideSociale.tarif;
        sommeTarifs += maquetteModifiee.chambresDoubles.standard.nombreDeLits * maquetteModifiee.chambresDoubles.standard.tarif * 2;
        sommeTarifs += maquetteModifiee.chambresDoubles.aideSociale.nombreDeLits * maquetteModifiee.chambresDoubles.aideSociale.tarif * 2;

        nombreTotale += maquetteModifiee.chambresSimples.entreeDeGamme.nombreDeLits;
        nombreTotale += maquetteModifiee.chambresSimples.standard.nombreDeLits;
        nombreTotale += maquetteModifiee.chambresSimples.superieur.nombreDeLits;
        nombreTotale += maquetteModifiee.chambresSimples.luxe.nombreDeLits;
        nombreTotale += maquetteModifiee.chambresSimples.alzheimer.nombreDeLits;
        nombreTotale += maquetteModifiee.chambresSimples.aideSociale.nombreDeLits;
        nombreTotale += maquetteModifiee.chambresDoubles.standard.nombreDeLits * 2;
        nombreTotale += maquetteModifiee.chambresDoubles.aideSociale.nombreDeLits * 2;

        maquetteModifiee.tmh = ( sommeTarifs >= 0 && nombreTotale > 0 ) ? Math.round( (sommeTarifs / nombreTotale) * 100) / 100 : 0;

        $maquetteRoot.find('.nombre-de-chambre span').text(nombreTotale - maquetteModifiee.chambresDoubles.standard.nombreDeLits - maquetteModifiee.chambresDoubles.aideSociale.nombreDeLits );

        updateMaquetteDOM(maquetteModifiee, $maquetteRoot);
    });

    $('#enregistrer_maquette').on('click', function(event) {
        addTMHMaquette( <?php echo $residence->nid; ?>, maquetteModifiee );
    });

    function toggleFavoris(favoris) {

        var dataFavoris = favoris.getAttribute('data-favoris');
        var dataNid = favoris.getAttribute('data-nid');

        if( dataFavoris == "1" ) {
            dataFavoris = 0;
            favoris.setAttribute("data-favoris", dataFavoris);
            favoris.innerHTML = '<i class="far fa-star"></i>';
        } else {
            dataFavoris = 1;
            favoris.setAttribute("data-favoris", dataFavoris);
            favoris.innerHTML = '<i class="fas fa-star"></i>';
        }

        addMaquetteToFavoris( dataNid, <?php echo $residence->nid; ?>);

        $('#historiques_maquettes .modal-body .alert').remove();
        $('#historiques_maquettes .modal-body').prepend(
            '<div class="alert alert-solid alert-primary alert-dismissible fade show" role="alert">' +
                '<strong>Succès!</strong> ajouter cet maquette à mes favoris.' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">×</span>' +
                '</button>' +
            '</div>'
        );

    }

    $("#btn-historiques-maquettes").on('click', function(event) {
        reloadHistoriquesMaquettes(<?php echo $residence->nid; ?>);
    });



    $(".maquette-modifiee table .edit-chambres-doubles, .maquette-modifiee table .edit-chambres-simples").on('click', function(event) {

        $('#update-maquette-residence').modal("show");

        var formRoot = $("#update-maquette-residence");

        formRoot.find('.chambres-simples-fieldsets .chambres-entree-de-gamme .nombre-chambres').val(maquetteModifiee.chambresSimples.entreeDeGamme.nombreDeLits);
        formRoot.find('.chambres-simples-fieldsets .chambres-entree-de-gamme .tarif-chambres').val(maquetteModifiee.chambresSimples.entreeDeGamme.tarif);

        formRoot.find('.chambres-simples-fieldsets .chambres-standard .nombre-chambres').val(maquetteModifiee.chambresSimples.standard.nombreDeLits);
        formRoot.find('.chambres-simples-fieldsets .chambres-standard .tarif-chambres').val(maquetteModifiee.chambresSimples.standard.tarif);

        formRoot.find('.chambres-simples-fieldsets .chambres-superieur .nombre-chambres').val(maquetteModifiee.chambresSimples.superieur.nombreDeLits);
        formRoot.find('.chambres-simples-fieldsets .chambres-superieur .tarif-chambres').val(maquetteModifiee.chambresSimples.superieur.tarif);

        formRoot.find('.chambres-simples-fieldsets .chambres-luxe .nombre-chambres').val(maquetteModifiee.chambresSimples.luxe.nombreDeLits);
        formRoot.find('.chambres-simples-fieldsets .chambres-luxe .tarif-chambres').val(maquetteModifiee.chambresSimples.luxe.tarif);

        formRoot.find('.chambres-simples-fieldsets .chambres-alzheimer .nombre-chambres').val(maquetteModifiee.chambresSimples.alzheimer.nombreDeLits);
        formRoot.find('.chambres-simples-fieldsets .chambres-alzheimer .tarif-chambres').val(maquetteModifiee.chambresSimples.alzheimer.tarif);

        formRoot.find('.chambres-simples-fieldsets .chambres-aide-sociale .nombre-chambres').val(maquetteModifiee.chambresSimples.aideSociale.nombreDeLits);
        formRoot.find('.chambres-simples-fieldsets .chambres-aide-sociale .tarif-chambres').val(maquetteModifiee.chambresSimples.aideSociale.tarif);

        formRoot.find('.chambres-doubles-fieldsets .chambres-standard .nombre-chambres').val(maquetteModifiee.chambresDoubles.standard.nombreDeLits);
        formRoot.find('.chambres-doubles-fieldsets .chambres-standard .tarif-chambres').val(maquetteModifiee.chambresDoubles.standard.tarif);

        formRoot.find('.chambres-doubles-fieldsets .chambres-aide-sociale .nombre-chambres').val(maquetteModifiee.chambresDoubles.aideSociale.nombreDeLits);
        formRoot.find('.chambres-doubles-fieldsets .chambres-aide-sociale .tarif-chambres').val(maquetteModifiee.chambresDoubles.aideSociale.tarif);

    });

    $('#submit-updated-maquette').click(function(event) {
        event.preventDefault();
        var fields = {
            chambresSimples: [
                "chambres-entree-de-gamme", "chambres-standard", "chambres-superieur",
                "chambres-luxe", "chambres-alzheimer", "chambres-aide-sociale"
            ],
            chambresDoubles: [
                "chambres-standard", "chambres-aide-sociale"
            ]
        };

        var formRoot = $("#update-maquette-residence");

        fields.chambresSimples.forEach(function(field, index) {
            var nombreChambres = parseInt(formRoot.find('.chambres-simples-fieldsets' + ' .' + field + ' .nombre-chambres').val());
            var tarifChambres = parseFloat(formRoot.find('.chambres-simples-fieldsets' + ' .' + field + ' .tarif-chambres').val());

            if( field == fields.chambresSimples[0]) {
                maquetteModifiee.chambresSimples.entreeDeGamme.nombreDeLits = nombreChambres;
                maquetteModifiee.chambresSimples.entreeDeGamme.tarif = tarifChambres;
            } else if( field == fields.chambresSimples[1]) {
                maquetteModifiee.chambresSimples.standard.nombreDeLits = nombreChambres;
                maquetteModifiee.chambresSimples.standard.tarif = tarifChambres;
            } else if( field == fields.chambresSimples[2]) {
                maquetteModifiee.chambresSimples.superieur.nombreDeLits = nombreChambres;
                maquetteModifiee.chambresSimples.superieur.tarif = tarifChambres;
            } else if( field == fields.chambresSimples[3]) {
                maquetteModifiee.chambresSimples.luxe.nombreDeLits = nombreChambres;
                maquetteModifiee.chambresSimples.luxe.tarif = tarifChambres;
            } else if( field == fields.chambresSimples[4]) {
                maquetteModifiee.chambresSimples.alzheimer.nombreDeLits = nombreChambres;
                maquetteModifiee.chambresSimples.alzheimer.tarif = tarifChambres;
            } else if( field == fields.chambresSimples[5]) {
                maquetteModifiee.chambresSimples.aideSociale.nombreDeLits = nombreChambres;
                maquetteModifiee.chambresSimples.aideSociale.tarif = tarifChambres;
            }

        });

        fields.chambresDoubles.forEach(function(field, index) {

            var nombreChambres = parseInt(formRoot.find('.chambres-doubles-fieldsets' + ' .' + field + ' .nombre-chambres').val());
            var tarifChambres = parseFloat(formRoot.find('.chambres-doubles-fieldsets' + ' .' + field + ' .tarif-chambres').val());

            if( field == fields.chambresDoubles[0] ) {
                maquetteModifiee.chambresDoubles.standard.nombreDeLits = nombreChambres;
                maquetteModifiee.chambresDoubles.standard.tarif = tarifChambres;
            } else if( field == fields.chambresDoubles[1] ) {
                maquetteModifiee.chambresDoubles.aideSociale.nombreDeLits = nombreChambres;
                maquetteModifiee.chambresDoubles.aideSociale.tarif = tarifChambres;
            }
        });

        updateMaquetteDOM(maquetteModifiee, $('.maquette-modifiee'));

        $('#update-maquette-residence').modal("hide");

    });

    <?php elseif($currentMenu == "mes-groupes"): ?>
        $(document).ready(function() {
            $('#mes-groupes-table').DataTable( {
                "language": {
                    url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
                },
                "info": false
            });
        });

    <?php elseif($currentMenu == "groupes"): ?>

        // DATATABLES
        $(document).ready(function() {
            $('#groupes-table').DataTable( {
                "language": {
                    url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
                },
                columnDefs: [
                    { type: 'natural-nohtml', targets: [4, 5, 6, 7] }
                ]
            });
        });

    <?php elseif($currentMenu == "groupe"): ?>

        // CHART
        var chartData = <?php echo json_encode($chartData); ?>;


        var historiqueChart = new Chart(document.getElementById('historique-tarifs-chart').getContext('2d'), {
            type: 'line',
            data: {
                datasets: [
                    {
                        label: 'Groupe',
                        backgroundColor: '#1ce1ac',
                        borderColor: '#1ce1ac',
                        fill: false,
                        data: chartData.dataGroupe,
                    },
                    {
                        type: "line",
                        yAxisID: 'groupe-tarif',
                        label: 'TARIF PLUS HAUT',
                        backgroundColor: '#008000',
                        borderColor: '#008000',
                        fill: false,
                        borderDash: [10,5],
                        pointRadius: 0,
                        borderWidth: 1,
                        data: [
                            <?php foreach( $chartData['dataGroupe'] as $gChartData ):
                                echo $statistiques_globales['Tarif plus haut'] . ","; 
                            endforeach; ?>
                        ],
                    },
                    {
                        type: "line",
                        yAxisID: 'groupe-tarif',
                        label: 'TARIF MEDIANE',
                        backgroundColor: '#808080',
                        borderColor: '#808080',
                        fill: false,
                        borderDash: [10,5],
                        pointRadius: 0,
                        borderWidth: 1,
                        data: [
                            <?php foreach( $chartData['dataGroupe'] as $gChartData ):
                                echo $statistiques_globales['Tarif médian'] . ","; 
                            endforeach; ?>
                        ],
                    },
                    {
                        type: "line",
                        yAxisID: 'groupe-tarif',
                        label: 'TARIF PLUS BAS',
                        backgroundColor: '#f60303',
                        borderColor: '#f60303',
                        fill: false,
                        borderDash: [10,5],
                        pointRadius: 0,
                        borderWidth: 1,
                        data: [
                            <?php foreach( $chartData['dataGroupe'] as $gChartData ):
                                echo $statistiques_globales['Tarif plus bas'] . ","; 
                            endforeach; ?>
                        ],
                    },
                ],
                labels: chartData.xAxe
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true,
                    position: 'top',
                    align: 'center'
                },
                scales: {
                    yAxes: [{
                        id: 'groupe-tarif',
                        position: 'left',
                        ticks: {
                            beginAtZero:true,
                            fontSize: 10,
                            fontColor: '#182b49',
                        }
                    }],
                    xAxes: [{
                        barPercentage: 0.6,
                        ticks: {
                            beginAtZero:true,
                            fontSize: 12,
                            fontColor: '#182b49',
                            maxRotation: 90,
                            minRotation: 90
                        }
                    }]
                }
            }
        });

        // DATATABLES
        $(document).ready(function() {
            $('#request-table').DataTable( {
                "language": {
                    url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
                },
                "searching": false,
                "columnDefs": [
                    { type: 'natural-nohtml', targets: 3 }
                ]
            });
        });

        // REQUEST FORM
        $('#departement-field').select2({
            placeholder: 'Choisissez un département',
        });

        // RESIDENCES MAP

        var hereMap = initHereMap(
            "XbtFBu4z4GHw4B_nIv1A-6d9OixFidUGKc_41OIxoN8",
            document.getElementById('residences-map')
        );

        var markers = [];

        <?php foreach( $residences as $r ): ?>
            var m = { lat: <?php echo $r->field_latitude_value; ?>, lng: <?php echo $r->field_longitude_value; ?> };
            markers.push(m);

            var markerObject = null;

            <?php

                switch($r->field_statut_value) {
                case "Public":
                    echo "markerObject = new H.map.Marker(m, { icon: icon.public });";
                    break;
                case "Associatif":
                    echo "markerObject = new H.map.Marker(m, { icon: icon.associatif });";
                    break;
                case "Privé":
                    echo "markerObject = new H.map.Marker(m, { icon: icon.prive });";
                    break;
                }

            ?>

            addInfoBubble(hereMap, markerObject,
            "<?php
                echo "<a href='/residence/$r->nid'>" . htmlspecialchars($r->title) . "</a><br /> ";
                echo "$r->field_location_postal_code, $r->field_location_locality <br /> ";
                echo "<strong>$r->field_tarif_chambre_simple_value €</strong>";
            ?>"
            );

        <?php endforeach; ?>

        updateCenter(hereMap, markers[0]);

        addFullScreenUIControl(hereMap);

        addMarkersAndSetViewBounds(hereMap, markers);

        <?php 
        
        if( residence_mgmt_user_plan_has_access('PAGE_GROUPE_SECTION_RECHERCHE') ):  
        $a=1;?>
        // REQUEST HERE MAP

        var requestHereMap = initHereMap(
            "XbtFBu4z4GHw4B_nIv1A-6d9OixFidUGKc_41OIxoN8",
            document.getElementById('residences-map-result')
        );

        var requestMarkers = [];

        <?php foreach( $residencesFiltered as $r ): ?>
            var m = { lat: <?php echo $r->field_latitude_value; ?>, lng: <?php echo $r->field_longitude_value; ?> };
            requestMarkers.push(m);

            var markerObject = null;

            <?php

                switch($r->field_statut_value) {
                case "Public":
                    echo "markerObject = new H.map.Marker(m, { icon: icon.public });";
                    break;
                case "Associatif":
                    echo "markerObject = new H.map.Marker(m, { icon: icon.associatif });";
                    break;
                case "Privé":
                    echo "markerObject = new H.map.Marker(m, { icon: icon.prive });";
                    break;
                }

            ?>

            addInfoBubble(requestHereMap, markerObject,
            "<?php
                echo "<a href='/residence/$r->nid'>" . htmlspecialchars($r->title) . "</a><br /> ";
                echo "$r->field_location_postal_code, $r->field_location_locality <br /> ";
                echo "<strong>$r->field_tarif_chambre_simple_value €</strong>";
            ?>"
            );

        <?php endforeach; ?>

        updateCenter(requestHereMap, requestMarkers[0]);

        addFullScreenUIControl(requestHereMap);

        addMarkersAndSetViewBounds(requestHereMap, requestMarkers);

        <?php endif; 

    elseif( $currentMenu == "recherche-silverex" ):
    $a='https://ehpad.home/recherche-silverex';?>


    $('#categories').select2({
        placeholder: 'Categories',
    });

    // DATATABLES
    $(document).ready(function() {
        $('#residences-result-table').DataTable( {
            "language": {
                url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
            },
            "searching": false,
            "order": [[ 5, "asc" ]],
            columnDefs: [
                    { type: 'natural-nohtml', targets: 5 },
                    { type: 'natural-nohtml', targets: 7 }
            ]
        });
    });

    // MAP

    currentMap=hereMap= initHereMap("XbtFBu4z4GHw4B_nIv1A-6d9OixFidUGKc_41OIxoN8", document.getElementById('map-recherche-silverex'));

    currentMap.map.getEngine().addEventListener('render',function(e){if (currentMap.map.getEngine() === e.target) {rendered=1;cl('rendered',renderingSteps);}renderingSteps++;});//It renders 2 time, then 2 more for copy

    addFullScreenUIControl(hereMap);

    $(document).ready(function() {
        resetHereMap(hereMap);
        if( document.querySelector("#latitude").value != "" && document.querySelector("#longitude").value != "" ) {
            var location = {
            lat: document.querySelector("#latitude").value,
            lng: document.querySelector("#longitude").value
            };

            addDraggableMarker(hereMap, icon.search, location);
            updateCenter(hereMap, location);
        } else {
            addDraggableMarker(hereMap, icon.search);
        }

        $("#search-form button").click(function( event ) {
            event.preventDefault();
            var adresse = document.querySelector("#adresse").value;
            if( adresse != null && adresse.length > 0 ) {
                getGeoCodingSilverex( adresse );
            } else {
                $("#search-form").submit();
            }
        });

w=32;h=32;
toload=[];markers = [];
needSvgToCanvas();
ajax('/z/ajax.php?markers=1','GET','',function(r){pngMarkers=JSON.parse(r);/*cl(pngMarkers);*/});

<?php
$fs=14;$w=28;$h=36;$r=$h/$w;
if(count($residences)>99){$fs=11;$w=50;}#plus large, dégressif
elseif(count($residences)>10){$fs=13;$w=40;}
$w=40;#anyways-- stupid otherwise
$h=round($w*$r);
$zoom=1.6;#minima

if(count($residences)>200)$zoom=0.3;#plus de résultats, moins de zoom
elseif(count($residences)>100)$zoom=0.5;#plus de résultats, moins de zoom
elseif(count($residences)>50)$zoom=1;

$a='https://ehpad.home/recherche-silverex';#rechercher
foreach( $residences as $k=>$residence ){
    $k2=$k+1;
    $a=1;
    switch($residence->field_statut_value) {
        case "Associatif":$color='EB9B6C';$txtcolor='000';$b='FFF';break;
        case "Public":$color='836983';$txtcolor='FFF';$b='000';break;#gris bof
        case "Privé":$color='584AB9';$txtcolor='FFF';$b='000';break;
        default:$color='FFF';$txtcolor='000';$b='FFF';break;
    }
?>
fs=<?=$fs?>;k=<?=$k2?>;bgColor='<?=$color?>';txtColor='<?=$txtcolor?>';border='<?=$b?>';w=<?=$w?>;h=<?=$h?>;zoom=<?=$zoom?>;
pngFileName=k+'-'+bgColor+'-'+txtColor+'-'+border+'-'+w+'-'+h+'-'+zoom;
var final=pngFileName+'.png';

marker = { lat: <?php echo $residence->field_latitude_value; ?>, lng: <?php echo $residence->field_longitude_value; ?> };
markers.push(marker);

callbacksInc++;//hereMap is a global here :)
callbacks[callbacksInc]=function(final,marker,callbacksInc,w,h) {
    cl({'loadedImg':callbacksInc,marker,final});
    var markerObject = new H.map.Marker(marker, {icon: new H.map.Icon('/z/markers/' + final),width:w,height:h});
    addInfoBubble(hereMap, markerObject, "<?php
        echo " #$k2 <a href='/residence/$residence->nid'>" . htmlspecialchars($residence->title) . "</a><br /> ";
        echo "$residence->field_location_postal_code, $residence->field_location_locality <br /> ";
        echo "<strong>$residence->field_tarif_chambre_simple_value €</strong>";
        ?>");
    return final;
}.bind(this,final,marker,callbacksInc,w,h);

toload.push(final);//[final]=1;

defer(
    function(final,pngFileName, k, bgColor, txtColor, border, w, h, zoom,fs,cbn){//Peuvent être générés après
        if (pngMarkers.indexOf(final) == -1) {//Nécessitant uneGénération
            callbacksInc++;//as global !!!
            callbacks[callbacksInc]=function(final,ajxResponse){
                cl({final,ajxResponse});
                var img = new Image();img.src = '/z/markers/'+final;
                img.onload = imgLoad.bind(this, final, cbn, 0);//au dessus
                img.onerror = imgError.bind(this, final, cbn, 0);
            }.bind(this,final);

            cl('defer',pngFileName, k, bgColor, txtColor, border, w, h, zoom);
            document.querySelector('#svgC').innerHTML = genSvg(k, bgColor, txtColor, border, w, h, zoom,fs);
            svg2png(pngFileName,callbacks[callbacksInc]);
        }else{
            var img = new Image();img.src = '/z/markers/'+final;
            img.onload = imgLoad.bind(this, final, cbn, 0);//1st bind Is "This"
            img.onerror = imgError.bind(this, final, cbn, 0);//aka retry as long as marker not here
        }
    }.bind(0,final,pngFileName, k, bgColor, txtColor, border, w, h, zoom,fs,callbacksInc)

    ,function (){
        x= (typeof svg2png == 'function' && typeof document.body == 'object' && typeof pngMarkers == 'object' && typeof Canvas2Image == 'object' && typeof RGBColor == 'function' && typeof jQuery == 'function' && typeof $ == 'function' && typeof canvg == 'function');
        //cl(final,pngFileName,x);
        return x;
    }
    
);

<?php
}
    foreach( $healthOrganizations as $healthOrganization ){ ?>

        var marker = { lat: <?php echo $healthOrganization->latitude; ?>, lng: <?php echo $healthOrganization->longitude; ?> };
        markers.push(marker);

        var markerObject = new H.map.Marker(marker, { icon: icon.hospital });

        addInfoBubble(hereMap, markerObject,
            "<?php
            echo "<strong>" . htmlspecialchars($healthOrganization->raison_sociale) . "</strong><br /> ";
            echo "FINESS : " . $healthOrganization->finess . "<br /> ";
            echo "Catégorie : " . $healthOrganization->lib_categorie . "<br /> ";
            echo "Statut : " . $healthOrganization->lib_statut . "<br /> ";
            echo "Tarif : " . $healthOrganization->lib_tarif . "<br /> ";
        ?>");
    <?php }#endForeach WTO ?>
    defer(
        function(){cl('ready?');addMarkersAndSetViewBounds(hereMap, markers);}.bind(this,hereMap,markers),
        function(){return (toload.length==0);}
    );
});//end docready

    <?php
    elseif( $currentMenu == "history" ):#
$a='https://ehpad.home/history/46822';
$fs=14;$w=28;$h=36;$r=$h/$w;
$w=40;$h=round($w*$r);$zoom=1.6;##anyways-- stupid otherwise

if(count($historyBody->response)>200)$zoom=0.3;#plus de résultats, moins de zoom
elseif(count($historyBody->response)>100)$zoom=0.5;#plus de résultats, moins de zoom
elseif(count($historyBody->response)>50)$zoom=1;

    ?>
w=32;h=32;toload=[];markers = [];needSvgToCanvas();ajax('/z/ajax.php?markers=1','GET','',function(r){pngMarkers=JSON.parse(r);/*cl(pngMarkers);*/});

        // DATATABLES
        $(document).ready(function() {
            $('#residences-result-table').DataTable( {
                "language": {
                    url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
                },
                "searching": false,
                "order": [[ 4, "asc" ]],
                columnDefs: [
                    { type: 'natural-nohtml', targets: 6 }
                ]
            });
        });

        // MAP

        var hereMap = initHereMap("XbtFBu4z4GHw4B_nIv1A-6d9OixFidUGKc_41OIxoN8", document.getElementById('map-recherche-silverex'));

        addFullScreenUIControl(hereMap);

        $(document).ready(function() {
            resetHereMap(hereMap);
            var location = {lat: <?php echo $historyBody->request->latitude; ?>, lng: <?php echo $historyBody->request->longitude; ?>};
            updateCenter(hereMap, location);
            addMarker(hereMap, location,  icon.search);

            var markers = [];
            <?php foreach( $historyBody->response as $k=>$residence ){
                $k2=$k+1;
                switch($residence->field_statut_value) {
                    case "Associatif":$color='EB9B6C';$txtcolor='000';$b='FFF';break;
                    case "Public":$color='836983';$txtcolor='FFF';$b='000';break;#gris bof
                    case "Privé":$color='584AB9';$txtcolor='FFF';$b='000';break;
                    default:$color='FFF';$txtcolor='000';$b='FFF';break;
                }
                ?>
fs=<?=$fs?>;k=<?=$k2?>;bgColor='<?=$color?>';txtColor='<?=$txtcolor?>';border='<?=$b?>';w=<?=$w?>;h=<?=$h?>;zoom=<?=$zoom?>;
pngFileName=k+'-'+bgColor+'-'+txtColor+'-'+border+'-'+w+'-'+h+'-'+zoom;
var final=pngFileName+'.png';

var marker = { lat: <?php echo $residence->field_latitude_value; ?>, lng: <?php echo $residence->field_longitude_value; ?> };
markers.push(marker);
var markerObject = null;


callbacksInc++;//hereMap is a global here :)
callbacks[callbacksInc]=function(final,marker,callbacksInc,w,h) {
cl({'loadedImg':callbacksInc,marker,final});
var markerObject = new H.map.Marker(marker, {icon: new H.map.Icon('/z/markers/' + final),width:w,height:h});

addInfoBubble(hereMap, markerObject, "<?php
echo " #$k2 <a href='/residence/$residence->nid'>" . htmlspecialchars($residence->title) . "</a><br /> ";
echo "$residence->field_location_postal_code, $residence->field_location_locality <br /> ";
echo "<strong>$residence->field_tarif_chambre_simple_value €</strong>";
?>");
return final;
}.bind(this,final,marker,callbacksInc,w,h);

toload.push(final);//[final]=1;

defer(
function(final,pngFileName, k, bgColor, txtColor, border, w, h, zoom,fs,cbn){//Peuvent être générés après
if (pngMarkers.indexOf(final) == -1) {//Nécessitant uneGénération
    callbacksInc++;//as global !!!
    callbacks[callbacksInc]=function(final,ajxResponse){
        cl({final,ajxResponse});
        var img = new Image();img.src = '/z/markers/'+final;
        img.onload = imgLoad.bind(this, final, cbn, 0);//au dessus
        img.onerror = imgError.bind(this, final, cbn, 0);
    }.bind(this,final);

    cl('defer',pngFileName, k, bgColor, txtColor, border, w, h, zoom);
    document.querySelector('#svgC').innerHTML = genSvg(k, bgColor, txtColor, border, w, h, zoom,fs);
    svg2png(pngFileName,callbacks[callbacksInc]);
}else{
    var img = new Image();img.src = '/z/markers/'+final;
    img.onload = imgLoad.bind(this, final, cbn, 0);//1st bind Is "This"
    img.onerror = imgError.bind(this, final, cbn, 0);//aka retry as long as marker not here
}
}.bind(0,final,pngFileName, k, bgColor, txtColor, border, w, h, zoom,fs,callbacksInc)

,function (){
x= (typeof svg2png == 'function' && typeof document.body == 'object' && typeof pngMarkers == 'object' && typeof Canvas2Image == 'object' && typeof RGBColor == 'function' && typeof jQuery == 'function' && typeof $ == 'function' && typeof canvg == 'function');
//cl(final,pngFileName,x);
return x;
}
);

            <?php } ?>

            addMarkersAndSetViewBounds(hereMap, markers);

        });

    <?php elseif($currentMenu == "mes-residences"): ?>
        $(document).ready(function() {
            $('#mes-residences-table').DataTable( {
                "language": {
                    url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
                },
                "info": false,
                "order": [[ 1, "asc" ]],
                'columnDefs': [
                    { 'targets': [0,6], 'orderable': false },
                    { type: 'natural-nohtml', targets: 5 },
                ]
            });
        });

    <?php elseif($currentMenu == "development-tools"): ?>
        // DATATABLES
        var yeelderToolsTable = $('#yeelder-tools-table').DataTable( {
            "language": {
                url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
            },
            columns: [
                { data: 'id_mutation' },
                { data: 'date_mutation' },
                { data: 'nom_commune' },
                { data: 'code_postal' },
                { data: 'nature_mutation' },
                { data: 'type_local' },
                { data: 'surface_reelle_bati' },
                { data: 'nature_culture' },
                { data: 'surface_terrain' },
                { data: 'valeur_fonciere' },
            ]
        });

        // MAP
        var map = L.map('yeelder-tools-leafletmap').setView([46.369922, 5.27701], 6);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/light-v9'
        }).addTo(map);

        function onEachFeature(feature, layer) {

            var residencesInsideCommune = 0;
            var sommeTarifResidences = 0;

            if( feature.properties.residences != null && feature.properties.residences.length > 0 ) {
                residencesInsideCommune = feature.properties.residences.length;
                for( var i = 0 ; i < residencesInsideCommune ; i++  ) {
                    sommeTarifResidences += parseFloat(feature.properties.residences[i].field_tarif_chambre_simple_value);
                }
            }

            var popupContent = "<p>"
            + "<br />" + "<strong>Code</strong> : " + feature.properties.code
            + "<br />" + "<strong>Commune</strong> : " + feature.properties.nom
            // + "<br />" + "<strong>Surface</strong> : " + feature.properties.surface
            // + "<br />" + "<strong>Population</strong> : " + feature.properties.population
            + "<br />" + "<strong>Residences</strong> : " + residencesInsideCommune
            + "<br />" + "<strong>Tarif Moyen</strong> : " + ((!isNaN(sommeTarifResidences) && residencesInsideCommune > 0) ? (sommeTarifResidences / residencesInsideCommune).toFixed(2) + " €" : 0)
            + "</p>";

            layer.on({
                click: function(e) {
                    console.log(layer.getPopup().getContent());

                    map.fitBounds(layer.getBounds());

                    var popupContentUpdated = "<p>"
                    + "<br />" + "<strong>Code</strong> : " + feature.properties.code
                    + "<br />" + "<strong>Commune</strong> : " + feature.properties.nom
                    // + "<br />" + "<strong>Surface</strong> : " + feature.properties.surface
                    // + "<br />" + "<strong>Population</strong> : " + feature.properties.population
                    + "<br />" + "<strong>Residences</strong> : " + residencesInsideCommune
                    + "<br />" + "<strong>Tarif Moyen</strong> : " + ((!isNaN(sommeTarifResidences) && residencesInsideCommune > 0) ? (sommeTarifResidences / residencesInsideCommune).toFixed(2) + " €" : 0);

                    getDvfOfCommune( feature.properties.code , popupContentUpdated, layer );

                    // getAllPropertyValuesOfCommune( feature.properties.code );

                }
            });

            layer.bindPopup(popupContent);

        }


        $('#city-autocomplete').select2({
            data: []
        });

        $('#city-dvf-autocomplete').select2({
            data: []
        });

        $('.departement-wrapper #department-selected').on('change', function() {

            var departmentSelected = document.querySelector('.departement-wrapper #department-selected').value;

            getListOfCitiesByDepartment( departmentSelected );

        });

        $('.dvf-wrapper #dvf-department-selected').on('change', function() {

            var departmentSelected = document.querySelector('.dvf-wrapper #dvf-department-selected').value;

            getListOfCitiesByDepartmentInDvf( departmentSelected );

        });

        $('.departement-wrapper #department-submit').on('click', function() {
            $(".departement-wrapper #department-submit").attr("disabled", "disabled");
            $(".departement-wrapper #department-submit").html("Envoyer <i class=\"fas fa-spinner fa-spin\"></i>");
            $(".departement-wrapper .alert-devtools, .departement-wrapper .alert-devtools-error").addClass('d-none');
            var departmentSelected = document.querySelector('.departement-wrapper #department-selected').value;
            var citiesSelect = document.querySelectorAll('.departement-wrapper #city-autocomplete option:checked');

            var citiesSelected = [];
            citiesSelect.forEach( (e, i) => citiesSelected.push(e.value) );

            if( departmentSelected == "none" ) {
                $(".departement-wrapper .alert-devtools-error").removeClass('d-none');
                $(".departement-wrapper #department-submit").html("Envoyer");
                $(".departement-wrapper #department-submit").removeAttr("disabled");
                return;
            }

            getGeoJsonOfCitiesByDepartment( departmentSelected, citiesSelected );

        });

        $('#dvf-submit').on('click', function(event) {
            event.preventDefault();

            $("#dvf-form-wrapper #dvf-submit").attr("disabled", "disabled");
            $("#dvf-form-wrapper #dvf-submit").html("Envoyer <i class=\"fas fa-spinner fa-spin\"></i>");
            var yearSelected = $("#dvf-form-wrapper #year-selection").val();
            var citiesSelect = document.querySelectorAll('#dvf-form-wrapper #city-dvf-autocomplete option:checked');

            var citiesSelected = [];
            citiesSelect.forEach( (e, i) => citiesSelected.push(e.value) );

            getDVFByCitiesAndByYear( yearSelected, citiesSelected);

        });

    <?php elseif($currentMenu == "nearby-residences"): ?>
        
        $(document).ready(function() {
            $('#nearby-residences-updated-table').DataTable( {
                "language": {
                    url: "<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net/i18n/French.json"
                },
                "info": false,
                "order": [[ 1, "asc" ]]
            });
        });

    <?php endif; ?>

</script>
