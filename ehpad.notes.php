php56.home/ehpad/app
u=silverpricing;p=Silverpicing@wynter@2020;db=silverpricing_db;
my -u a -pb -e "create database $db;CREATE USER $u@΄%΄ IDENTIFIED BY '$p';GRANT ALL PRIVILEGES ON *.* TO '$u'@'%' IDENTIFIED BY '$p';flush privileges;"
my -u a -pb -e "CREATE USER $u@΄localhost΄ IDENTIFIED BY '$p';GRANT ALL PRIVILEGES ON *.* TO '$u'@'localhost' IDENTIFIED BY '$p';flush privileges;"
my -u a -pb silverpricing_db < silverpricing_db.sql; -- innoculation

GRANT ALL PRIVILEGES ON *.* TO silverpricing@'localhost' IDENTIFIED BY 'Silverpicing@wynter@2020'
