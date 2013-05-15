#/bin/sh
#Hi my naem is Kirt and I liek anime

ulimit -Sc unlimited

while [ 3 ] ; do
if [ -f .stopserver3 ] ; then
echo Servidor estava offline >> servlog.txt
else
echo Reiniciado o servidor em `date +"%m-%d-%H:%M-%S"`>> startlog.txt
./char-server
fi

sleep 5

done
