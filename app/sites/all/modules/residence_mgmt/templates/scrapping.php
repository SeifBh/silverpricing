<?php
/*
$node->setNewRevision(TRUE);
$node->revision_log = 'Created revision for node' . $nid;
$node->setRevisionCreationTime(REQUEST_TIME);
$node->setRevisionUserId($user_id);
 */
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

function _data2object($_c, $currentUrl = null, $residence = null)
{
    if(!$residence) $residence = new StdClass();#noFinesset
    if($currentUrl)$residence->urlSource = $currentUrl;
    $residence->modificationDate = date('YmdHis',strtotime($_c['updatedAt']));
    $residence->title = $_c['title'];#$title->getNode()->nodeValue;

    $residence->gestionnaire = $_c['coordinates']['gestionnaire'];#trim(str_replace('Gestionnaire :', '', $itemLeft->first('.fiche-box .cnsa_search_item-statut')->getNode()->nodeValue));
$status='Privé';
if(preg_match('~assoc~i',$t['legal_status']))$status='Associatif';
elseif(preg_match('~public~i',$t['legal_status']))$status='Public';
$a=1;
    $residence->status=$status;#privé non lucratif #<== todo conversion????
#$residence->statut = $_c['legal_status'];#trim(str_replace('Statut juridique :', '', $itemLeft->first('.fiche-box .cnsa_search_item-statut2')->getNode()->nodeValue));
    $residence->address = trim(preg_replace('/\s+/', ' ', $_c['coordinates']['title'].' '.$_c['coordinates']['street'].' '.$_c['coordinates']['postcode'].' '.$_c['coordinates']['city']));
    $residence->phone =$_c['coordinates']['phone'];
    $residence->email =$_c['coordinates']['emailContact'];
    $residence->website =$_c['coordinates']['website'];
    if ($_c['ehpadPrice']) {
        if($_c['ehpadPrice']['prixHebPermCd'])$residence->tarif[0]['chambre-double']=$_c['ehpadPrice']['prixHebPermCd'];
        if($_c['ehpadPrice']['prixHebTempCd'])$residence->tarif[1]['chambre-double']=$_c['ehpadPrice']['prixHebTempCd'];
        if($_c['ehpadPrice']['prixHebPermCs'])$residence->tarif[0]['chambre-seule']=$_c['ehpadPrice']['prixHebPermCs'];
        if($_c['ehpadPrice']['prixHebTempCs'])$residence->tarif[1]['chambre-seule']=$_c['ehpadPrice']['prixHebTempCs'];
        if($_c['ehpadPrice']['prixHebPermCda'])$residence->tarif['cda']=$_c['ehpadPrice']['prixHebPermCda'];
        if($_c['ehpadPrice']['prixHebPermCsa'])$residence->tarif['csa']=$_c['ehpadPrice']['prixHebPermCsa'];
    }
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

/*php -l sites/all/modules/residence_mgmt/templates/scrapping.php
Drupal 7 new route to module action ..

my -u a -pb silverpricing_db < ../db/silverpricing_db.sql;drushy cc all;
a;cuj 'https://ehpad.home/updateAllResidencesByJson' a '' 1 'sql=(insert|update) ';b;say done;
on second update shall stop uneccessary updates
*/
function updateAllResidencesFromPersonnesAgeesJson($forceFiness=null,$tarifsForces=null,$_c=null){
#todo:lock##ini_set('max_execution_time',9999999);
    ini_set('max_execution_time',-1);ini_set('memory_limit',-1);
    if(strpos($_SERVER['HTTP_HOST'],'.home')===FALSE){
        $lf=__file__.__function__.'.lock';if(is_file($lf) and filemtime($lf)>time()-70000)die("locked:$lf");touch($lf);
        register_shutdown_function(function()use($lf){
            $a=1;
            unlink($lf);});#
    }
    echo'<pre>';
    $btime=$starts=time();
/* Attention : ce ne sont pas toutes des Ehpad .. */
    $ch2date=$res2date=$__inserts=$__updates=$chambreIdtoResId=$resFit2Id=$ch2date=$res2date=$notModified=$fin2rid=$tarifsModifies=$c2r=[];$geomodif=$newResidences=0;
    $url='https://www.pour-les-personnes-agees.gouv.fr/api/v1/establishment/';#finess:argv2, noFinesset/010001246
    #$url='https://www.pour-les-personnes-agees.gouv.fr/api/v1/establishment/010001246';
    if(!$_c){
        $f=$_SERVER['DOCUMENT_ROOT'].'z/curlcache/'.date('ymd').'-'.preg_replace('~[^a-z0-9\.\-_]+|\-+~i','-',$url).'json';
        if(is_file($f)){
            $_a=['contents'=>file_get_contents($f)];#cached
        }else{
            $_a=Alptech\Wip\fun::cup(['url'=>$url,'timeout'=>1600]);
            if(!$_a['contents'] or $_a['info']['http_code']!=200 or $_a['error']){
                \Alptech\Wip\fun::dbm([__FILE__.__line__,'scrappingError:'.$currentUrl,$_a],'php500');
                return null;
            }
            $_written=file_put_contents($f,$_a['contents']);#
            $_c=json_decode($_a['contents'],1);
        }
    }
    unset($_a);
    $_mem[__line__]=memory_get_usage(1);
    foreach($_c as $k=>&$t){
        $finesses[]=ltrim($t['noFinesset']);
    }
    $finesses=array_unique($finesses);

if('memTarif'){
    $tarifs=['cs'=>[],'cst'=>[],'cd'=>[],'cdt'=>[],'gir12'=>[],'gir34'=>[],'gir56'=>[]];
    $x=Alptech\Wip\fun::sql("select field_tarif_chambre_simple_value as v,entity_id as id from field_data_field_tarif_chambre_simple where field_tarif_chambre_simple_value<>'NA'");#where entity_id in array_keys($__updates['chambre']);
    foreach($x as $t){$tarifs['cs'][$t['id']]=$t['v'];}
    $x=Alptech\Wip\fun::sql("select field_tarif_chambre_double_value as v,entity_id as id from field_data_field_tarif_chambre_double where field_tarif_chambre_double_value<>'NA'");
    foreach($x as $t){$tarifs['cd'][$t['id']]=$t['v'];}
    $x=Alptech\Wip\fun::sql("select field_tarif_chambre_simple_tempo_value as v,entity_id as id from field_data_field_tarif_chambre_simple_tempo where field_tarif_chambre_simple_tempo_value<>'NA'");
    foreach($x as $t){$tarifs['cst'][$t['id']]=$t['v'];}
    $x=Alptech\Wip\fun::sql("select field_tarif_chambre_double_tempo_value as v,entity_id as id from field_data_field_tarif_chambre_double_tempo where field_tarif_chambre_double_tempo_value<>'NA'");
    foreach($x as $t){$tarifs['cdt'][$t['id']]=$t['v'];}
    $x=Alptech\Wip\fun::sql("select field_tarif_gir_1_2_value as v,entity_id as id from field_data_field_tarif_gir_1_2 where field_tarif_gir_1_2_value<>'NA'");
    foreach($x as $t){$tarifs['gir12'][$t['id']]=$t['v'];}
    $x=Alptech\Wip\fun::sql("select field_tarif_gir_3_4_value as v,entity_id as id from field_data_field_tarif_gir_3_4 where field_tarif_gir_3_4_value<>'NA'");
    foreach($x as $t){$tarifs['gir34'][$t['id']]=$t['v'];}
    $x=Alptech\Wip\fun::sql("select field_tarif_gir_5_6_value as v,entity_id as id from field_data_field_tarif_gir_5_6 where field_tarif_gir_5_6_value<>'NA'");
    foreach($x as $t){$tarifs['gir56'][$t['id']]=$t['v'];}
    $_mem[__line__]=memory_get_usage(1);
    $a=1;
}
#erreur:: ORDER BY clause is not in GROUP BY clause and contains nonaggregated column 'silverpricing_db.t.revision_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by

$mysql58groupMode=Alptech\Wip\fun::sql("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

    $sql="SELECT entity_id as a,field_finess_value as b FROM field_data_field_finess t where t.bundle='residence' and t.field_finess_value in ('".implode("','",$finesses)."')";# group by field_finess_value,entity_id
    #$sql="SELECT entity_id as a,field_finess_value as b FROM field_revision_field_finess t where t.bundle='residence' and t.field_finess_value in ('".implode("','",$finesses)."') group by field_finess_value,entity_id order by revision_id desc";
    $x=Alptech\Wip\fun::sql($sql);
    foreach($x as $t){$fin2rid[$t['b']]=$t['a'];}
    $a=1;#14758
    if('indexes'){
$x=Alptech\Wip\fun::sql("SELECT entity_id as a,field_finess_value as b,n.changed as date FROM field_data_field_finess t inner join node n on n.nid=t.entity_id where t.bundle='residence' group by entity_id");# order by revision_id desc
        foreach($x as $t){$resFit2Id[$t['b']]=$t['a'];$res2date[$t['a']]=$t['date'];}

$x=Alptech\Wip\fun::sql("SELECT t.entity_id as a,field_residence_target_id as b,n.changed as date FROM field_data_field_residence t inner join node n on n.nid=t.entity_id where t.bundle='chambre' group by t.entity_id order by t.revision_id desc");#field_date_de_modification ..
        foreach($x as $t){$res2chambre[$t['b']][]=$t['a'];$ch2date[$t['a']]=$t['date'];}#strtotime($t['date2'])
        $a=1;
    }
#+ todo :: catch all mysql insertions

    $a=1;
    foreach($_c as $k=>&$t){#10899 valeurs / 7400 ehpad
        if($forceFiness) {#Marpa & Autres ...
            if($t['noFinesset']!=$forceFiness){
                continue;
            }
            $t['ehpadPrice']=array_merge($t['ehpadPrice'],$tarifsForces);#sinon magie !!2
            $a=1;
        }
        if(!isset($t['ehpadPrice']) and !$t['IsEHPAD']){#Marpa & Autres ...
            continue;
        }
        #210007159,3979,33980
        $rid=$cnid=$chambre=$residence=$modifRes=$modifCh=$data=0;$chambres=[];
        $lastmod=strtotime($t["updatedAt"]);
        #$finess=ltrim($t['noFinesset'],0);#<== Surtout pas
        $finess=$t['noFinesset'];
        #file_put_contents('current.log',$k.'/'.$finess);#todo apcu / memcached / redis ?
        if(isset($fin2rid[$finess])){
            $a='has';
            if(isset($resFit2Id[$finess])){
                $a='ok';
            }else{
                $whut=1;
            }
        }

        if(isset($resFit2Id[$finess])){#exists :: at 698
            $rid=$resFit2Id[$finess];
            if($res2date[$rid]){
                $modifRes=$res2date[$rid];
                if(isset($res2chambre[$rid])){
                    $chambres=$res2chambre[$rid];
                    if($chambres) {
                        $cnid = reset($chambres);
                        if($ch2date[$cnid]){#compare $lastmod avec
                            $modifCh=$ch2date[$cnid];
                            if($forceFiness and $finess==$forceFiness and 'dérogation'){
                                $t['ehpadPrice'];
                                $modifCh=0;
                            } elseif($lastmod<=$modifRes and $lastmod<=$modifCh){#ne nécessite pas de modification :: si deux runs successifs ...
                                #not modified,
                                $notModified['residence'][]=$rid;
                                $notModified['chambre'][]=$cnid;
                                continue;
                            }
                            $a='chambre existe avec date';
                        }
                        $a='chambre existe';
                    }
                }

if($rid and isset($t['ehpadPrice']) and 'alertes Modification de prix lorsque résidence et chambre trouvée -- et pour une nouvelle résidence ?'){
    if(isset($tarifs['gir12'][$rid]) and $tarifs['gir12'][$rid] != $t['ehpadPrice']['tarifGir12']){$tarifsModifies['r'][$rid]['gir12']=[$tarifs['gir12'][$rid],$t['ehpadPrice']['tarifGir12']];}
    if(isset($tarifs['gir34'][$rid]) and $tarifs['gir34'][$rid] != $t['ehpadPrice']['tarifGir34']){$tarifsModifies['r'][$rid]['gir34']=[$tarifs['gir34'][$rid],$t['ehpadPrice']['tarifGir34']];}
    if(isset($tarifs['gir56'][$rid]) and $tarifs['gir56'][$rid] != $t['ehpadPrice']['tarifGir56']){$tarifsModifies['r'][$rid]['gir56']=[$tarifs['gir56'][$rid],$t['ehpadPrice']['tarifGir56']];}
    #cs,cd,cdt,
    if($cnid){
        $c2r[$cnid]=$rid;#pour mapper par la suite
        $k='cs';$k2='prixHebPermCs';if(isset($tarifs[$k][$cnid]) and $tarifs[$k][$cnid] != $t['ehpadPrice'][$k2]){$tarifsModifies['c'][$cnid][$k]=[$tarifs[$k][$cnid],$t['ehpadPrice'][$k2]];}
        $k='cst';$k2='prixHebTempCs';if(isset($tarifs[$k][$cnid]) and $tarifs[$k][$cnid] != $t['ehpadPrice'][$k2]){$tarifsModifies['c'][$cnid][$k]=[$tarifs[$k][$cnid],$t['ehpadPrice'][$k2]];}
        $k='cd';$k2='prixHebPermCd';if(isset($tarifs[$k][$cnid]) and $tarifs[$k][$cnid] != $t['ehpadPrice'][$k2]){$tarifsModifies['c'][$cnid][$k]=[$tarifs[$k][$cnid],$t['ehpadPrice'][$k2]];}
        $k='cdt';$k2='prixHebTempCd';if(isset($tarifs[$k][$cnid]) and $tarifs[$k][$cnid] != $t['ehpadPrice'][$k2]){$tarifsModifies['c'][$cnid][$k]=[$tarifs[$k][$cnid],$t['ehpadPrice'][$k2]];}
    }
}

#array_keys($chambreIdtoResId,$rid);
                if($lastmod>$modifRes){
                    $residence = node_load($rid);
                    $rtt=$residence->revision_timestamp;#[$residence->revision_timestamp,$modifRes,$lastmod]
                    if($rtt>=$modifRes or $rtt>=$lastmod){
                        $err=1;#revision timestamp above declared modifications
                    }
if(0){
#$residence->type = 'residence';$residence->body = '';$residence->language = LANGUAGE_NONE;
#if($residenceData->finess){$residence->field_finess[$residence->language][0]['value'] = $residenceData->finess;}
#$residence->field_location[$residence->language][0]['country'] = "FR";
}
$residence->modificationDate = date('YmdHis',$lastmod);
$residence->title = $t['title'];#$title->getNode()->nodeValue;
$residence->field_gestionnaire = $t['coordinates']['gestionnaire'];#trim(str_replace('Gestionnaire :', '', $itemLeft->first('.fiche-box .cnsa_search_item-statut')->getNode()->nodeValue));
$status='Privé';    if(preg_match('~assoc~i',$t['legal_status']))$status='Associatif'; elseif(preg_match('~public~i',$t['legal_status']))$status='Public';
$residence->field_statut=$status;#privé non lucratif #<== todo conversion????
#$residence->statut = $_c['legal_status'];#trim(str_replace('Statut juridique :', '', $it1emLeft->first('.fiche-box .cnsa_search_item-statut2')->getNode()->nodeValue));
$residence->address = trim(preg_replace('/\s+/', ' ', $t['coordinates']['title'].' '.$t['coordinates']['street'].' '.$t['coordinates']['postcode'].' '.$t['coordinates']['city']));#not exists !!!!
$residence->field_telephone =$t['coordinates']['phone'];
$residence->field_email =$t['coordinates']['emailContact'];
$residence->field_site =$t['coordinates']['website'];
$residence->field_departement =$t['coordinates']['deptcode'];
#if(isset($residenceData->address))$residence->field_address[$residence->language][0]['value'] = $residenceData->address;
if(isset($t['ehpadPrice'])){
    if($t['ehpadPrice']['tarifGir12'])$residence->field_tarif_gir_1_2['und'][0]['value'] = $t['ehpadPrice']['tarifGir12'];
    if($t['ehpadPrice']['tarifGir34'])$residence->field_tarif_gir_3_4['und'][0]['value'] = $t['ehpadPrice']['tarifGir34'];
    if($t['ehpadPrice']['tarifGir56'])$residence->field_tarif_gir_5_6['und'][0]['value'] = $t['ehpadPrice']['tarifGir56'];
    #$tarifs=['cs'=>[],'cst'=>[],'cd'=>[],'cdt'=>[],'gir12'=>[],'gir34'=>[],'gir56'=>[]];
}
// $residence->field_groupe[$residence->language][0]['value'] = "";
$residence->field_location['und'][0]['locality'] = $t['coordinates']['city'];
$residence->field_location['und'][0]['postal_code'] = $t['coordinates']['postcode'];
if($t['coordinates']['latitude'] != $residence->field_latitude['und'][0]['value']){$geomodif++;$residence->field_latitude['und'][0]['value'] =  $t['coordinates']['latitude'];}
if($t['coordinates']['longitude'] != $residence->field_longitude['und'][0]['value']){$geomodif++;$residence->field_longitude['und'][0]['value'] =  $t['coordinates']['longitude'];}
$b=node_save($residence);
$rid=$residence->nid;
$a=1;
                    $__updates['residences'][]=$finess;
                    #update residence data
                }else{
                    $notModified['residence'][]=$rid;
                }
                $a='résidence a date de dernière modification';
            }

            if(!$residence){#not modified
                $residence= node_load($rid);
            }
            $a=1;
        } else{#y'à pas cette résidence, on la crée
            $a=1;#$residenceData from ça
            $newResidences++;
            $residenceData->finess=$finess;
            $residenceData->title=$t['title'];
            $residenceData->email=$t["coordinates"]["emailContact"];
            $residenceData->website=$t["coordinates"]["website"];
            $residenceData->phone=$t["coordinates"]["phone"];
            $residenceData->gestionnaire=$t["coordinates"]["gestionnaire"];
            #$residenceData->address = trim(preg_replace('/\s+/', ' ', $_c['coordinates']['title'].' '.$_c['coordinates']['street'].' '.$_c['coordinates']['postcode'].' '.$_c['coordinates']['city']));
            $residenceData->location[0]['address']['city']=$t["coordinates"]["city"];
            $residenceData->location[0]['address']['postcode']=$t["coordinates"]["postcode"];
            $residenceData->location[0]['lat']=$t["coordinates"]["latitude"];
            $residenceData->location[0]['lon']=$t["coordinates"]["longitude"];
            $residenceData->groupe = 102;
#select distinct(field_statut_value) from field_revision_field_statut #Associatif,Privé,Public
$status='Privé';
if(preg_match('~assoc~i',$t['legal_status']))$status='Associatif';
elseif(preg_match('~public~i',$t['legal_status']))$status='Public';
$a=1;
$residenceData->status=$status;#privé non lucratif #<== todo conversion????
$residenceData->tarif=[2=>['tarif-gir-1-2'=>0,'tarif-gir-3-4'=>0,'tarif-gir-5-6'=>0]];

            $residence=addResidence($residenceData,$t['coordinates']['deptcode']);
            $rid=$residence->nid;
            $__inserts['residences'][$finess]=$resFit2Id[$finess]=intval($rid);
            $a=1;
        }#array_keys($chambreIdtoResId,31210)[0] == 31209

        if($lastmod>$modifCh){#room needs update ??? #£Si modification Manuelle ne devrait pas être écrasée
            if(isset($res2chambre[$rid])) {
                $chambres = $res2chambre[$rid];#$chambres=array_keys($chambreIdtoResId,$residence->nid);x
                $cnid = reset($chambres);

#$x=Alptech\Wip\fun::sql("select nr.timestamp,field_tarif_chambre_simple_value as v from node_revision nr inner join field_revision_field_tarif_chambre_simple cs on cs.revision_id=nr.vid where nid=$cnid order by timestamp desc limit 2");
#Mettre tous les tarifs dans une matrice et stocker les variations, ici, à la source !!
#select nr.timestamp,field_tarif_chambre_simple_value as v from node_revision nr inner join field_revision_field_tarif_chambre_simple cs on cs.revision_id=nr.vid where nid=33980 order by timestamp desc limit 20

            }else{#création de chambre, sans tarifs, afin de la lier
                $chambreData[0]['chambre-double']='NA';
                $chambreData[1]['chambre-double']='NA';
                $chambreData[0]['chambre-seule']='NA';
                $chambreData[1]['chambre-seule']='NA';
                $chambre=addChambre($chambreData, $residence);
                $cnid=$chambre->nid;
                $chambreIdtoResId[$cnid]=$residence->nid;
                $__inserts['chambre'][$finess]=$cnid=intval($chambre->nid);
            }
    #todo : get chambre nodeId per Residence fitness Number ( might not exists !//// )
    #puis données ordinaires ..
            if($cnid){#si chambre trouvée ( avec des tarifs ) ..
                if(!$data)$data=_data2object($t,null);
                #$residence->modificationDate = date('YmdHis',$lastmod);
                synchronizeChambre($cnid,$data,$finess);
                $__updates['chambres'][]=$cnid;
            }#+ finess
            $a='inserée';
        }else{#no room updates
            $notModified['chambre'][]=$cnid;
        }
        $t=null;
    }unset($t);
    $a=1;
    $took=time()-$starts;$starts=time();
    $msg="\n\ninsert : résidences:".count($__inserts['residences']).';chambres:'.count($__inserts['chambre'])."\nupdates:r:".count($__updates['residences']).';c:'.count($__updates['chambres'])."\nnotModified:r:".count($notModified['residence']).';c:'.count($notModified['chambre'])."\nTook: $took seconds\n";
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'z/updated/'.date('ymdHis').'-chambreResidencesInserted.json',json_encode(compact('msg','__inserts','__updates','notModified')));
    #print_r($__inserts);print_r($__updates);
    if(isset($_ENV['loggedSql']) and $_ENV['loggedSql']){file_put_contents('sqInserts.log',implode("\n",$_ENV['loggedSql']));}
    if($tarifsModifies){
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'z/updated/'.date('ymdHis').'-tarifsModifies.json',json_encode($tarifsModifies));
        $a=1;#
    }

    echo $msg;###<<<  $_ENV['loggedSql']
    unset($msg,$__inserts,$__updates,$notModified,$_c,$tarifs);
    $_mem[__line__]=memory_get_usage(1);

    if($tarifsModifies){
        $sql="update z_rkv set v='".$btime."' where k='lastScrapping";$ok=Alptech\Wip\fun::sql($sql);#

        $_inserts=[];
        foreach($tarifsModifies as $type=>$t){
            if($type=='c'){
                foreach($t as $cid=>$chambre2prix){
                    $rid=$c2r[$cid];
                    foreach($chambre2prix as $chambre=>$prix0){
                        foreach($prix0 as $k=>$prix){
                            $_inserts[$rid][$chambre.'_'.$k]=$prix;
                        }
                    }
                }
                #remonter à la résidence
            }elseif($type=='r'){
                foreach($t as $rid=>$chambre2prix) {
                    foreach ($chambre2prix as $chambre => $prix0) {
                        foreach ($prix0 as $k => $prix) {
                            $_inserts[$rid][$chambre.'_'.$k] = $prix;
                        }
                    }
                }
            }
        }#end foreach tarif modifié

        foreach($_inserts as $rid=>$k2v){
            $k2v['rid']=$rid;
            #$_inserts[]['$lastmod'] =strtotime($t["updatedAt"]);
            #$k2v['date']=$now;
            $k2v['btime']=$btime;
            $k2v['date']=$lastmod;
            $sql='insert into z_variations '.Alptech\Wip\fun::insertValues($k2v);
            $insertId=Alptech\Wip\fun::sql($sql);#
            $b=1;
        }
    }

    #processAlertFor($now);

    $took=time()-$starts;$starts=time();
    #echo"\n\nAlertsTook:$took";#
    if($geomodif or $newResidences){#si seulement modifications géographique ou nouvelle résidence, recalcul des proximités
        $_SESSION['geo']=1;
        $took=time()-$starts;$starts=time();
        require_once rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/z/geo.php';
        echo"\n\nGeocodingTook: $took";#
    }
    return 1;
    if($__inserts['residences']){#do the geo recoding

    }
/*
#A) Get aRids from alert last timestamp
#B) uRids from registred alerts ( user inner join residences )
#C) Intersections geographiques
#D) => from z_geo where rid in($uRids) and list like '%$aRid,%'
#$took=time()-$starts;$starts=time();

my -u a -pb silverpricing_db < ../db/silverpricing_db.sql;drushy cc all;
a;cuj 'https://ehpad.home/yo' a '' 1 'sql=(insert|update) ';b;say done;

Une alerte peut être identifiée par date ! Les interceptions donnent z_variations.id
select * from z_geo where list like'%,33979,%' -- 40 ehpads l'ayant dans ses coordonnées les plus proches
*/
    print_r($_mem);
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
