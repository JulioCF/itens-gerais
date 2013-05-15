<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Recompensas Pendentes</h2>
<?php if ($items): ?>
<p>Você possui <?php echo number_format($total) ?> recompensa(s) de item(s) pentende(s).</p>
<table class="vertical-table">
	<tr>
		<th>Nome do Item</th>
		<th>Quantidade</th>
		<th>Custo</th>
		<th>Saldo (Antes)</th>
		<th>Saldo (Depois)</th>
		<th>Data da Compra</th>
	</tr>
	<?php foreach ($items as $item): ?>
	<tr>
		<td align="right">
			<?php if ($item->item_name): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($item->nameid, $item->item_name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($item->nameid) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable">Desconhecido</span>
			<?php endif ?>
		</td>
		<td><?php echo number_format($item->quantity) ?></td>
		<td><?php echo number_format($item->cost) ?></td>
		<td><?php echo number_format($item->credits_before) ?></td>
		<td><?php echo number_format($item->credits_after) ?></td>
		
		<td><?php echo $this->formatDateTime($item->purchase_date) ?></td>
	</tr>
	<?php endforeach ?>
</table>
<?php else: ?>
<p>Você não possui recompensas pendentes.
	Se você quiser comprar alguma coisa, vá a nossa <a href="<?php echo $this->url('purchase') ?>">loja</a>.</p>
<?php endif ?>