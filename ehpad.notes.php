<?die;
/edit-residence/31459
/taxonomy/term/279/edit?destination=admin/structure/taxonomy/plan#plans gives permissions to access various things
PAGE_MES_RESIDENCES

#création de silos de compétences non transversales
g1 alternate results rows in pdf
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">


history
find . -type f -mmin -30 | grep .php | grep -v .jpg | grep -v data/cache | grep -v ~lock | grep -v .idea|  grep -v .git |  grep -v /framework/sessions/ | tee modified.list;x=`cat modified.list`;for i in $x; do git add $i -f;done;




php56.home/ehpad/app
ehpad;cd ../db;my -u a -pb silverpricing_db < silverpricing_db.sql;
cuj 'https://ehpad.home/yo' a '' 1 'sql=insert'
u=silverpricing;p=Silverpicing@wynter@2020;db=silverpricing_db;
db=silverpricing_data_db;u=silverpricing_data;p=0ah5ZZNqhVNk
echo "create database $db;CREATE USER $u@΄localhost΄ IDENTIFIED BY '$p';GRANT ALL PRIVILEGES ON *.* TO '$u'@'localhost' IDENTIFIED BY '$p';flush privileges;"
my -u a -pb silverpricing_db < ../db/silverpricing_db.sql; -- innoculation, une merde dans le cache a aboutit à une erreur 403 de non accès des menus

drushy cc all
reload;a;cuj 'https://ehpad.home/yo' a '' 1 'sql=(insert|update) ';b

GRANT ALL PRIVILEGES ON *.* TO silverpricing@'localhost' IDENTIFIED BY 'Silverpicing@wynter@2020'

Alptech\Sparks\Genius::launch()

composer require alptech/wip:dev-master
composer require phpoffice/phpspreadsheet

find . -type f -mmin -120 | grep -v .jpg | grep -v data/cache | grep -v ~lock | grep -v .idea|  grep -v .git |  grep -v /framework/sessions/ | tee modified.list
x=`cat modified.list`;for i in $x; do git add $i -f;done;

grep -r 'function .*_cron(' . --include=*.php --include=*.module |tee cronlist
job_schedule being empty

$_a=Alptech\Wip\fun::cup(['url'=>'https://www.pour-les-personnes-agees.gouv.fr/api/v1/establishment/','timeout'=>900]);#Toutes
file_put_contents(date('ymdHis').'toutesRésidences.json',$_a['contents']);

cuj "https://ehpad.home/dashboard?xhp=trace" '' '[]' 0 "has_js=1;SESS02da88e2f02ccdeaa197b0dcdf4d100a=y-i9JGchnQTmin20XM0bOx6gEK6mB942fHOWpfIqyIM;SSESS02da88e2f02ccdeaa197b0dcdf4d100a=wNz6DGQ1m45ecM2E18vwm1ERJwt490dRJmiSg215Z4o"

<?die;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
return;?>
C:\Users\ben\home\ehpad\app\sites\all\modules\residence_mgmt


obj.canvas.setViewBox(0, 0, 200, 150, true);

var canvas = document.querySelectorAll('canvas')[0]
var img    = canvas.toDataURL("image/jpeg");
//var img    = canvas.toDataURL("image/png");
var w=window.open('about:blank','image from canvas');
w.document.write("<img src='"+d+"' alt='from canvas'/>");

nécessite un récepteur
https://developer.here.com/documentation/maps/3.1.20.0/api_reference/H.util.ICapturable.html

here_library.js

~/SilverPricing/public_html/app.silverpricing.fr$ php7.1 vendor/drush/drush/drush.php cc all


var svg=document.createElement('div');svg.innerHTML='<svg xmlns="http://www.w3.org/2000/svg" style="background: rgba(0, 0, 0, 0.3);width:70px;height:80px"> <text x="0" y="75" font-size="100px" fill="red">1</text></svg>';

