<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/jquery/jquery.min.js"></script>
<!-- vendor css -->
<link href="<?php echo RESIDENCE_MGMT_URI; ?>/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="<?php echo RESIDENCE_MGMT_URI; ?>/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
<link href="<?php echo RESIDENCE_MGMT_URI; ?>/lib/jqvmap/jqvmap.min.css" rel="stylesheet">
<link href="<?php echo RESIDENCE_MGMT_URI; ?>/lib/typicons.font/typicons.css" rel="stylesheet">
<link href="<?php echo RESIDENCE_MGMT_URI; ?>/lib/prismjs/themes/prism-vs.css" rel="stylesheet">
<link href="<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="<?php echo RESIDENCE_MGMT_URI; ?>/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="<?php echo RESIDENCE_MGMT_URI; ?>/lib/select2/css/select2.min.css" rel="stylesheet">
<link href="<?php echo RESIDENCE_MGMT_URI; ?>/lib/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet">
<link href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" rel="stylesheet" />

<!-- DashForge CSS -->
<link rel="stylesheet" href="<?php echo RESIDENCE_MGMT_URI; ?>/assets/css/dashforge.css">
<link rel="stylesheet" href="<?php echo RESIDENCE_MGMT_URI; ?>/assets/css/dashforge.dashboard.css">
<link rel="stylesheet" href="<?php echo RESIDENCE_MGMT_URI; ?>/assets/css/dashforge.profile.css">
<link rel="stylesheet" href="<?php echo RESIDENCE_MGMT_URI; ?>/assets/css/skin.light.css">

<!-- LEAFLET MAP -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>

<!-- SILVERPRICING CSS -->
<link rel="stylesheet" href="<?php echo RESIDENCE_MGMT_URI; ?>/assets/css/main.css" />


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
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/lib/chart.js/Chart.bundle.min.js"></script>
<?#<script src="/js/chartjs-plugin-datalabels.js"></script>?>
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
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/js/services.js"></script>
<script src="<?php echo RESIDENCE_MGMT_URI; ?>/assets/js/main.js"></script>
<script>
    var icon = {
        public : new H.map.Icon(BASE_ICON_PATH + 'public_marker.png'),
        associatif: new H.map.Icon(BASE_ICON_PATH + 'associatif_marker.png'),
        prive: new H.map.Icon(BASE_ICON_PATH + 'prive_marker.png'),
        search: new H.map.Icon(BASE_ICON_PATH + 'search_marker.png'),
        hospital: new H.map.Icon(BASE_ICON_PATH + 'hospital_marker.png')
    };
</script>
