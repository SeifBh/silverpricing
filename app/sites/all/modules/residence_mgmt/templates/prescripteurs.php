<?php
#48.8603152/2.4070025/300/Ecoles Formant aux Professions Sanitaires
$hist=[];$rows = 0;#
$a='prescripteurs';#as résidences,,,,
if($GLOBALS['user']->uid){
    $uid=intval($GLOBALS["user"]->uid);
    $x=Alptech\Wip\fun::sql("select nid,b.body_value from node n inner join field_data_body b on n.nid=b.entity_id and n.title='prescripteur' where type='history' and uid=".$uid." order by nid desc");
    foreach($x as $t){
        $params=json_decode($t['body_value'],1)['request'];
        unset($params['latitude'],$params['longitude']);
        $imp=trim(preg_replace('~[^a-z0-9\-_]~is','',strtolower(implode('-_-',$params))));
        $hist[$imp][]=$t['nid'];
    }
}
/*
#
*/?>
<section class="section-residences prescripteurs">
    <div class="row">
        <div class="col-md-4">
            <div class="card mg-t-10 mg-b-10">
                <div class="card-header d-sm-flex align-items-start justify-content-between">
                    <h5 class="tx-8rem tx-uppercase tx-bold lh-5 mg-b-0">Recherche prescripteurs</h5>
                </div>
                <div class="card-body pd-y-15 pd-x-10">
                    <form method="POST" id="search-form" onsubmit="return historyCheck(this);">

                        <div class="form-group col-md-12">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse"  value="<?php echo (!empty($_POST['adresse'])) ? $_POST['adresse'] : '' ?>"/>
                            </div>
                        </div>

                        <div class="form-group col-md-12 d-none">
                            <input type="text" class="form-control form-control-sm" id="latitude" name="latitude" placeholder="Latitude"  value="<?php echo (!empty($_POST['latitude'])) ? $_POST['latitude'] : '' ?>"/>
                        </div>

                        <div class="form-group col-md-12 d-none">
                            <input type="text" class="form-control form-control-sm" id="longitude" name="longitude" placeholder="Longitude"  value="<?php echo (!empty($_POST['longitude'])) ? $_POST['longitude'] : '' ?>"/>
                        </div>

                        <div class="form-group col-md-12">
                            <input type="number" class="form-control form-control-sm" id="perimetre" name="perimetre" placeholder="Périmetre" min="1" value="<?php echo (!empty($_POST['perimetre'])) ? $_POST['perimetre'] : 5 ?>"/>
                        </div>

                        <div class="form-group col-md-12">
                            <select id="categories" name="categories[]" multiple class="form-control form-control-sm">
                                <?php foreach($categories as $category):
#établissement prescripteur => display as maisonnettes
#puis afficher les prescripteurs attachés à un établissement
                                    ?>
                                    <option value="<?php echo $category->code_categorie; ?>" <?php echo ( in_array($category->code_categorie, $_POST['categories']) ) ? "selected":""; ?>><?php echo $category->lib_categorie; ?></option>
                                <?php endforeach; ?>
                            <select>
                        </div>
                        
                        <div class="form-group col-md-12">
<label style='width:100%'><input <?php echo(isset($_POST['prescripteurs']) and $_POST['prescripteurs'])?'checked':''?> type="checkbox" class="" name="prescripteurs" value=1 /> + Prescripteurs ( individus )</label>
                        </div>
<div class="form-group col-md-12">
<?php
if($errmsg)echo $errmsg;
elseif($healthOrganizations);#has results do not remettre le md5 de confirmation de requête là dedans ( éviter requête en double )
elseif($confirmMd5){echo"Cette requête va consommer $nbr crédits .. <input type=hidden name=confirm value='$confirmMd5'>";}
?>
</div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> <?=($nbr)?'Confirmer':'Rechercher';?></button>
                        </div>
                        </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mg-t-10 mg-b-10">
                <div class="card-body pd-y-15 pd-x-10">
                    <div id="map-recherche-silverex" class="heremap"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mg-t-10 mg-b-10">
        <div class="card-body pd-y-15 pd-x-10">
<?if(0 and 'nostats'){?>
            <div class="row">
                  <?php foreach( $requete_statistiques as $title => $statistique ){ ?>
                      <div class="col-md-3">
                          <div class="info-box">
                              <span class="info-box-icon"><i class="fa fa-database"></i></span>
                              <div class="info-box-content">
                                  <span class="info-box-text"><?php echo $title ?></span>
                                  <span class="info-box-number"><?php echo $statistique ?><?php echo (in_array($title, array( "Tarif moyen", "Tarif médian", "Tarif plus bas", "Tarif plus haut" ))) ? "€": ""; ?></span>
                              </div>
                          </div>
                      </div>
                  <?php }?>
            </div>
<?}

if($healthOrganizations){?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body">
                <table id="residences-result-table" class="table table-sm table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Etablissement</th>
                        <th scope="col">Code postal</th>
                        <th scope="col">Ville</th>
                        <th scope="col">Département</th>
                        <th scope="col">Distance</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col">Email</th>
                        <?/*<th scope="col">Finess</th>    <td><?=$t->finess?></td>
                        <th scope="col">Groupe</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tarif</th>*/?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $f2e=[];
                            foreach( $healthOrganizations as $k=>$t ){#_juridique
                                $f2e[$t->finess]=$t->raison_sociale;
                                ?>
                            <tr>
                                <td><?=$t->raison_sociale?></td>
                                <td><?=$t->code_postal?></td>
                                <td><?=$t->libelle_routage?></td>
                                <td><?=substr($t->code_postal,0,2)?></td>
                                <td><?=round($t->distance,2)?></td>
                                <td><?=$t->tel?></td>
                                <td><?=$t->eml?></td>
                            </tr>
                            <?php }
                         ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?}?>
