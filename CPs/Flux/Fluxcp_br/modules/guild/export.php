<?php
if (!defined('FLUX_ROOT')) exit;

if (!extension_loaded('zip')) {
	throw new Flux_Error('A extensão `zip` precisa ser carregada para este recurso funcionar. Por favor consulte o manual do PHP para instruções.');
}

$this->loginRequired();

$title = 'Exportar Emblemas dos Clãs';

require_once 'Flux/EmblemExporter.php';
$exporter = new Flux_EmblemExporter($session->loginAthenaGroup);

$serverNames = $session->getAthenaServerNames();

if (count($_POST)) {
	$serverArr = $params->get('server');
	
	if ($serverArr instanceOf Flux_Config) {
		$array = $serverArr->toArray();
		
		foreach ($array as $serv) {
			$athenaServer = $session->getAthenaServer($serv);
			
			if ($athenaServer) {
				$exporter->addAthenaServer($athenaServer);
			}
		}
		
		$exporter->exportArchive();
	}
	else {
		$session->setMessageData('Você deve selecionar um servidor primeiro.');
	}
}
?>