<?php
/*bootstraped action
EHPAD Ornano - Rsidence Les Intemporelles	 -> check id
1) S'assurer que le processus d'update des résidences a bien lieu avant !
php72 z/geo.php reindex
php72 ~/home/ehpad/app/z/alerts.php '{"210007159":{"prixHebPermCs":1}}' ;


cd /home/ubuntu/SilverPricing/public_html/app.silverpricing.fr/z/;
dat=`date +%y%m%d%H%M`;php7.1 alerts.php | tee alerts.$dat.log;

php7.1 /home/ubuntu/SilverPricing/public_html/app.silverpricing.fr/z/alerts.php

 */
if(!isset($argv))die; $prod=1;$maxNeighbours=10;
$_SERVER['DOCUMENT_ROOT']=__DIR__.'/../';
chdir(__DIR__);
$_mem=[__line__=>memory_get_usage(1)];
$module='../sites/all/modules/residence_mgmt';
require_once "../vendor/autoload.php";#alptech
$_ENV['dieOnFirstError']=1;

if($prod){
#Your Composer dependencies require the following PHP extensions to be installed: curl, dom, mbstring, simplexml, xml, xmlreader, xmlwriter, zip --> phpcli.ini
    require_once $module . "/vendor/autoload.php";#others -- dont need them
    require_once $module . "/data/data_config.php";
    require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
    drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
    require_once $module . "/residence_mgmt.module";

    if(isset($GLOBALS['argv'][1]) and 0) {
        $x = Alptech\Wip\io::isJson($GLOBALS['argv'][1]);
        updateAllResidencesFromPersonnesAgeesJson(array_keys($x)[0],reset($x));#£:todo:forcedJsonDataForVariations
    }else{
        updateAllResidencesFromPersonnesAgeesJson();
    }
}
$start=time();
/* todo lock by date */
$now=1607679698;$rids=$cs0=$cs1=[];
$x=Alptech\Wip\fun::sql("select max(date)as d from z_variations");if(!$x)die('#'.__line__);$now=$x[0]['d'];
$f=__file__.'.last';if($prod and !isset($_SERVER['WINDIR']) and is_file($f) and filemtime($f)>=$now)die("\n".__line__.' :: '.filemtime($f).'>='.$now);    touch($f,$now);/* */

$x=Alptech\Wip\fun::sql("select rid,cs_0,cs_1 from z_variations where cs_1 is not null and cs_0 is not null order by date desc");# ->choper les dernières variations listées dans le temps
foreach($x as $t){if(isset($cs0[$t['rid']]))continue;$cs0[$t['rid']]=$t['cs_0'];$cs1[$t['rid']]=$t['cs_1'];}#bcp de tarifs ..

#seulement les ehpads concernées par dernier update
$sql="select rid,cs_0,cs_1 from z_variations where date=".$now." and cs_1 is not null and cs_0 is not null order by rid desc";$x=Alptech\Wip\fun::sql($sql);   if(!$x)die('#'.__line__);foreach($x as $t){$rids[]=$t['rid'];}
$rids=array_unique($rids);$residencesTriggers=$rids;
#$x=Alptech\Wip\fun::sql("select * from z_variations where date=1607679698 and cs_1 is not null and cs_0 is not null order by id desc limit 1");# -> rid
#$x=Alptech\Wip\fun::sql("select * from z_variations where date=1607679698 cs_1 is not null and cs_0 is not null order by id desc limit 1");# choper les chambres associées à ces résidence, le tarif simple uniquement
$regexp=','.implode(',|,',$rids).',';
#$notifiees=Alptech\Wip\fun::sql("select group_concat(rid) from z_geo where `list` regexp '".$regexp."' desc limit 1");
$sql="select rid,list from z_geo where closest is not null and `list` regexp '".$regexp."'";
$notifiees=Alptech\Wip\fun::sql($sql);#il nous faut tout
if(!$notifiees)die('#'.__line__);
$proxima10G=$proxima10=[];
foreach($notifiees as $notifiee){#paddys 4 avenue du jura et de la poterie
    $proxima10[$notifiee['rid']]=[];
    $liste=trim($notifiee['list'],',');
    $closests=array_splice(explode(',',$liste),0,$maxNeighbours);
    #$closests=Alptech\Wip\io::isJson($notifiee['closest']);
    #foreach($closests as $distance=>$_rids){foreach($_rids as $rid){
    foreach($closests as $rid){
        $proxima10G[]=$proxima10[$notifiee['rid']][]=$rid;#afin de limiter à 10
        #if(count($proxima10[$notifiee['rid']])>=$maxNeighbours)break;
    }
    $b=1;
}