</div></div>
<?if($persons){?>
<div class="card mg-t-10 mg-b-10">
    <div class="card-body pd-y-15 pd-x-10">
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body">
                <table id="persons" class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Etablissement</th>
                        <th scope="col">Service</th>
                        <th scope="col">Fonction</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Adresse</th>
                        <th scope="col">Code Postal</th>
                        <th scope="col">Ville</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Commentaire</th>
                        <?/*
                        <th scope="col">Groupe</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tarif</th>*/?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($persons as $finess=>$personsArray ){
                                foreach($personsArray as $t){?>
                            <tr>
                                <td><?
                                    if(!isset($f2e[$finess])){
                                        $a=1;
                                    }else{
                                        echo $f2e[$finess];
                                    }
                                    ?></td>
                                <td><?=$t['service']?></td>
                                <td><?=$t['fonction']?></td>
                                <td><?=$t['nom']?></td>
                                <td><?=$t['prenom']?></td>
                                <td><?=$t['adresse']?></td>
                                <td><?=$t['codepostal']?></td>
                                <td><?=$t['ville']?></td>
                                <td><?=$t['telephone']?></td>
                                <td><?=$t['email']?></td>
                                <td><?=$t['commentaire']?></td>
                            </tr>
                            <?php } }
                         ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div></div>
<?} ?>
</section>

<script>var historique=<?=json_encode($hist)?>,nbr=<?=count($healthOrganizations)?>;
function historyCheck(el){
    if(Object.keys(historique).length==0)return true;
    var st=$('#status option:selected').text();if(st=='')st='aucun';
    var sign=$('#adresse').val()+'-_-'+st+'-_-'+$('#perimetre').val();
    sign=sign.toLowerCase().replace(/[^a-z0-9_\-]/gi,'')
    //cl(sign,historique[sign]);
    if(typeof(historique[sign]) != 'undefined'){
        //cl(sign,historique[sign]);
        nb=historique[sign].length;
        x=confirm('Une recherche correspondante existe déjà ('+nb+'), êtes vous certain de vouloir poursuivre ?');
        return x;
    }
    return true;
    /*dqs('#latitude');dqs('#longitude');*/
}



$(document).ready(function(){
    $('#categories').select2({placeholder: 'Categories',});
    $("#search-form button").click(function( event ) {
        event.preventDefault();
        var adresse = document.querySelector("#adresse").value;
        if( adresse != null && adresse.length > 0 ) {   getGeoCodingSilverex( adresse );    } else {$("#search-form").submit();}
    });

if(nbr){
cl('ready',nbr);
currentMap=hereMap=initHereMap("XbtFBu4z4GHw4B_nIv1A-6d9OixFidUGKc_41OIxoN8", document.getElementById('map-recherche-silverex'));

currentMap.map.getEngine().addEventListener('render',function(e){if (currentMap.map.getEngine() === e.target) {rendered=1;cl('rendered',renderingSteps);}renderingSteps++;});//It renders 2 time, then 2 more for copy

    if($('#residences-result-table').length){
        $('#residences-result-table').DataTable( {"language": {url: frenchDataTables},"paging":true,"pagelength":25,"searching": true, "order": [[ 5, "asc" ]]
           , columnDefs: [{"searchable": false, "targets": [3,4,5]} /*,{ type: 'natural-nohtml', targets: 5 }, { type: 'natural-nohtml', targets: 7 }*/]
        });
    }
    if($('#persons').length){
        $('#persons').DataTable( {"language":{url: frenchDataTables},"paging":true,"pagelength":25,"searching": true/*, "order": [[ 5, "asc" ]]*/
            , columnDefs: [/*{"searchable": false, "targets": [1,4,5,6]} /*,{ type: 'natural-nohtml', targets: 5 }, { type: 'natural-nohtml', targets: 7 }*/]
        });
    }

    resetHereMap(hereMap);
    if( document.querySelector("#latitude").value != "" && document.querySelector("#longitude").value != "" ) {
        var location = {lat: document.querySelector("#latitude").value, lng: document.querySelector("#longitude").value};
        addDraggableMarker(hereMap, icon.search, location);
        updateCenter(hereMap, location);
    } else {
        addDraggableMarker(hereMap, icon.search);
    }
    <?php
#above les marqueurs png calculés des svgs
if($healthOrganizations){#2100 Marqueurs .. c'est beaucoup !!
    foreach( $healthOrganizations as $healthOrganization ){ ?>
marker={lat:<?php echo $healthOrganization->latitude;?>,lng:<?php echo $healthOrganization->longitude;?>};
markers.push(marker);
addInfoBubble(hereMap, new H.map.Marker(marker, { icon: icon.hospital }), "<?php #recherche#Attention:le truc merde à la ligne 4676
echo "<b>" . htmlspecialchars($healthOrganization->raison_sociale) . "</b><br /> ";
echo "FINESS : " . $healthOrganization->finess . "<br /> ";
echo "Catégorie : " . $healthOrganization->lib_categorie . "<br /> ";
echo "Statut : " . $healthOrganization->lib_statut . "<br /> ";
echo "Tarif : " . $healthOrganization->lib_tarif . "<br /> ";
?>");
    <?php
    }
}#endForeach WTO?>

//updateCenter(hereMap, markers[0]);
addFullScreenUIControl(hereMap);addMarkersAndSetViewBounds(hereMap, markers);

    if(typeof post['latitude']!='undefined' && typeof post['confirm']!='undefined'){
        defer(captureMap,function(){x=(toload.length==0 && typeof window['hereMap']=='object' && typeof  window['jQuery']=='function');cl('capmap',x);return x;});
    }
}//end nbr
});//end docready

</script>
<?return;?>
