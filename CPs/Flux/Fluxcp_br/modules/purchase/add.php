<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired('Faça login para adicionar os itens ao seu carrinho.');

require_once 'Flux/ItemShop.php';

$id   = $params->get('id');
$shop = new Flux_ItemShop($server);
$item = $shop->getItem($id);

if ($item) {
	$server->cart->add($item);
	$session->setMessageData("{$item->shop_item_name} foi adicionado ao seu carrinho.");
}
else {
	$session->setMessageData("Não foi possível adicionar o item ao seu carrinho.");
}

$action = $params->get('cart') ? 'cart' : 'index';
$this->redirect($this->url('purchase', $action));
?>