$proxima10G=array_unique($proxima10G);
if(0){
/*$proxima10G2=[];
$x=Alptech\Wip\fun::sql("select rid,closest from z_geo where rid in(".implode(',',$proxima10G).")");#il nous faut tout
foreach($x as $t){
    if(isset($proxima10G2[$t['rid']]) and count($proxima10G2[$t['rid']])>=10){
        continue;#same point again and again
    }
    $closests=Alptech\Wip\io::isJson($t['closest']);
    foreach($closests as $distance=>$_rids){
        foreach($_rids as $rid){
            $proxima10G2[$t['rid']][]=$rid;
            #$proxima10G[]=$proxima10[$notifiee['rid']][]=$rid;
            if(count($proxima10G2[$t['rid']])>=10)break 2;
        }
    }
}*/}

$baseResidences=array_keys($proxima10);
$totalResidences=array_unique(array_merge($baseResidences,$proxima10G));
$missingPrices=[];#foreach($proxima10G as $rid){if (!isset($cs0[$rid])) {$missingPrices[] = $rid;}}
if(1 or $missingPrices){#shouldnt be necessary
    $x = Alptech\Wip\fun::sql("select entity_id,field_residence_target_id from field_data_field_residence where bundle='chambre' and field_residence_target_id in(" . implode(',',$totalResidences) . ")");
    $residence2chambre=$chambres=$_missingChambre=[];foreach($x as $t){$residence2chambre[$t['field_residence_target_id']]=$t['entity_id'];}
    $chambre2residence=array_flip($residence2chambre);

    $ph=[];
    if('2:get prices history => does the whole stuff'){#count(*)as nb,
        $sql="select substring_index(group_concat(field_tarif_chambre_simple_value order by revision_id desc),',',3)as v,substring_index(group_concat(revision_id order by revision_id desc),',',3)as revid,entity_id as cid from field_revision_field_tarif_chambre_simple where entity_id in(" . implode(',', $residence2chambre).") and field_tarif_chambre_simple_value<>'NA' group by entity_id";# order by entity_id desc,revision_id desc
        #$sql="select group_concat(field_tarif_chambre_simple_value order by revision_id desc limit 3)as v,group_concat(revision_id order by revision_id desc limit 3)as revid,entity_id as cid from field_revision_field_tarif_chambre_simple where entity_id in(" . implode(',', $residence2chambre).") and field_tarif_chambre_simple_value<>'NA' group by entity_id";# order by entity_id desc,revision_id desc
        $x = Alptech\Wip\fun::sql($sql);
        foreach ($x as $t) {
            $rid=$chambre2residence[$t['cid']];
            $priceHistory=array_slice(explode(',',$t['v']),0,2);
            foreach($priceHistory as $k=>$v){
                if($k==0)$tarifCs[$rid]=$v;#by revision desc, so it should be the latest one
                $ph[$rid][$k]=$v;
            }
        }
    }
    if(0){/*
        foreach($missingPrices as $_rid){
            if(!isset($residence2chambre[$_rid])){
                $_missingChambre[]=$_rid;
            }else{$qChambrePrix[]=$residence2chambre[$_rid];}
        }

        $sql="select entity_id as k,field_tarif_chambre_simple_value as v from field_data_field_tarif_chambre_simple where entity_id in(".implode(',',$qChambrePrix).")";
        $x=Alptech\Wip\fun::sql($sql);
        foreach($x as $t){
            $_rid=$chambre2residence[$t['k']];
            $cs1[$_rid]=$t['v'];
            $a=1;
        }*/
    }
}
#toutes les résidences les plus proches de celles qui vont recevoir les notifications .. celles dont l'on va devoir charger les prix
$evolutions=[];
foreach($proxima10 as $rid=>$_rids){
    $inc0=$inc1=$_cs0=$_cs1=0;
#php72 ~/home/ehpad/app/z/alerts.php
    foreach($_rids as $_rid) {
        foreach ($ph[$_rid] as $k => $v) {
            if ($k == 0) {
                $_cs1 += $v;
                $inc1++;
            } elseif ($k == 1) {
                $_cs0 += $v;
                $inc0++;
            }
        }
    }
    if(0){foreach($_rids as $_rid){
        if(isset($cs0[$_rid]) and intval($cs0[$_rid])){$_cs0+=$cs0[$_rid];$inc0++;}
        if(isset($cs1[$_rid]) and intval($cs1[$_rid])){$_cs1+=$cs1[$_rid];$inc1++;}
    }}
    if($inc0)$_cs0/=$inc0;
    if($inc1)$_cs1/=$inc1;
    $evolutions[$rid]=[$_cs0,$_cs1];
}
#$dep[$rid]."</td><td>".$tarifCs[$rid]

