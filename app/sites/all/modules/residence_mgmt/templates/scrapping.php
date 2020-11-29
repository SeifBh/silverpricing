<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../inc/geocoding.inc.php";

use DiDom\Document;

class Residence {
    public $title;
    public $link;
}

function residence_mgmt_scrapping() {
    set_time_limit(0);
    //residence_mgmt_page_detail_scrapping();
    residence_mgmt_page_scrapping(973);#
}

function residence_mgmt_page_scrapping($departmentNumber = null) {

    $currentUrl = "https://www.pour-les-personnes-agees.gouv.fr/annuaire-ehpad-en-hebergement-permanent/" . $departmentNumber . "/0";
    $currentDepartment = new Document($currentUrl, true);
    $residencesTotal = $currentDepartment->first('#cnsa_results-total b')->getNode()->nodeValue;
    $currentPage = 0;

    $residences = array();

    while( count($residences) < $residencesTotal ) {

        $currentDepartment = new Document( $currentUrl . '?page=' . $currentPage, true);
        $residencesList = $currentDepartment->find('#cnsa_results-list .cnsa_results-item .cnsa_results-titlecol');

        foreach( $residencesList as $r ) {
            $residence = new Residence();

            if( $r->has('a') ) {
                $link = $r->first('a')->getNode();
                $residence->link = $link->getAttribute('href');
                $residences[] = residence_mgmt_page_detail_scrapping($residence->link);
            }

            $title = $r->first('h3.cnsa_results-tags1')->getNode();
            $residence->title = $title->nodeValue;

        }

        //break;

        $currentPage++;

    } ;

    return $residences;
}

function _data2object($_c,$currentUrl){
    $residence = new StdClass();#noFinesset
    $residence->urlSource = $currentUrl;
    $residence->modificationDate = date('YmdHis',strtotime($_c['updatedAt']));
    $residence->title = $_c['title'];#$title->getNode()->nodeValue;

    $residence->gestionnaire = $_c['coordinates']['gestionnaire'];#trim(str_replace('Gestionnaire :', '', $itemLeft->first('.fiche-box .cnsa_search_item-statut')->getNode()->nodeValue));
    $residence->statut = $_c['legal_status'];#trim(str_replace('Statut juridique :', '', $itemLeft->first('.fiche-box .cnsa_search_item-statut2')->getNode()->nodeValue));
    $residence->address = trim(preg_replace('/\s+/', ' ', $_c['coordinates']['title'].' '.$_c['coordinates']['street'].' '.$_c['coordinates']['postcode'].' '.$_c['coordinates']['city']));
    $residence->phone =$_c['coordinates']['phone'];
    $residence->email =$_c['coordinates']['emailContact'];
    $residence->website =$_c['coordinates']['website'];

    if($_c['ehpadPrice']['prixHebPermCd'])$residence->tarif[0]['chambre-double']=$_c['ehpadPrice']['prixHebPermCd'];
    if($_c['ehpadPrice']['prixHebTempCd'])$residence->tarif[1]['chambre-double']=$_c['ehpadPrice']['prixHebTempCd'];
    if($_c['ehpadPrice']['prixHebPermCs'])$residence->tarif[0]['chambre-simple']=$_c['ehpadPrice']['prixHebPermCs'];
    if($_c['ehpadPrice']['prixHebTempCs'])$residence->tarif[1]['chambre-simple']=$_c['ehpadPrice']['prixHebTempCs'];
    if($_c['ehpadPrice']['prixHebPermCda'])$residence->tarif['cda']=$_c['ehpadPrice']['prixHebPermCda'];
    if($_c['ehpadPrice']['prixHebPermCsa'])$residence->tarif['csa']=$_c['ehpadPrice']['prixHebPermCsa'];
    /*
    cuj "https://ehpad.home/dashboard?xhp=trace" '' 0 'SSESS02da88e2f02ccdeaa197b0dcdf4d100a=wNz6DGQ1m45ecM2E18vwm1ERJwt490dRJm iSg215Z4o;SESS02da88e2f02ccdeaa197b0dcdf4d100a=y-i9JGchnQTmin20XM0bOx6gEK6mB942fHOWpfIqyIM'
     $chambre->field_tarif_cs_aide_sociale[LANGUAGE_NONE][0]['value'] = $data['tarif_chambre_simple_aide_sociale'];
            $chambre->field_tarif_cd_aide_sociale[LANGUAGE_NONE][0]['value'] = $data['tarif_chambre_double_aide_sociale'];
    $_c['ehpadPrice']
    0:normal, 1:tempo

    prixHebPermCda -> cs-aide-sociale -> field_tarif_cd_aide_sociale
    prixHebPermCsa -> cs-aide-sociale -> field_tarif_cs_aide_sociale
    prixHebTempCsa

    =>https://ehpad.home/node/42680/edit
foreach( $tarifTables as $type => $tarifTable ) {
foreach( $tarifTable->find('tr') as $tarif ) {
    $tarifKey = preg_replace('/[^A-Za-z0-9-*]+/', '-', $tarif->first('td.text-left')->getNode()->nodeValue);
    $tarifValue = str_replace("€/jour", "", $tarif->first('td.text-right')->getNode()->nodeValue);
    $residence->tarif[$type][strtolower($tarifKey)] = str_replace(",", ".", $tarifValue);
}
}
    */
#
#$residence->tarif[$type][strtolower($tarifKey)] = str_replace(",", ".", $tarifValue);
    return $residence;
}

