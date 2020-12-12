<?php
/*
phpx ~/home/ehpad/app/z/tests/capretraite.php
SCRAP FULL PAGE = Conserver
Finess Images
*/
namespace Alptech\Wip;#die;#todo:rename to ajax
chdir(__DIR__);
require_once '../../autoload.php';

if(0){
    $x=io::fgcj('capretraite.json');
    $a=1;
    return;
}








$json=$processed=[];

$hn='https://www.capretraite.fr';
$url=$hn.'/maisons-de-retraite/';
$cf=str_replace(['https','http','://','www.'],'',$url);
$cf='../curlcache/capretraite/'.preg_replace('~[^a-z0-9_\.\-]|_+~','_',$cf).'.html';

if(is_file($cf)){$contents=io::fgc($cf);}else{
$opt = [/*10015 => json_encode($json),10036 => 'POST',10023 => $headers,*/10002 => $url, 19913 => 1, 42 => 1, 45 => false, 81 => false, 64 => false,/*ssl verify*/13 => 30, 78 => 30, 52 => 1,2 => 1, 41 => 1, 58 => 1,  /*?? Follow Return Headers*/];
$_a=fun::cuo($opt);
if($_a["info"]["http_code"]!=200 or $_a['error']){
    $err=1;
}else{
    $_written=io::fpc($cf,$_a['contents']);
    $contents=$_a['contents'];unset($_a);}

}#end curl

preg_match_all('~href="(/maisons-de-retraite/[^"/]+/)"~i',$contents,$links);
while($link2dep = array_shift($links[1])){#considère les nouveaux injectés entre temps
#foreach($links[1] as $link2dep){
    $url=$hn.$link2dep;

    if(in_array($url,$processed))continue;$processed[]=$url;
    $cf=str_replace(['https','http','://','www.'],'',$url);
    $cf='../curlcache/capretraite/'.preg_replace('~[^a-z0-9_\.\-]|_+~','_',$cf).'.html';
    if(is_file($cf)){$contents=io::fgc($cf);}else{
    $opt = [/*10015 => json_encode($json),10036 => 'POST',10023 => $headers,*/10002 => $url, 19913 => 1, 42 => 1, 45 => false, 81 => false, 64 => false,/*ssl verify*/13 => 30, 78 => 30, 52 => 1,2 => 1, 41 => 1, 58 => 1,  /*?? Follow Return Headers*/];
    $_a=fun::cuo($opt);
    if($_a['info']['http_code']!=200 or $_a['error']){
        $err=1;
    }else{io::fpc($cf,$_a['contents']);$contents=$_a['contents'];unset($_a);}
    }

    preg_match_all("~".$link2dep."\?page=[0-9]+~",$contents,$pages);
    if($pages[0]){#ain= absence, allier : 03 : oui
        $pages=array_unique($pages[0]);
        $links[1]=array_merge($links[1],$pages);
        $a=1;#$links[1] ++++
    }
#<a class="link-box" href="/maisons-de-retraite/yvelines-78/aubergenville/les-jardins-medicis-aubergenville/">
    $link2dep1=preg_replace('~\?page=.*~is','',$link2dep);
    preg_match_all('~<a class="link-box" href="('.$link2dep1.'[^"\']+)"><span></span></a>~',$contents,$urlsResidences);
    if(stripos($contents,'yvelines-78/aubergenville/les-jardins-medicis-aubergenville')){
        $a=1;
    }

    foreach($urlsResidences[1] as $urlResidence){
        $url=$hn.$urlResidence;
        if(in_array($url,$processed))continue;$processed[]=$url;

        if(stripos($urlResidence,'yvelines-78/aubergenville/les-jardins-medicis-aubergenville')){
            $a=1;
        }

        $cf=str_replace(['https','http','://','www.'],'',$url);
        $cf='../curlcache/capretraite/'.preg_replace('~[^a-z0-9_\.\-]|_+~','_',$cf).'.html';
        if(is_file($cf)){$contents=io::fgc($cf);}else{
            $opt = [/*10015 => json_encode($json),10036 => 'POST',10023 => $headers,*/10002 => $url, 19913 => 1, 42 => 1, 45 => false, 81 => false, 64 => false,/*ssl verify*/13 => 30, 78 => 30, 52 => 1,2 => 1, 41 => 1, 58 => 1,  /*?? Follow Return Headers*/];$_a=fun::cuo($opt);if($_a['info']['http_code']!=200 or $_a['error']){
                $err=1;
            }else{io::fpc($cf,$_a['contents']);$contents=$_a['contents'];unset($_a);}
        }
        preg_match('~"FINESS","value":"([^"]+)"~is',$contents,$finess);#[a-z0-9]+
        if(!$finess[1]){
            $err=1;
            continue;
        }
        preg_match_all('~<script type=\'application/ld+json\'>(.*)</script>~i',$contents,$jsondata);
        preg_match('~<figure id="carouselResidence".*</figure>~is',$contents,$figure);
        if($figure and $figure[0]){#phpx ~/home/ehpad/app/z/tests/capretraite.php
            $nbFound=preg_match_all('~src="(https://res.cloudinary.com/capretraite/image/upload/[^"]+/residences_new/[^"]+)"~i',$figure[0],$images);#46 => 20 => 8
        } elseif(0){preg_match_all('~src="(https://res.cloudinary.com/capretraite/image/upload/[^"]+/residences_new/[^"]+)"~i',$contents,$images);}#46 => 20 => 8
        $a=1;
        $json[$finess[1]]=compact('images','jsondata');
    }
};

$_written=io::FPCJ('../capretraite.json',$json);
$a=1;
$b=1;
return;?>
fun::cme($opts,$callback);#rajoute les callbacks par dessus


1) Get :: capretraite.fr/maisons-de-retraite/
