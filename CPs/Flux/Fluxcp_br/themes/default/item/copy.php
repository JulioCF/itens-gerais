<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Duplicar Item</h2>
<?php if ($item): ?>
<?php if (!empty($errorMessage)): ?>
<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php else: ?>
<p>Aqui você pode copiar um item no <em>item_db2</em> com um novo ID.</p>
<?php endif ?>
<form action="<?php echo $this->urlWithQs ?>" method="post" class="generic-form">
	<input type="hidden" name="copyitem" value="1" />
	<table class="generic-form-table">
		<tr>
			<th><label>Nome do Item (ID do Item)</label></th>
			<td>
				<p>
					<strong><?php echo htmlspecialchars($item->name_japanese) ?></strong>
					<?php if ($auth->actionAllowed('item', 'view')): ?>
						(<a href="<?php echo $this->url('item', 'view', array('id' => $itemID)) ?>"><?php echo htmlspecialchars($itemID) ?></a>)
					<?php else: ?>
						(<?php echo htmlspecialchars($itemID) ?>)
					<?php endif ?>
				</p>
				
			</td>
			<td></td>
		</tr>
		<tr>
			<th><label for="new_item_id">Criar ID do Item</label></th>
			<td><input type="text" name="new_item_id" id="new_item_id" value="" /></td>
			<td><p>Especificar o novo ID que você quer para o item duplicado.</p></td>
		</tr>
		<tr>
			<td colspan="2" align="right"><input type="submit" value="Duplicate Item" /></td>
			<td></td>
		</tr>
	</table>
</form>
<?php else: ?>
<p>Nenhum item encontrado. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>