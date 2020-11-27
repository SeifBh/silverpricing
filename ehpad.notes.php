<?die;
php56.home/ehpad/app
u=silverpricing;p=Silverpicing@wynter@2020;db=silverpricing_db;
db=silverpricing_data_db;u=silverpricing_data;p=0ah5ZZNqhVNk
echo "create database $db;CREATE USER $u@΄localhost΄ IDENTIFIED BY '$p';GRANT ALL PRIVILEGES ON *.* TO '$u'@'localhost' IDENTIFIED BY '$p';flush privileges;"
my -u a -pb silverpricing_db < silverpricing_db.sql; -- innoculation

GRANT ALL PRIVILEGES ON *.* TO silverpricing@'localhost' IDENTIFIED BY 'Silverpicing@wynter@2020'

composer require alptech/wip:dev-master
composer require phpoffice/phpspreadsheet

    find . -type f -mmin -120 | grep -v .jpg | grep -v data/cache | grep -v ~lock | grep -v .idea|  grep -v .git |  grep -v /framework/sessions/ | tee modified.list
    x=`cat modified.list`;for i in $x; do git add $i -f;done;