/*
 * Drupal 7 new route to module action ..
 */

function updateAll(){
    $_a=Alptech\Wip\fun::cup(['url'=>'https://www.pour-les-personnes-agees.gouv.fr/api/v1/establishment/','timeout'=>1600]);
    if(!$_a['contents'] or $_a["info"]["http_code"]!=200 or $_a['error']){
        \Alptech\Wip\fun::dbm([__FILE__.__line__,'scrappingError:'.$currentUrl,$_a],'php500');
        return null;
    }
    if(1){
        $chambreIdtoResId=$resFit2Id=[];
        $x=Alptech\Wip\fun::sql("SELECT entity_id as a,field_finess_value as b FROM silverpricing_db.field_revision_field_finess t where t.bundle='residence' group by entity_id order by revision_id desc");
        foreach($x as $t){$resFit2Id[$t['b']]=$t['a'];}
        $x=Alptech\Wip\fun::sql("SELECT entity_id as a,field_residence_target_id as b FROM silverpricing_db.field_revision_field_residence t where t.bundle='chambre' group by entity_id order by revision_id desc");
        foreach($x as $t){$chambreIdtoResId[$t['b']]=$t['a'];}
        $a=1;
    }
$mem=memory_get_usage(1);
    $_c=json_decode($_a['contents'],1);unset($_a);
    foreach($_c as $k=>$t){
        $finess=$t['noFinesset'];
        if(isset($resFit2Id[$finess])){
            $residence= node_load($resFit2Id[$finess]);
            $a=1;
        } else{
            $a=1;#$residenceData from ça
            $residence=addResidence($residenceData,$departement);
            $a=1;
        }
        $chambres=array_keys($chambreIdtoResId,$residence->nid);
        if($chambres) {
            $cnid= reset($chambres);
        }else{
            $a=1;
            $chambre=addChambre($chambreData = null, $residence);
            $cnid=$chambre->nid;
        }
        #todo : get chambre nodeId per Residence fitness Number ( might not exists !//// )
        $data=_data2object($v);
        synchronizeChambre($cnid,$data,$finess);#+ finess
    }
}

