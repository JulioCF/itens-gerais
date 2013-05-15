#/bin/sh
#Hi my naem is Kirt and I liek anime

ulimit -Sc unlimited

while [ 1 ] ; do
if [ -f .stopserver ] ; then
echo Servidor estava offline >> servlog.txt
else
echo Reiniciado o servidor em `date +"%d-%m-%H:%M-%S"`>> startlog.txt
./map-server
fi

sleep 5

done
