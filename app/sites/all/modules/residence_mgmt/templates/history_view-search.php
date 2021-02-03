<?#/history ..
#cuj cuj "https://ehpad.home/history/48159" '' '[]' 1 "XDEBUG_SESSION=XDEBUG_ECLIPSE;has_js=1;Drupal_toolbar_collapsed=0;Drupal_tableDrag_showWeight=0;ben=1;siteDisabled=1;SESS02da88e2f02ccdeaa197b0dcdf4d100a=vo5Qm0Pl-qMQh2QuGWceT9wMVJmrPKb2DwCxtDN5hWw;SSESS02da88e2f02ccdeaa197b0dcdf4d100a=7LV_wuDk6qWwDd2YHHjlfNWaIUaqcrkAjJei_BnTi2A"
$rows = 0;
?>
<section class="section-residences history">
    <div class="row">
        <div class="col-md-4">
            <div class="card mg-t-10 mg-b-10">
                <div class="card-header d-sm-flex align-items-start justify-content-between">
                    <h5 class="lh-5 mg-b-0">Requête</h5>
                </div>
                <div class="card-body pd-y-15 pd-x-10">
                    <div>
                        <h6 class="mg-b-5">Adresse : </h6>
                        <p class="tx-13 mg-b-8"><?php echo $historyBody->request->adresse; ?></p>
                    </div>
                    <div>
                        <h6 class="mg-b-5">Latitude : </h6>
                        <p class="tx-13 mg-b-8"><?php echo $historyBody->request->latitude; ?></p>
                    </div>
                    <div>
                        <h6 class="mg-b-5">Longitude : </h6>
                        <p class="tx-13 mg-b-8"><?php echo $historyBody->request->longitude; ?></p>
                    </div>
                    <div>
                        <h6 class="mg-b-5">Statut : </h6>
                        <p class="tx-13 mg-b-8"><?php echo $historyBody->request->statut; ?></p>
                    </div>
                    <div>
                        <h6 class="mg-b-5">Périmetre : </h6>
                        <p class="tx-13 mg-b-8"><?php echo $historyBody->request->perimetre; ?></p>
                    </div>
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
            <?if($requete_statistiques){?>
            <div class="row">
                <?php foreach( $requete_statistiques as $title => $statistique ): ?>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-database"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo $title ?></span>
                            <span class="info-box-number"><?php echo $statistique ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?}?>

<div class="row">
    <div class="col-md-12">
<?if($history->title=='prescripteur'){?>
        <div class="box box-default">
            <div class="box-body">
    <table id="residences-result-table" class="table table-sm table-hover"><thead>
    <tr>
        <?#<th scope="col">Finess</th>?>
        <th scope="col">Etablissement</th>        
        <th scope="col">Code postal</th>
        <th scope="col">Ville</th>
        <th scope="col">Département</th>
        <th scope="col">Distance</th>
        <th scope="col">Téléphone</th>
        <th scope="col">Email</th>
    </tr>
    </thead>
    <tbody>
    <?php
$f2e=[];
    foreach( $historyBody->response as $k=>$t ){
        $f2e[$t->finess]=$t->raison_sociale;
        ?>
        <tr>
            <?/*<td><?=$t->finess?></td>*/?>
            <td><?=$t->raison_sociale?></td>
            <td><?=$t->code_postal?></td>
            <td><?=$t->libelle_routage?></td>
            <td><?=substr($t->code_postal,0,2)?></td>
            <td><?=round($t->distance,2)?></td>
            <td><?=$t->tel?></td>
            <td><?=$t->eml?></td>
        </tr>
    <?php } ?>
    </tbody></table>
</div></div>
<?php if($historyBody->organismes){ ?>
<hr><div class="box box-default">
    <div class="box-body">
    <table id="persons"><thead><tr>
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
        </tr>
        </thead>
        <tbody>
        <?php
        foreach( $historyBody->organismes as $finess=>$persons ){
            foreach($persons as $t){$t=(array)$t;#$t-> stdclass here?>
            <tr>
                <td><?=$f2e[$finess]?></td>
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
        <?php }} ?>
        </tbody></table></div></div>
<?}#persons
}else{?>
<div class="box box-default">
    <div class="box-body">
    <table id="residences-result-table" class="table table-sm table-hover"><thead>
    <tr>
        <th scope="col">Résidence</th>
        <th scope="col">Code postal</th>
        <th scope="col">Ville</th>
        <!-- <th scope="col">Gestionnaire</th> -->
        <th scope="col">Département</th>
        <th scope="col">Distance</th>
        <th scope="col">Status</th>
        <th scope="col">Tarif</th>
    </tr>
</thead>
<tbody>
    <?php $rows = 0;
    foreach( $historyBody->response as $k=>$residence ){ ?>
    <tr>
        <td><a
                href="<?php echo '/residence/' . $residence->nid; ?>"><?php echo ($k+1).' '. $residence->title ?></a>
        </td>
        <td><?php echo $residence->field_location_postal_code; ?></td>
        <td><?php echo $residence->field_location_locality; ?></td>
        <!-- <td><?php //echo $residence->field_gestionnaire_value; ?></td> -->
        <td><?php echo $residence->name; ?></td>
        <td><?php echo round($residence->distance, 2); ?> KM</td>
        <td><?php echo $residence->field_statut_value; ?></td>
        <td><?php echo $residence->field_tarif_chambre_simple_value; ?> €</td>
    </tr>
    <?php } ?>
</tbody></table></div></div>
<?}?>
                </div>
            </div>
        </div>
    </div>

</section>
<script>var hst='<?=$history->title?>';
$(document).ready(function(){
    if(hst=='prescripteur'){
        if($('#persons').length) {
            $('#persons').DataTable({"language": {url: frenchDataTables},"paging":true,"pagelength":25, "searching": true/*, "order": [[5, "asc"]]*/, columnDefs: [/*{"searchable": false, "targets": [1,4,5,6]}/*,{type: 'natural-nohtml', targets: 6}*/]
            });
        }
        if($('#residences-result-table').length) {
            $('#residences-result-table').DataTable({"language": {url: frenchDataTables}, "paging":true,"pagelength":25,"searching": true, "order": [[4, "asc"]], columnDefs: [/*{type: 'natural-nohtml', targets: 6}*/]});
        }
    }else{
        if($('#residences-result-table').length) {
            $('#residences-result-table').DataTable({"language": {url: frenchDataTables}, "paging":true,"pagelength":25,"searching": true, "order": [[4, "asc"]], columnDefs: [/*{type: 'natural-nohtml', targets: 6}*/]});
        }
    }
});
</script>
