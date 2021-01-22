#!/bin/bash
#sudo nano /etc/crontab
#* * * * * ubuntu bash /home/ubuntu/SilverPricing/public_html/1mincron.bash
bs=$(dirname $0);cwd=$(cd "$bs" && pwd);cd $cwd;#current folder is this one

arg1=${1:-vide};
h=`date '+%H'`;
m=`date '+%M'`;
hm=`date '+%H%M'`;
Ymd=`date '+%Y%m%d'`;
Ymdhm=`date '+%Y%m%d-%H%M'`;
mod30=$(($m % 30));# [ $m -eq '30' ]
echo $Ymdhm>1mincron.log

#GMT : h-1#7:30 sont donc 8:30
if ([ $h -eq "7" ] && [ $m -eq '30' ]); then
    #su -c "php7.1 app.silverpricing.fr/z/alerts.php" ubuntu;
    php7.1 app.silverpricing.fr/z/alerts.php | tee app.silverpricing.fr/z/logs/alerts.$Ymdhm.log
fi;
