<?php
if (!defined('FLUX_ROOT')) exit; 

$this->loginRequired();

$title = 'Modificar Item da Loja';

require_once 'Flux/TemporaryTable.php';
require_once 'Flux/ItemShop.php';

$stackable   = false;
$shopItemID  = $params->get('id');
$shop        = new Flux_ItemShop($server);
$categories  = Flux::config('ShopCategories')->toArray();
$item        = $shop->getItem($shopItemID);

if ($item) {
	if($server->isRenewal) {
		$fromTables = array("{$server->charMapDatabase}.item_db_re", "{$server->charMapDatabase}.item_db2");
	} else {
		$fromTables = array("{$server->charMapDatabase}.item_db", "{$server->charMapDatabase}.item_db2");
	}
	$tableName = "{$server->charMapDatabase}.items";
	$tempTable = new Flux_TemporaryTable($server->connection, $tableName, $fromTables);
	$shopTable = Flux::config('FluxTables.ItemShopTable');

	$col = "id AS item_id, name_japanese AS item_name, type";
	$sql = "SELECT $col FROM $tableName WHERE items.id = ?";
	$sth = $server->connection->getStatement($sql);

	$sth->execute(array($item->shop_item_nameid));
	$originalItem = $sth->fetch();

	if ($originalItem && Flux::isStackableItemType($originalItem->type)) {
		$stackable = true;
	}
	
	if (count($_POST)) {
		$maxCost     = (int)Flux::config('ItemShopMaxCost');
		$maxQty      = (int)Flux::config('ItemShopMaxQuantity');
		$category    = $params->get('category');
		$cost        = (int)$params->get('cost');
		$quantity    = (int)$params->get('qty');
		$info        = trim($params->get('info'));
		$image       = $files->get('image');
		$useExisting = (int)$params->get('use_existing');

		if (!$cost) {
			$errorMessage = 'Você deve colocar um custo de crédito maior que zero.';
		}
		elseif ($cost > $maxCost) {
			$errorMessage = "O custo do item não pode exceder $maxCost.";
		}
		elseif (!$quantity) {
			$errorMessage = 'Você deve colocar uma quantidade maior que zero.';
		}
		elseif ($quantity > 1 && !$stackable) {
			$errorMessage = 'Este item não é acumulável. Quantidade deve ser 1.';
		}
		elseif ($quantity > $maxQty) {
			$errorMessage = "A quantidade máxima não pode exceder $maxQty.";
		}
		elseif (!$info) {
			$errorMessage = 'Você deve colocar alguma informação sobre o item.';
		}
		else {
			if ($shop->edit($shopItemID, $category, $cost, $quantity, $info, $useExisting)) {
				if ($image && $image->get('size') && !$shop->uploadShopItemImage($shopItemID, $image)) {
					$errorMessage = 'Falha ao fazer upload da imagem.';
				}
				else {
					$session->setMessageData('Item foi modificado com sucesso.');
					$this->redirect($this->url('purchase'));
				}
			}
			else {
				$errorMessage = 'Falha ao modificar item.';
			}
		}
	}
	
	if (empty($category)) {
		$category = $item->shop_item_category;
	}
	if (empty($cost)) {
		$cost = $item->shop_item_cost;
	}
	if (empty($quantity)) {
		$quantity = $item->shop_item_qty;
	}
	if (empty($info)) {
		$info = $item->shop_item_info;
	}
}

if (!$stackable) {
	$params->set('qty', 1);
}
?>