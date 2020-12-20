<?php
function res2ch($liste2){
    if(is_array($liste2))$liste2=implode(',',$liste2);#
    $x = Alptech\Wip\fun::sql("select entity_id,field_residence_target_id from field_data_field_residence where bundle='chambre' and field_residence_target_id in(" . $liste2 . ")");
    $residence2chambre = $_missingChambre = [];
    foreach ($x as $t) {
        $residence2chambre[$t['field_residence_target_id']] = $t['entity_id'];
    }
    return $residence2chambre;
}

function chprix($chambres=[],$limit=20){
    $chambre2residence=array_flip($chambres);
    $sql="select substring_index(group_concat(field_tarif_chambre_simple_value order by revision_id desc),',',$limit)as v,substring_index(group_concat(revision_id order by revision_id desc),',',$limit) as revid,entity_id as cid from field_revision_field_tarif_chambre_simple where entity_id in(" . implode(',', $chambres).") and field_tarif_chambre_simple_value<>'NA' group by entity_id";# order by revision_id desc
    #$sql="select group_concat(field_tarif_chambre_simple_value order by revision_id desc limit 3)as v,group_concat(revision_id order by revision_id desc limit 3)as revid,entity_id as cid from field_revision_field_tarif_chambre_simple where entity_id in(" . implode(',', $chambres).") and field_tarif_chambre_simple_value<>'NA' group by entity_id";# order by revision_id desc
    if($limit<2){
        $sql="select entity_id as cid,field_tarif_chambre_simple_value as v from field_data_field_tarif_chambre_simple where entity_id in(" . implode(',', $chambres).")";
    }
    $x = Alptech\Wip\fun::sql($sql);
    foreach ($x as $t) {
        $rid=$chambre2residence[$t['cid']];
        $priceHistory[$rid]=explode(',',$t['v']);#array_slice(,0,2);
    }
    return $priceHistory;
}
return;
