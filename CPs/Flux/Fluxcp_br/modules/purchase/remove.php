<?php
if (!defined('FLUX_ROOT')) exit;

$this->loginRequired();

$num = $params->get('num');
if (!is_null($num)) {
	if ($num instanceOf Flux_Config) {
		$num = $num->toArray();
	}
	
	$nRemoved = $server->cart->deleteByItemNum($num);
	if ($nRemoved) {
		if (!$server->cart->isEmpty()) {
			$session->setMessageData("Removido(s) $nRemoved item(s) do seu carrinho.");
			$this->redirect($this->url('purchase', 'cart'));
		}
		else {
			$session->setMessageData("Removido(s) $nRemoved item(s) do seu carrinho. Seu carrinho agora está vazio.");
		}
	}
	else {
		$session->setMessageData("Não há itens para remover do seu carrinho.");
	}
	
	$this->redirect($this->url('purchase'));
}

$session->setMessageData('Nenhum item foi removido do seu carrinho porque nenhum item foi selecionado.');
$this->redirect($this->url('purchase', 'cart'));
?>