<?php #vladimir
#gu;list;phpx ~/home/ehpad/app/z/levenshtein.php | tee lev.log
namespace z;chdir(__DIR__);require_once'../autoload.php';#todo:rename to ajax
$levOk=0.2;$vote=1;

if(0 and 'organizations'){
    $f="/Users/ben/Desktop/Health organisations - organisations.tsv";
    $a=is_file($f);
    $x=str_replace(["\toui\t","\tnon\t"],["\t1\t","\t0\t"],file_get_contents($f));
    $x=explode("\n",trim($x));
    $header=explode("\t",array_shift($x));
    #lid	prescripteur	code_categorie	lib_categorie	latitude	longitude	raison_sociale	complément_distribution	adresse	lieu_ou_bp	code_postal	libelle_routage	code_departement	finess	siret	ape	tel	fax	date_ouvert	code_statut	lib_statut	code_tarif	lib_tarif	code_psph	lib_psph	finess_juridique	soc	eml	san	ens	created_at	updated_at
    $ok=explode(',','lid,prescripteur,lib_categorie,latitude,longitude,finess,raison_sociale,adresse,code_postal,libelle_routage');
    $fields=array_intersect($header,$ok);
    \Alptech\Wip\fun::sql('truncate table z_organisations');
    foreach($x as $t){
        $t=explode("\t",$t);$i=[];
        foreach($fields as $nb=>$t2){
            if($t2=='prescripteur' and empty($t[$nb])){$t[$nb]=0;}
            elseif($t2=='code_postal' ){$t[$nb]=''.$t[$nb].'';}
            $i[$t2]=$t[$nb];
        }
        $sql[]='insert into z_organisations '.\Alptech\Wip\fun::insertValues($i);
        $_done=\Alptech\Wip\fun::sql(end($sql));
        if(!$_done){
            $a=1;
        }
        $a=1;
    }
    $sql[]="update z_organisations set code_postal=concat('0',code_postal) where length(code_postal)=4";
    \Alptech\Wip\fun::sql(end($sql));
}

if(0 and 'personnes'){
    $f="/Users/ben/Desktop/Health organisations - personnes.tsv";
    $a=is_file($f);
    $x=file_get_contents($f);
    $x=str_replace(["\r"],["\n"],$x);
    $x=preg_replace("~\n+~is","\n",$x);
    #$x=str_replace(["\toui\t","\tnon\t"],["\t1\t","\t0\t"],$x);
    $x=explode("\n",trim($x));
    $header=explode("\t",trim(array_shift($x)));
#Nom
#id,oid,lid,nom,fonction,service,telephone,email,structure
    $ok=explode(',','Nom,Fonction,Service,Téléphone,Email,Structure,Adresse organisme');
    $fields=array_intersect($header,$ok);
    #\Alptech\Wip\fun::sql('truncate table z_people');
    foreach($x as $t){
        $t=explode("\t",$t);$i=[];
        foreach($fields as $nb=>$t2){
            $t3=preg_replace('~[^a-z0-9\-_]+~','',strtolower(\Alptech\Wip\fun::stripAccents($t2,0)));
            $i[$t3]=$t[$nb];
        }
        $sql[]='insert into z_people '.\Alptech\Wip\fun::insertValues($i);
        $_done=\Alptech\Wip\fun::sql(end($sql));
        if(!$_done){
            $a=1;
        }
        $a=1;
    }
    #$sql[]="update z_organisations set code_postal=concat('0',code_postal) where length(code_postal)=4";\Alptech\Wip\fun::sql(end($sql));
}

