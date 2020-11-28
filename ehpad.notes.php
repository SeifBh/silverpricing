<?die;
php56.home/ehpad/app
cd $ehpad/db
u=silverpricing;p=Silverpicing@wynter@2020;db=silverpricing_db;
db=silverpricing_data_db;u=silverpricing_data;p=0ah5ZZNqhVNk
echo "create database $db;CREATE USER $u@΄localhost΄ IDENTIFIED BY '$p';GRANT ALL PRIVILEGES ON *.* TO '$u'@'localhost' IDENTIFIED BY '$p';flush privileges;"
my -u a -pb silverpricing_db < silverpricing_db.sql; -- innoculation, une merde dans le cache a aboutit à une erreur 403 de non accès des menus

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
