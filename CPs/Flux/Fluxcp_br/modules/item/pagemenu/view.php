<?php
$pageMenu = array();
if ($auth->actionAllowed('item', 'edit')) {
	$pageMenu['Modificar Item'] = $this->url('item', 'edit', array('id' => $item->item_id));
}
if ($auth->actionAllowed('item', 'copy')) {
	$pageMenu['Duplicar Item'] = $this->url('item', 'copy', array('id' => $item->item_id));
}
if ($auth->actionAllowed('itemshop', 'add') && $auth->allowedToAddShopItem) {
	if ($item->cost) {
		$pageMenu['Adicionar Item a Loja de Itens (Novamente)'] = $this->url('itemshop', 'add', array('id' => $item->item_id));
	}
	else {
		$pageMenu['Adicionar Item a Loja de Itens'] = $this->url('itemshop', 'add', array('id' => $item->item_id));
	}
}
return $pageMenu;
?>