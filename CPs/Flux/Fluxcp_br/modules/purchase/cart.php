<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

if ($server->cart->isEmpty()) {
	$session->setMessageData('Seu carrinho está vazio.');
	$this->redirect($this->url('purchase'));
}

$title = 'Carrinho de Compras';

require_once 'Flux/ItemShop.php';
$items = $server->cart->getCartItems();
?>