$res2uid=$rid2groupe=$groupe2uid=$uid2mail=$rid2mail=$rid2title=$dep=[];

$rids=array_keys($proxima10);#same as evolutions
$sql="select b.name as v,entity_id as k from field_data_field_departement a inner join taxonomy_term_data b on b.tid=a.field_departement_tid where entity_id in(".implode(',',array_keys($proxima10)).")";$x=Alptech\Wip\fun::sql($sql);foreach($x as $t){$dep[$t['k']]=$t['v'];}

$sql="select nid,title from node where nid in(".implode(',',$rids).")";$x=Alptech\Wip\fun::sql($sql);
foreach($x as $t){$rid2title[$t['nid']]=$t['title'];}
$sql="select entity_id,field_groupe_tid from field_data_field_groupe where entity_id in(".implode(',',$rids).")";$x=Alptech\Wip\fun::sql($sql);
foreach($x as $t){$rid2groupe[$t['entity_id']]=$t['field_groupe_tid'];}
$x=Alptech\Wip\fun::sql("select uid,mail from users where mail is not null and mail<>''");foreach($x as $t){$uid2mail[$t['uid']]=$t['mail'];}
$x=Alptech\Wip\fun::sql("select entity_id,field_email_value from field_data_field_email where bundle='residence'");foreach($x as $t){$rid2mail[$t['entity_id']]=$t['field_email_value'];}
if('accès et permissions'){
    $x=Alptech\Wip\fun::sql("select field_acces_groupes_target_id as k,group_concat(distinct(entity_id)) as v from field_data_field_acces_groupes group by field_acces_groupes_target_id");foreach($x as $t){$users=explode(',',$t['v']);foreach($users as $user){$groupe2uid[$t['k']][]=$user;}}
    $x=Alptech\Wip\fun::sql("select field_acces_residences_target_id as k,group_concat(distinct(entity_id))as v from field_data_field_acces_residences group by field_acces_residences_target_id");foreach($x as $t){$users=explode(',',$t['v']);foreach($users as $user){$res2uid[$t['k']][]=$user;}}
}
$_mem[__line__]=memory_get_usage(1);
#ayant des notifications .. mais les détailler résidence par résidence ???
$notifications=[];
foreach($rids as $rid){
    #if(isset($rid2mail[$rid]));#public email
    if(isset($res2uid[$rid])){
        foreach($res2uid[$rid] as $uid){
            $notifications[$uid2mail[$uid]][]=$rid;#la plus directe, sinon par groupe, puis par utilisateur
            $a=1;
        }
    }
    if(isset($rid2groupe[$rid])){
        $grp=$rid2groupe[$rid];
        if(isset($groupe2uid[$grp])){#126 ok
            foreach($groupe2uid[$grp] as $uid){
                $notifications[$uid2mail[$uid]][]=$rid;
                $a=1;
            }
        }
    }
}

