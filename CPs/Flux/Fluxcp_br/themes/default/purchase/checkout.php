<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Finalizar</h2>
<p>O processo de finalização é simples, e quando estiver pronto você estará apto a resgatar seus itens num jogo através do nosso <span class="keyword">NPC de Recompensa</span>.</p>

<h3>Informação da Compra</h3>
<p class="cart-total-text">Seu subtotal atual é <span class="cart-sub-total"><?php echo number_format($total=$server->cart->getTotal()) ?></span> crédito(s).</p>
<p class="checkout-info-text">Seu saldo remanescente após essa compra será de <span class="remaining-balance"><?php echo number_format($session->account->balance - $total) ?></span> crédito(s).</p>
<p>Depois de rever as informações de item abaixo, você pode proceder com a sua compra clicando no botão "Comprar Itens".</p>
<p class="important">Nota: Este itens são para a troca APENAS no <span class="server-name"><?php echo htmlspecialchars($server->serverName) ?></span>.</p>
<p>
	<form action="<?php echo $this->url ?>" method="post">
		<?php echo $this->moduleActionFormInputs($params->get('module'), 'checkout') ?>
		<input type="hidden" name="process" value="1" />
		<button type="submit" onclick="return confirm('Você deseja continuar com a compra desse(s) item(s)?')">
			<strong>Comprar Itens</strong>
		</button>
	</form>
</p>

<h3>Itens Atuais no Seu Carrinho:</h3>
<p class="cart-info-text">Você possui <span class="cart-item-count"><?php echo number_format(count($items)) ?></span> item(s) no seu carrinho.</p>
<table class="vertical-table cart">
	<?php foreach ($items as $item): ?>
	<tr>
		<td>
			<h4>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($item->shop_item_nameid, $item->shop_item_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($item->shop_item_nameid) ?>
				<?php endif ?>
			</h4>
			<?php if ($item->shop_item_qty > 1): ?>
			<p class="shop-item-qty">Quantidade: <span class="qty"><?php echo number_format($item->shop_item_qty) ?></span></p>
			<?php endif ?>
			<p class="shop-item-cost"><span class="cost"><?php echo number_format($item->shop_item_cost) ?></span> créditos</p>
			<p><?php echo nl2br(htmlspecialchars($item->shop_item_info)) ?></p>
		</td>
	</tr>
	<?php endforeach ?>
</table>