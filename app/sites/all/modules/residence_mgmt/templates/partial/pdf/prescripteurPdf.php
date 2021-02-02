<?php
use Alptech\Wip\fun;
$a='https://ehpad.home/ged/1/document/48157?gen=1';
$b='https://c/zou.json';
$f=__DIR__.'/history.json';
$f2=__DIR__.'/historyResult.json';

if(isset($_GET['gen'])){
    if($history){
        $j=json_encode($history);$_a=file_put_contents($f,$j);
        $j=json_encode($historyResult);$_a=file_put_contents($f2,$j);
        $a=1;
    }
}
#https://ehpad.home/sites/all/modules/residence_mgmt/templates/partial/pdf/prescripteurPdf.php
if(strpos($_SERVER['REQUEST_URI'],'partial/pdf/prescripteurPdf.php') and is_file($f)){
    if(!function_exists('theme')){function theme($x){return 1;}function file_create_url($x){return 1;}function file_load($x){return 1;}}
    $c=file_get_contents($f);$history=json_decode($c);
    $c=file_get_contents($f2);$historyResult=json_decode($c);
    $history->field_map=(array)$history->field_map;
    $history->field_map['und'][0]=(array)$history->field_map['und'][0];
    $a=1;#
    #$history=$j->history;"
    #$historyResult=$j->historyResult;
}
function _distAsc($a, $b) {return $a->distance > $b->distance;}
function _distDesc($a, $b) {return $a->distance < $b->distance;}
$rows = 0;
?><!DOCTYPE HTML><html id="h"><head><link rel='preconnect' href='https://fonts.gstatic.com'><link href='https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap' rel='stylesheet'><meta http-equiv="content-type" content="text/html; charset=UTF-8" />
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
#b .results .people{background:#EEE}
</style>
</head><body id="b">
      <table id="header">
    <tr><td>
        Adresse : <?php echo $historyResult->request->adresse;?>, Périmetre : <?php echo $historyResult->request->perimetre;?>, Latitude : <?php echo $historyResult->request->latitude; ?>,Longitude : <?php echo $historyResult->request->longitude; ?>
        </td><td>
<?php if(isset($history->field_map['und'][0]['value']) and $history->field_map['und'][0]['value']){echo"<img src='".$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$history->field_map["und"][0]["value"]."'>";} ?>
            </td></tr><table>

        <div id="content">
            <table id="t" class="table table-sm table-hover results">
                <thead>
                <tr class="black">
                    <th scope="col">Etablissement</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Code postal</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Distance (Km)</th>
                    </tr>
                </thead>
                <tbody>
<?php
foreach( $historyResult->response as $k=>&$residence ) {
    $residence->distance = round(fun::distance($historyResult->request->latitude, $residence->latitude, $historyResult->request->longitude, $residence->longitude), 2);
}unset($residence);

usort($historyResult->response, '_distAsc');

foreach( $historyResult->response as $k=>$residence ) {
    $finess = $residence->finess;
    ?>
    <tr>
        <td><?php
            /*
            $historyResult->response[0]->latitude
            $historyResult->response[0]->longitude

            #if (isset($residence->field_logo_fid)) {echo theme('image', array('path' => file_create_url(file_load($residence->field_logo_fid)->uri), 'width' => 16)).' ';}
            */
            echo $residence->raison_sociale; ?></td>
        <td><?php echo $residence->adresse; ?></td>
        <td><?php echo $residence->code_postal; ?></td>
        <td><?php echo $residence->libelle_routage; ?></td>
        <td><?php echo $residence->distance; ?></td>
    </tr>
    <?php
    if (isset($historyResult->organismes->$finess)) {
        foreach ($historyResult->organismes->$finess as $t) {#Persons
            $t=(array)$t;
            $data=array_unique([$t['titre'],$t['nom'],$t['prenom'],$t['fonction'],$t['service'],$t['telephone'],$t['email'],$t['ville']]);
            echo"<tr class=people><td colspan=5> &nbsp; &nbsp; &nbsp; ";
            echo implode(' ',$data);
            echo"</td></tr>";
            $a = 1;
        }
    }
}?>
                </tbody>
            </table>
        </div>
    </body>
</html>
<?return;?>
