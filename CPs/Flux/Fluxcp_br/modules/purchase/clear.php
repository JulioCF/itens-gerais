<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

require_once 'Flux/ItemShop.php';

if ($server->cart && $server->cart->clear()) {
	$session->setMessageData("Seu carrinho foi esvaziado.");
}
else {
	$session->setMessageData("Não foi possível esvaziar seu carrinho, talvez ele já esteja vazio.");
}

$this->redirect($this->url('purchase'));
?>