#cuj "https://ehpad.home/admin/config/content/residences_management" '' '{"residence_mgmt_department_select":["74"],"op":"Importation","form_build_id":"form-UygdJ54Z6PbVEJE1miIAremWXumjzAbzdRP_vXVOTus","form_token":"5niaHCGX4qiMShE7xcxzD1_lmJFRzoV6Gylwa0HJH0g","form_id":"residence_mgmt_admin_form"}' 1 "SESS02da88e2f02ccdeaa197b0dcdf4d100a=y-i9JGchnQTmin20XM0bOx6gEK6mB942fHOWpfIqyIM;SSESS02da88e2f02ccdeaa197b0dcdf4d100a=wNz6DGQ1m45ecM2E18vwm1ERJwt490dRJmiSg215Z4o;XDEBUG_SESSION=XDEBUG_ECLIPSE"
function residence_mgmt_page_detail_scrapping($currentUrl = null,$finess=0) {
    if('new'){
        #Todo add to curl multi exec
        if(!$finess){preg_match('~[0-9]{6,}~',$currentUrl,$m);if($m[0])$finess=$m[0];}#/*$finess=explode('/',$currentUrl);array_pop($id);$id=array_pop($id);*/
        $_a=Alptech\Wip\fun::cup(['url'=>'https://www.pour-les-personnes-agees.gouv.fr/api/v1/establishment/'.$finess,'timeout'=>900]);
        if(!$_a['contents'] or $_a["info"]["http_code"]!=200 or $_a['error']){
            \Alptech\Wip\fun::dbm([__FILE__.__line__,'scrappingError:'.$currentUrl,$_a],'php500');
            return null;
            die('erreur');
            return new StdClass();
        }
    #https://www.pour-les-personnes-agees.gouv.fr/fiche-annuaire/hebergement/740789656/0 => redirects to https://www.pour-les-personnes-agees.gouv.fr/annuaire-ehpad-et-maisons-de-retraite/EHPAD/HAUTE-SAVOIE-74/thonon-les-bains-74200/ehpad-la-prairie/740789656
        $_c=json_decode($_a['contents'],1)[0];
        return _data2object($_c,$currentUrl,$finess);
    }
###### Ancienne méthode ci dessous
    stream_context_set_default( [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);

    $headers = get_headers($currentUrl);
    $urlExist = $headers && strpos( $headers[0], '200');
    if( !$urlExist ) {
        return null;
    }

    $currentResidence = new Document();
    $currentResidence->loadHtmlFile($currentUrl);#
#$currentResidence->getDocument()->saveHTMLFile('recup.html');
    $content = $currentResidence->first('#cnsa_search_item');

    $title = $content->first('#cnsa_search_item-title h1');
    $itemCenter = $content->first('#cnsa_search_item-center');
    $itemLeft = $content->first('#cnsa_search_item-left-inside');
    $tarifTables = $itemCenter->find('table');

    $residence->urlSource = $currentUrl;
    $residence->title = $title->getNode()->nodeValue;
    $residence->gestionnaire = trim(str_replace('Gestionnaire :', '', $itemLeft->first('.fiche-box .cnsa_search_item-statut')->getNode()->nodeValue));
    $residence->statut = trim(str_replace('Statut juridique :', '', $itemLeft->first('.fiche-box .cnsa_search_item-statut2')->getNode()->nodeValue));
    $residence->address = $itemLeft->first('.fiche-box .cnsa_search_item-addr')->getNode()->nodeValue;
    $residence->address = trim( preg_replace('/\s+/', ' ', str_replace("Adresse :", "", $residence->address)));
    if( $itemLeft->has('.fiche-box .cnsa_search_item-tel') ) {
        $residence->phone = trim(str_replace('Téléphone', '', $itemLeft->first('.fiche-box .cnsa_search_item-tel')->getNode()->nodeValue));
    }
    if( $itemLeft->has('.fiche-box .cnsa_search_item-courriel') ) {
        $residence->email = trim($itemLeft->first('.fiche-box .cnsa_search_item-courriel')->getNode()->nodeValue);
    }
    if( $itemLeft->has('.fiche-box .cnsa_search_item-site a') ) {
        $residence->website = $itemLeft->first('.fiche-box .cnsa_search_item-site a')->getNode()->getAttribute('href');
    }
#chambre_simple
    foreach( $tarifTables as $type => $tarifTable ) {
        foreach( $tarifTable->find('tr') as $tarif ) {
            $tarifKey = preg_replace('/[^A-Za-z0-9-*]+/', '-', $tarif->first('td.text-left')->getNode()->nodeValue);
            $tarifValue = str_replace("€/jour", "", $tarif->first('td.text-right')->getNode()->nodeValue);
            $residence->tarif[$type][strtolower($tarifKey)] = str_replace(",", ".", $tarifValue);
        }
    }

    if( $itemCenter->has('span.title-detail') ) {
        $modificationDate = trim(str_replace('mis à jour le ', '', $itemCenter->first('span.title-detail')->getNode()->nodeValue));
        $modificationDate = date_create_from_format('d/m/Y', $modificationDate);
        $residence->modificationDate = date('Y-m-d H:i:s', $modificationDate->getTimestamp());
    } else {
        $residence->modificationDate = date('Y-m-d H:i:s');
    }


    return $residence;
}
