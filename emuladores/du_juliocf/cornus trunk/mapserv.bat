@echo off
rem Writen by Jbain
:end
map-server.exe
echo .
echo .
echo Erro Grave no Servidor de Mapas! Reiniciando em 15 segundos! Pressione 'Ctrl + C' para cancelar!
PING -n 15 127.0.0.1 >nul
goto end