//1,2,3,4,5,A,B,C,D ....
//https://developer.here.com/documentation/maps/3.1.19.2/dev_guide/topics/marker-objects.html

var svg=document.createElement('div');svg.innerHTML='<svg xmlns="http://www.w3.org/2000/svg"  style="margin:-36px 0 0 -14px" width="28px" height="36px"><path d="M 19 31 C 19 32.7 16.3 34 13 34 C 9.7 34 7 32.7 7 31 C 7 29.3 9.7 28 13 28 C 16.3 28 19 29.3 19 31 Z" fill="#000" fill-opacity=".2"/><path d="M 13 0 C 9.5 0 6.3 1.3 3.8 3.8 C 1.4 7.8 0 9.4 0 12.8 C 0 16.3 1.4 19.5 3.8 21.9 L 13 31 L 22.2 21.9 C 24.6 19.5 25.9 16.3 25.9 12.8 C 25.9 9.4 24.6 6.1 22.1 3.8 C 19.7 1.3 16.5 0 13 0 Z" fill="#fff"/><path d="M 13 2.2 C 6 2.2 2.3 7.2 2.1 12.8 C 2.1 16.1 3.1 18.4 5.2 20.5 L 13 28.2 L 20.8 20.5 C 22.9 18.4 23.8 16.2 23.8 12.8 C 23.6 7.07 20 2.2 13 2.2 Z" fill="#18d"/><text x="13" y="19" font-size="12pt" font-weight="bold" text-anchor="middle" fill="#fff">1</text></svg>';
markerObject=new H.map.DomMarker({lat:"48.86",lng:"2.35"},{icon:new H.map.DomIcon(svg)});addInfoBubble(hereMap,markerObject,"hoho");

/*
#use Alptech\Wip\io;use Alptech\Wip\fun;
my silverpricing_db < silver.20201210-benSetups.sql

cuj 'https://ehpad.home/updateAllResidencesByJson' a '' 1 'ben=1'
cuj 'https://ehpad.home/updateAllRoomsUuid' a '' 1 'ben=1'
x=setups2.sql;echo "set Foreign_key_checks=0;" > $x;mysqldump -u a -pb silverpricing_db --ignore-table=distance_indexation >> $x;tar czf $x.tgz $x;rm $x;say $x;#with geocodings !!!! ;)

my silverpricing_db < setups2.sql

phpx ~/home/ehpad/app/z/tests/capretraite.php;#scrapping capretraite :: virer les caches
cuj 'https://ehpad.home/capretraite' a '' 1 'ben=1;injectionImages=2'

x=setups3.sql;echo "set Foreign_key_checks=0;" > $x;mysqldump -u a -pb silverpricing_db --extended-insert=FALSE --ignore-table=distance_indexation >> $x;tar czf $x.tgz $x;rm $x;say $x;#Images linked !!!

x=setups4.sql;echo "set Foreign_key_checks=0;" > $x;mysqldump -u a -pb silverpricing_db --extended-insert=FALSE --ignore-table=distance_indexation >> $x;tar czf $x.tgz $x;rm $x;say $x;#Images linked !!!N

ls /home/ubuntu/SilverPricing/public_html/app.silverpricing.fr/sites/default/files/ehpad | wc -l

tar xf setups3.sql.tgz;mysql -u root -ptoor --max_allowed_packet=999M --force --wait --reconnect silverpricing_db < setups3.sql | tee mysql.log;# force executing rest of queries

$td/mysqlSplit.sh setups3.sql
cat $(ls -t) > joined.sql

grep -n 'for table `distance_indexation`' setups3.sql
grep 'for table `distance_indexation`' setup3.sql

1002



tar xf setups4.sql.tgz;mysql -u root -ptoor --max_allowed_packet=999M --force --wait --reconnect silverpricing_db < setups4.sql | tee mysql.log;# force executing rest of queries
mysql -u root -ptoor -e "show global variables"
*/

php cli access drupal module function