$sent=0;
foreach($notifications as $mail=>$notifs){
    if((!$prod and $sent)or !$notifs){continue;}#ne rien envoyer s'ils n'y a rien à notifier !
    if(!$prod){$mail='ben@x24.fr';$sent=1;}
    if(strpos($mail,'@residence-management.dev')){
        $mail=str_replace('@residence-management.dev','-ehpad@x24.fr',$mail);
    }
    $mailBody="<body>Bonjour, voici une alerte sur l'évolution des tarifs des Ehpad voisines de celle que vous gérez<hr><center><table border=1 style='border-collapse:collapse'><thead style='background:#DDD;'><tr><th>Résidence</th><th>Département</th><th>Tarif actuel</th><th>Ancien tarif moyen</th><th>Nouveau tarif moyen</th><th>Évolution</th></tr></thead><tbody>\n";
#mail html broken table
    foreach($notifs as $k=>$rid){
        $bef=round($evolutions[$rid][0],2);
        $aft=round($evolutions[$rid][1],2);
        $evol=round($aft-$bef,2);
        if($evol>0)$evol='+'.$evol;
        #$texts[]=Alptech\Wip\fun::stripHtml($rid2title[$rid],1);
        $s='';if($k % 2==1)$s=" style='background:#DDD;'";
        $mailBody.="\n<tr$s><td id=$rid title=$rid>".Alptech\Wip\fun::stripHtml($rid2title[$rid])."</td><td>".trim(substr($dep[$rid],0,3))."</td><td>".$tarifCs[$rid]."&euro;</td><td>$bef &euro;</td><td>$aft &euro;</td><td>$evol &euro;</td></tr>";
    }
    $mailBody.="\n</tbody></table></center><style>body{font:16px Assistant,'Trebuchet MS',Sans-Serif} th:nth-child(n+2),td:nth-child(n+2){text-align:right} td:nth-child(1){ padding:0 10px; } </style></body>";#thead,tr:nth-child(even){background:#DDD;}
    if ($prod and !$sent) {
        Alptech\Wip\fun::sendMail('kgandrille@wynter.fr', 'Silverpricing : évolution des tarifs des ehpads voisines', $mailBody);
        Alptech\Wip\fun::sendMail('bencopy@x24.fr', 'Silverpricing : évolution des tarifs des ehpads voisines', $mailBody);
    }
    $sent=Alptech\Wip\fun::sendMail(trim($mail),'Silverpricing : évolution des tarifs des ehpads voisines',$mailBody);

    $a=1;

}
#$texts=array_unique($texts);print_r($texts);



$_mem[__line__]=memory_get_usage(1);
#notifications par email : select email by residence, select group user email by residence, select chambres by residences

$c=['timeAlertes'=>(time()-$start),'mailsRecus'=>array_keys($notifications),'0:residenceTriggers'=>count($residencesTriggers),'1:notifiees'=>count($notifiees),'2:proxima10G utilisees pour calcul prix'=>count($proxima10G)];
print_r(compact('c','_mem'));
die;
$a=1;
foreach($evolutions as $rid=>$_rids){
    #$evolutions[$rid]
    $a=1;
}




return;?>
select * from z_variations order by id desc limit 1


$_inserts=json_decode('{"33979":{"cs_0":"81.75","cs_1":1}}',1);
foreach($_inserts as $rid=>$k2v){
$k2v['rid']=$rid;
$k2v['date']=$now;
$sql='insert into z_variations '.Alptech\Wip\fun::insertValues($k2v);
$insertId=Alptech\Wip\fun::sql($sql);#
$b=1;
}
z_variations
