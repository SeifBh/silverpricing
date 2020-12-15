<?php
/*bootstraped action
php72 z/geo.php reindex
php72 ~/home/ehpad/app/z/alerts.php '{"210007159":{"prixHebPermCs":1}}' ;

php /home/ubuntu/SilverPricing/public_html/app.silverpricing.fr/z/alerts.php
 */
if(!isset($argv))die;
$_SERVER['DOCUMENT_ROOT']=__DIR__.'/../';
chdir(__DIR__);
$_mem=[__line__=>memory_get_usage(1)];
$module='../sites/all/modules/residence_mgmt';
require_once "../vendor/autoload.php";#alptech
$_ENV['dieOnFirstError']=1;

/* todo lock by date */
$f=__file__.'.last';
$now=1607679698;$rids=$cs0=$cs1=[];
$x=Alptech\Wip\fun::sql("select max(date)as d from z_variations");if(!$x)die('#'.__line__);$now=$x[0]['d'];
#if(!isset($_SERVER['WINDIR']) and is_file($f) and filemtime($f)>=$now)die(filemtime($f).'>='.$now);    touch($f,$now);/* */

$x=Alptech\Wip\fun::sql("select rid,cs_0,cs_1 from z_variations where cs_1 is not null and cs_0 is not null order by date desc");# -> rid
foreach($x as $t){if(isset($cs0[$t['rid']]))continue;$cs0[$t['rid']]=$t['cs_0'];$cs1[$t['rid']]=$t['cs_1'];}#bcp de tarifs ..

#seulement ceux concernés par dernier update
$sql="select rid,cs_0,cs_1 from z_variations where date=".$now." and cs_1 is not null and cs_0 is not null order by rid desc";$x=Alptech\Wip\fun::sql($sql);   if(!$x)die('#'.__line__);foreach($x as $t){$rids[]=$t['rid'];}
$rids=array_unique($rids);$residencesTriggers=$rids;
#$x=Alptech\Wip\fun::sql("select * from z_variations where date=1607679698 and cs_1 is not null and cs_0 is not null order by id desc limit 1");# -> rid
#$x=Alptech\Wip\fun::sql("select * from z_variations where date=1607679698 cs_1 is not null and cs_0 is not null order by id desc limit 1");# choper les chambres associées à ces résidence, le tarif simple uniquement
$regexp=','.implode(',|,',$rids).',';
#$notifiees=Alptech\Wip\fun::sql("select group_concat(rid) from z_geo where `list` regexp '".$regexp."' desc limit 1");
$sql="select rid,closest from z_geo where closest is not null and `list` regexp '".$regexp."'";
$notifiees=Alptech\Wip\fun::sql($sql);#il nous faut tout
if(!$notifiees)die('#'.__line__);
$proxima10G=$proxima10=[];
foreach($notifiees as $notifiee){#paddys 4 avenue du jura et de la poterie
    $proxima10[$notifiee['rid']]=[];
    $closests=Alptech\Wip\io::isJson($notifiee['closest']);
    foreach($closests as $distance=>$_rids){
        foreach($_rids as $rid){
            $proxima10G[]=$proxima10[$notifiee['rid']][]=$rid;#afin de limiter à 10
            if(count($proxima10[$notifiee['rid']])>=10)break 2;
        }
    }
    $b=1;
}

$proxima10G=array_unique($proxima10G);
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
}*/

$missingPrices=[];foreach($proxima10G as $rid){if (!isset($cs0[$rid])) {$missingPrices[] = $rid;}}
if($missingPrices){#shouldnt be necessary
    $x=Alptech\Wip\fun::sql("select entity_id,field_residence_target_id from field_data_field_residence where bundle='chambre'");
    $residence2chambre=$chambres=$_missingChambre=[];foreach($x as $t){$residence2chambre[$t['field_residence_target_id']]=$t['entity_id'];}
    $chambre2residence=array_flip($residence2chambre);
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
    }
}
#toutes les résidences les plus proches de celles qui vont recevoir les notifications .. celles dont l'on va devoir charger les prix
$evolutions=[];
foreach($proxima10 as $rid=>$_rids){
    $inc0=$inc1=$_cs0=$_cs1=0;
    foreach($_rids as $_rid){
        if(isset($cs0[$_rid]) and intval($cs0[$_rid])){$_cs0+=$cs0[$_rid];$inc0++;}
        if(isset($cs1[$_rid]) and intval($cs1[$_rid])){$_cs1+=$cs1[$_rid];$inc1++;}
    }
    if($inc0)$_cs0/=$inc0;
    if($inc1)$_cs1/=$inc1;
    $evolutions[$rid]=[$_cs0,$_cs1];
}

$res2uid=$rid2groupe=$groupe2uid=$uid2mail=$rid2mail=$rid2title=[];

$rids=array_keys($evolutions);
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

foreach($notifications as $mail=>$notifs){
    if(strpos($mail,'@residence-management.dev')){
        $mail=str_replace('@residence-management.dev','-ehpad@x24.fr',$mail);
    }
    $mailBody="<body>Bonjour, voici une alerte sur l'évolution des tarifs des Ehpad voisines de celle que vous gérez<hr><center><table border=1 style='border-collapse:collapse'><thead><tr><th>Résidence</th><th>Ancien tarif moyen</th><th>Nouveau tarif moyen</th><th>Évolution</th></tr></thead><tbody>";
    foreach($notifs as $rid){
        $bef=round($evolutions[$rid][0],2);
        $aft=round($evolutions[$rid][1],2);
        $evol=round($aft-$bef,2);
        if($evol>0)$evol='+'.$evol;
        $mailBody.="<tr><td>".stripmail($rid2title[$rid])."</td><td>$bef €</td><td>$aft €</td><td>$evol €</td></tr>";
    }
    $mailBody.="</tbody></table></center><style>body{font:16px Assistant,'Trebuchet MS',Sans-Serif} th:nth-child(n+2),td:nth-child(n+2){text-align:right} td:nth-child(1){ padding:0 10px; } thead,tr:nth-child(even){background:#DDD;}</style></body>";
    Alptech\Wip\fun::sendMail(trim($mail),'Silverpricing : évolution des tarifs des ehpads voisines',$mailBody);
    $a=1;
}

function stripmail($x){
    return preg_replace('~<[^>]+>~is','',strip_tags($x));
}

$_mem[__line__]=memory_get_usage(1);
#notifications par email : select email by residence, select group user email by residence, select chambres by residences

$c=['mailsRecus'=>array_keys($notifications),'0:residenceTriggers'=>count($residencesTriggers),'1:notifiees'=>count($notifiees),'2:proxima10G utilisees pour calcul prix'=>count($proxima10G)];
print_r(compact('c','_mem'));
die;
$a=1;
foreach($evolutions as $rid=>$_rids){
    #$evolutions[$rid]
    $a=1;
}


require_once $module . "/vendor/autoload.php";#others
require_once $module . "/data/data_config.php";
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
require_once $module . "/residence_mgmt.module";

if(isset($GLOBALS['argv'][1])) {
    $x = Alptech\Wip\io::isJson($GLOBALS['argv'][1]);
    residence_mgmt_cron(array_keys($x)[0],reset($x));
}else{
    residence_mgmt_cron();
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
