<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Ver Carrinho</h2>
<p class="cart-info-text">Você possui <span class="cart-item-count"><?php echo number_format(count($items)) ?></span> item(s) no seu carrinho.</p>
<p class="cart-total-text">Seu subtotal atual é <span class="cart-sub-total"><?php echo number_format($total=$server->cart->getTotal()) ?></span> crédito(s).</p>
<br />
<p class="checkout-text"><a href="<?php echo $this->url('purchase', 'checkout') ?>">Finalizar</a></p>
<form action="<?php echo $this->url($params->get('module'), 'remove') ?>" method="post">
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<table class="vertical-table cart">
		<?php foreach ($items as $num => $item): ?>
		<tr>
			<td>
				<h4>
					<label>
						<input type="checkbox" name="num[]" value="<?php echo $num ?>" />
						<?php echo htmlspecialchars($item->shop_item_name) ?>
					</label>
				</h4>
				<?php if ($item->shop_item_qty > 1): ?>
				<p class="shop-item-qty">Quantidade: <span class="qty"><?php echo number_format($item->shop_item_qty) ?></span></p>
				<?php endif ?>
				<p class="shop-item-cost"><span class="cost"><?php echo number_format($item->shop_item_cost) ?></span> créditos</p>
				<p class="shop-item-action">
					<?php if ($auth->actionAllowed('item', 'view')): ?>
						<?php echo $this->linkToItem($item->shop_item_nameid, 'Ver Item') ?> /
					<?php endif ?>
					<a href="<?php echo $this->url('purchase', 'remove', array('num' => $num)) ?>">Remover do Carrinho</a> /
					<a href="<?php echo $this->url('purchase', 'add', array('id' => $item->shop_item_id, 'cart' => true)) ?>">Adicionar outro item ao carrinho</a>
				</p>
				<p><?php echo nl2br(htmlspecialchars($item->shop_item_info)) ?></p>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<p class="remove-from-cart">
		<button onclick="window.location.href='<?php echo $this->url('purchase', 'clear') ?>'">Limpar o Carrinho</button>
		<input type="submit" value="Remover Itens Selecionados do Carrinho" />
	</p>
</form>