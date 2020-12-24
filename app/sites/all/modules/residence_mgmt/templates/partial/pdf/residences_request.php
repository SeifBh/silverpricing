<?php
$a='https://ehpad.home/ged/1/document/47981?gen=1';
$f=__DIR__.'/history.json';
$f2=__DIR__.'/historyResult.json';
if(isset($_GET['gen'])){
    if($history){
        $j=json_encode($history);$_a=file_put_contents($f,$j);
        $j=json_encode($historyResult);$_a=file_put_contents($f2,$j);
        $a=1;
    }
}
#https://ehpad.home/sites/all/modules/residence_mgmt/templates/partial/pdf/residences_request.php
if(strpos($_SERVER['REQUEST_URI'],'partial/pdf/residences_request.php') and is_file($f)){
    if(!function_exists('theme')){function theme($x){return 1;}function file_create_url($x){return 1;}function file_load($x){return 1;}}
    $c=file_get_contents($f);$history=json_decode($c);
    $c=file_get_contents($f2);$historyResult=json_decode($c);
    $history->field_map=(array)$history->field_map;
    $history->field_map['und'][0]=(array)$history->field_map['und'][0];
    $a=1;#
    #$history=$j->history;"
    #$historyResult=$j->historyResult;
}
$a=1;
?>
<!DOCTYPE HTML>
<html id="h">
    <head>
        <link rel='preconnect' href='https://fonts.gstatic.com'><link href='https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap' rel='stylesheet'>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<style type="text/css">
table{border-collapse:collapse;}
table td,table th{text-align:left;verticali-align:top;}
.nowrap{white-space:nowrap;}
.results tr:nth-child(even){background:#e1edfe;}
#h{font-size:10px;}
#b{font-size:1.2rem;}
#h #b #content tr.black,.black{background:#6BA5FA;color:#000;}

img{max-height:30vh}
body {font-family: "IBM Plex Sans","sans-serif","Times New Roman", Georgia, Serif;}
#header {margin-bottom: 25px;}

table{margin:auto;}
#content table.table {font-size: 1rem;text-align: center;border-collapse: collapse;}
th,td{padding:5px 0 5px 10px;}

#content table.table td, #content table.table th {vertical-align:middle;line-height:1rem;border: 1px solid #000;/*not considerated*/}
</style>
    </head>
    <body id="b">
      <table id="header">
            <tr><td>
            <div><p><b>Adresse : </b><?php echo $historyResult->request->adresse; ?></p></div>
            <div><p><b>Latitude : </b><?php echo $historyResult->request->latitude; ?></p></div>
            <div><p><b>Longitude : </b><?php echo $historyResult->request->longitude; ?></p></div>
            <div><p><b>Statut : </b><?php echo $historyResult->request->statut; ?></p></div>
            <div><p><b>Périmetre : </b><?php echo $historyResult->request->perimetre; ?></p></div>
                    </td><td>
                        <?php
                        if(isset($history->field_map['und'][0]['value'])){
                            echo"<img src='".$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$history->field_map["und"][0]["value"]."'>";
                        }
                        ?>
                    </td></tr><table>

        <div id="content">
            <table id="t" class="table table-sm table-hover results">
                <thead>
                <tr class="black">
                    <th scope="col">Résidence</th>
                    <th scope="col">Code postal</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Département</th>
                    <th scope="col">Distance</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tarif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rows = 0;
                    foreach( $historyResult->response as $k=>$residence ): ?>
                    <tr>
                        <td><?php
                            if (isset($residence->field_logo_fid)) {echo theme('image', array('path' => file_create_url(file_load($residence->field_logo_fid)->uri), 'width' => 16)).' ';}
                            echo ($k + 1) . ' # ' . $residence->title; ?></td>
                        <td><?php echo $residence->field_location_postal_code; ?></td>
                        <td><?php echo $residence->field_location_locality; ?></td>
                        <td><?php echo $residence->name; ?></td>
                        <td><?php echo round($residence->distance, 2); ?> KM</td>
                        <td><?php echo $residence->field_statut_value; ?></td>
                        <td class="nowrap"> &nbsp; <?php echo $residence->field_tarif_chambre_simple_value; ?> €</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