if(1 and 'levenshtein this'){
    $res=$_explain=$people=$organisme=$structure=$adresseorganisme=$adresse=$ville=$rs=$psign=$osign=$found=[];
    $x=\Alptech\Wip\fun::sql('select id,structure,adresseorganisme from z_people');
    foreach($x as $t){
        $id=$t['id'];unset($t['id']);#$people[$id]=$t;
        $x2=_c(preg_replace('~[^a-z0-9]+~','',_u($t['structure'])));
        if(strlen($x2)>5)$psign[$id]['structure']=$x2;
        $x2=_c(preg_replace('~[^a-z0-9]+~','',_u($t['adresseorganisme'])));
        if(strlen($x2)>5)$psign[$id]['adresse']=$x2;
        /*$structure[$id]=preg_replace('~[^a-z0-9\-_]+~','',_u($t['structure']));$adresseorganisme[$id]=preg_replace('~[^a-z0-9\-_]+~','',_u($t['adresseorganisme']));*/
    }
    $x=\Alptech\Wip\fun::sql('select id,raison_sociale,libelle_routage,code_postal,adresse from z_organisations where prescripteur=1 ');
    foreach($x as $t){
        $id=$t['id'];unset($t['id']);#$organisme[$id]=$t;
        $x2=_c(preg_replace('~[^a-z0-9]+~','',_u($t['adresse'])));
        if(strlen($x2)>5)$osign[$id]['adresse']=$x2;
        $x2=_c(preg_replace('~[^a-z0-9]+~','',_u($t['libelle_routage'])));
        if(strlen($x2)>5)$osign[$id]['ville']=$x2;
        $x2=_c(preg_replace('~[^a-z0-9]+~','',_u($t['raison_sociale'])));
        if(strlen($x2)>5)$osign[$id]['rs']=$x2;
        $a=1;
    }
$start=microtime(1);
foreach($psign as $_pid=>$pcats){
    $min=1;$minexplain='';$sumLevPerCat=$lvok=$explain=[];
    echo"\n".$_pid;#pour chaque dataset de signatures
    if(isset($found[$_pid])) {
        $a = 'this person is deja ok';
        continue;
    }

    if('fatest model, mais excessivement non précis !! >> Scores plus gros mais comparent plus de données ensemblistes'){
        $pc=implode(',',$pcats);
        foreach($osign as $_oid=>$ocats){
            $sumLevPerCat[$_oid]=$lvok[$_oid]=0;$explain[$_oid]=[];#le plus long !!!
            $oc=implode(',',$ocats);
            $len=strlen($pc.$oc);
            if($len<10){
                $a=1;
                continue;
            }
            $max=strlen($oc);if(strlen($pc)>$max){$max=strlen($pc);}
            $_lv=levenshtein($pc,$oc);
            $sim=round($_lv / $max,2);
            if($vote){
                $sumLevPerCat[$_oid]+=$sim;
                $lvok[$_oid]++;
                $explain[$_oid][]=" tot : $pc <> $oc $sim ";
            }
            if($sim<$min){
                $min=$sim;
                $minexplain="=>  tot : $_oid # $pc <> $oc $sim ";
                $minId=$_oid;
            }
        }
        if(0){
            $probable[$_pid]=[$min,$minId];
            $proExplain[$_pid]=[$min,$minexplain];
            echo $minexplain;
            continue;
        }
    }

    foreach($pcats as $pcat=>$_p) {
        foreach($osign as $_oid=>$ocats){#il en existe bcp, et existent-elles
            foreach($ocats as $ocat=>$_o){
                if(strlen($_p.$_o)<10)continue;
                if ($_p == $_o) {
                    if($vote){
                        $lvok[$_oid]++;
                        $explain[$_oid][] = "$_p=$_o";
                        /*
                        $min=0;
                        $minexplain="=>$_oid:0 { $_p==$_o }";
                        $minId=$_oid;
                        */
                    }else{
                        $found[$_pid]=$_oid;
                        $res[$_pid]=[$oid,0,'=='];
                        echo"=>$_oid#(0) ($_p == $_o)";
                        $a = 'perfekt match -> personne affectée';
                        continue 4;
                    }
                }else{
                    $max=strlen($_p);if(strlen($_o)>$max)$max=strlen($_o);
                    $_lv=levenshtein($_p,$_o);
                    $sim=round($_lv / $max,2);
                    if($vote) {
                        $sumLevPerCat[$_oid] += $sim;
                        $lvok[$_oid]++;
                        $explain[$_oid][] = "$_p <> $_o $sim";
                    }
                    if($sim<$min){
                        $min=$sim;
                        $minexplain="=>$_oid:$sim { $_p <> $_o }";
                        $minId=$_oid;
                    }
                    /*
                    if($sim<$levOk){
                        $fr[$_pid]=[$_lv,$_p,$_o];
                        $found[$_pid]=$_oid;
                        echo "=>$_oid #($_p <> $_o)#$sim";
                        $similar=1;
                        continue 4;
                    }
                    */
                    $a=1;
                }
                $a=1;
            }
        }
    }

    if($vote){
        foreach($sumLevPerCat as $oid=>&$sum){
            $sum/=$lvok[$oid];
        }unset($sum);

        asort($sumLevPerCat);
        $bestCandidate=reset(array_keys($sumLevPerCat));
        $bestScore=round(reset($sumLevPerCat),2);

        if($min+0.15>$bestScore){
            $_explain[$_pid]=$explain[$bestCandidate];
            echo"=>$bestCandidate:$bestScore    #";
            echo (($bestCandidate==$minId)?'same':$minId.':'.$min);
            echo"#\t{".implode("\t",$_explain[$_pid]).'}';
            echo (($bestCandidate==$minId)?'':"\t#\tminexplain:".$minexplain);
            $less[$_pid]=$bestCandidate;
            $res[$_pid]=[$bestCandidate,$bestScore,$min,'voted'];#
            continue;
        }
    }
    $a=1;
    $res[$_pid]=[$minId,$min,'min'];
    $probable[$_pid]=$minId;
    $proExplain[$_pid]=$minexplain;
    echo $minexplain;
}
file_put_contents(__FILE__.'.res',json_encode($res));
file_put_contents(__FILE__.'.less',json_encode($less));
file_put_contents(__FILE__.'.found',json_encode($found));
file_put_contents(__FILE__.'.probable',json_encode($probable));
file_put_contents(__FILE__.'.explain',json_encode($proExplain));
file_put_contents(__FILE__.'._explain',json_encode($_explain));

$took=microtime(1)-$start;
echo $took.'/found:'. count($found).'/probable:'.count($probable);
#echo json_encode($fr);
}

echo"\n\n".count($sql)."\n\n";


function _u($x){return str_replace([' bis '],'',strtolower(\Alptech\Wip\fun::stripAccents($x,0)));}
function _c($x){
    return str_replace(['centrehospitalierde','chu','centerhopitalier','ccmp','clinique','intercommunal','intercom','centredereadaptationde','hopital','clinique','cabinet','maison','medicale','medical'],'',$x);
    return str_replace(['clic','chu','ch','sadccas','ccas','ssad','cmpr','centerhopitalier','clinea','ssr'],'',$x);
}
return;?>

phpx ~/home/ehpad/app/z/levenshtein.php

$x=Alptech\Wip\fun::sql("select nid,b.body_value from node n inner join field_data_body b on n.nid=b.entity_id where type='history' and uid=".$uid." order by nid desc");

xls to sql database
lid
https://docs.google.com/spreadsheets/d/1Q7mDi36vPPhZ1kflM3YwH0tbgntD_EkS6grYzkgiccc/edit#gid=1617785443
