<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Items</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Procurar...</a></p>
<form class="search-form" method="get">
	<?php echo $this->moduleActionFormInputs($params->get('module')) ?>
	<p>
		<label for="item_id">ID do Item:</label>
		<input type="text" name="item_id" id="item_id" value="<?php echo htmlspecialchars($params->get('item_id')) ?>" />
		...
		<label for="name">Nome:</label>
		<input type="text" name="name" id="name" value="<?php echo htmlspecialchars($params->get('name')) ?>" />
		...
		<label for="type">Tipo:</label>
		<select name="type">
			<option value="-1"<?php if (($type=$params->get('type')) === '-1') echo ' selected="selected"' ?>>
				Qualquer
			</option>
			<?php foreach (Flux::config('ItemTypes')->toArray() as $typeId => $typeName): ?>
				<option value="<?php echo $typeId ?>"<?php if (($type=$params->get('type')) === strval($typeId)) echo ' selected="selected"' ?>>
					<?php echo htmlspecialchars($typeName) ?>
				</option>
				<?php $itemTypes2 = Flux::config('ItemTypes2')->toArray() ?>
				<?php if (array_key_exists($typeId, $itemTypes2)): ?>
					<?php foreach ($itemTypes2[$typeId] as $typeId2 => $typeName2): ?>
					<option value="<?php echo $typeId ?>-<?php echo $typeId2 ?>"<?php if (($type=$params->get('type')) === ($typeId . '-' . $typeId2)) echo ' selected="selected"' ?>>
						<?php echo htmlspecialchars($typeName . ' - ' . $typeName2) ?>
					</option>
					<?php endforeach ?>
				<?php endif ?>
			<?php endforeach ?>
		</select>
		...
		<label for="equip_loc">Equipado em:</label>
		<select name="equip_loc">
			<option value="-1"<?php if (($equip_loc=$params->get('equip_loc')) === '-1') echo ' selected="selected"' ?>>
				Qualquer
			</option>
			<?php foreach (Flux::config('EquipLocationCombinations')->toArray() as $locId => $locName): ?>
				<option value="<?php echo $locId ?>"<?php if (($equip_loc=$params->get('equip_loc')) === strval($locId)) echo ' selected="selected"' ?>>
					<?php echo htmlspecialchars($locName) ?>
				</option>
			<?php endforeach ?>
		</select>
	</p>
	<p>
		<label for="npc_buy">Preço de Compra de NPC:</label>
		<select name="npc_buy_op">
			<option value="eq"<?php if (($npc_buy_op=$params->get('npc_buy_op')) == 'eq') echo ' selected="selected"' ?>>é igual a</option>
			<option value="gt"<?php if ($npc_buy_op == 'gt') echo ' selected="selected"' ?>>é maior que</option>
			<option value="lt"<?php if ($npc_buy_op == 'lt') echo ' selected="selected"' ?>>é menor que</option>
		</select>
		<input type="text" name="npc_buy" id="npc_buy" value="<?php echo htmlspecialchars($params->get('npc_buy')) ?>" />
		...
		<label for="npc_sell">Preço de Venda de NPC:</label>
		<select name="npc_sell_op">
			<option value="eq"<?php if (($npc_sell_op=$params->get('npc_sell_op')) == 'eq') echo ' selected="selected"' ?>>é igual a</option>
			<option value="gt"<?php if ($npc_sell_op == 'gt') echo ' selected="selected"' ?>>é maior que</option>
			<option value="lt"<?php if ($npc_sell_op == 'lt') echo ' selected="selected"' ?>>é menor que</option>
		</select>
		<input type="text" name="npc_sell" id="npc_sell" value="<?php echo htmlspecialchars($params->get('npc_sell')) ?>" />
		...
		<label for="weight">Peso:</label>
		<select name="weight_op">
			<option value="eq"<?php if (($weight_op=$params->get('weight_op')) == 'eq') echo ' selected="selected"' ?>>é igual a</option>
			<option value="gt"<?php if ($weight_op == 'gt') echo ' selected="selected"' ?>>é maior que</option>
			<option value="lt"<?php if ($weight_op == 'lt') echo ' selected="selected"' ?>>é menor que</option>
		</select>
		<input type="text" name="weight" id="weight" value="<?php echo htmlspecialchars($params->get('weight')) ?>" />
	</p>
	<p>
		<label for="range">Alcance:</label>
		<select name="range_op">
			<option value="eq"<?php if (($range_op=$params->get('range_op')) == 'eq') echo ' selected="selected"' ?>>é igual a</option>
			<option value="gt"<?php if ($range_op == 'gt') echo ' selected="selected"' ?>>é maior que</option>
			<option value="lt"<?php if ($range_op == 'lt') echo ' selected="selected"' ?>>é menor que</option>
		</select>
		<input type="text" name="range" id="range" value="<?php echo htmlspecialchars($params->get('range')) ?>" />
	   ...
		<label for="slots">Slots:</label>
		<select name="slots_op">
			<option value="eq"<?php if (($slots_op=$params->get('slots_op')) == 'eq') echo ' selected="selected"' ?>>é igual a</option>
			<option value="gt"<?php if ($slots_op == 'gt') echo ' selected="selected"' ?>>é maior que</option>
			<option value="lt"<?php if ($slots_op == 'lt') echo ' selected="selected"' ?>>é menor que</option>
		</select>
		<input type="text" name="slots" id="slots" value="<?php echo htmlspecialchars($params->get('slots')) ?>" />
		...
		<label for="defense">Defesa:</label>
		<select name="defense_op">
			<option value="eq"<?php if (($defense_op=$params->get('defense_op')) == 'eq') echo ' selected="selected"' ?>>é igual a</option>
			<option value="gt"<?php if ($defense_op == 'gt') echo ' selected="selected"' ?>>é maior que</option>
			<option value="lt"<?php if ($defense_op == 'lt') echo ' selected="selected"' ?>>é menor que</option>
		</select>
		<input type="text" name="defense" id="defense" value="<?php echo htmlspecialchars($params->get('defense')) ?>" />
	</p>
	<p>
		<?php if(!$server->isRenewal): ?>
		<label for="attack">Ataque:</label>
		<select name="attack_op">
			<option value="eq"<?php if (($attack_op=$params->get('attack_op')) == 'eq') echo ' selected="selected"' ?>>é igual a</option>
			<option value="gt"<?php if ($attack_op == 'gt') echo ' selected="selected"' ?>>é maior que</option>
			<option value="lt"<?php if ($attack_op == 'lt') echo ' selected="selected"' ?>>é menor que</option>
		</select>
		<input type="text" name="attack" id="attack" value="<?php echo htmlspecialchars($params->get('attack')) ?>" />
		...
		<?php endif ?>
		<label for="refineable">Refinável:</label>
		<select name="refineable" id="refineable">
			<option value=""<?php if (!($refineable=$params->get('refineable'))) echo ' selected="selected"' ?>>Tudo</option>
			<option value="yes"<?php if ($refineable == 'yes') echo ' selected="selected"' ?>>Sim</option>
			<option value="no"<?php if ($refineable == 'no') echo ' selected="selected"' ?>>Não</option>
		</select>
		...
		<label for="for_sale">A venda:</label>
		<select name="for_sale" id="for_sale">
			<option value=""<?php if (!($for_sale=$params->get('for_sale'))) echo ' selected="selected"' ?>>Tudo</option>
			<option value="yes"<?php if ($for_sale == 'yes') echo ' selected="selected"' ?>>Sim</option>
			<option value="no"<?php if ($for_sale == 'no') echo ' selected="selected"' ?>>Não</option>
		</select>
		...
		<label for="custom">Personalizado:</label>
		<select name="custom" id="custom">
			<option value=""<?php if (!($custom=$params->get('custom'))) echo ' selected="selected"' ?>>Tudo</option>
			<option value="yes"<?php if ($custom == 'yes') echo ' selected="selected"' ?>>Sim</option>
			<option value="no"<?php if ($custom == 'no') echo ' selected="selected"' ?>>Não</option>
		</select>
		...
		<input type="submit" value="Procurar" />
		<input type="button" value="Resetar" onclick="reload()" />
	</p>
</form>
<?php if ($items): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('item_id', 'ID do Item') ?></th>
		<th colspan="2"><?php echo $paginator->sortableColumn('name', 'Nome') ?></th>
		<th>Tipo</th>
		<th>Equipa em</th>
		<th><?php echo $paginator->sortableColumn('price_buy', 'Preço de Compra de NPC') ?></th>
		<th><?php echo $paginator->sortableColumn('price_sell', 'Preço de Venda de NPC') ?></th>
		<th><?php echo $paginator->sortableColumn('weight', 'Peso') ?></th>
		<th><?php echo $paginator->sortableColumn('attack', 'Ataque') ?></th>
		<?php if($server->isRenewal): ?>
		<th><?php echo $paginator->sortableColumn('matk', 'MATK') ?></th>
		<?php endif ?>
		<th><?php echo $paginator->sortableColumn('defense', 'Defesa') ?></th>
		<th><?php echo $paginator->sortableColumn('range', 'Alcance') ?></th>
		<th><?php echo $paginator->sortableColumn('slots', 'Slots') ?></th>
		<th><?php echo $paginator->sortableColumn('refineable', 'Refinável') ?></th>
		<th><?php echo $paginator->sortableColumn('cost', 'A venda') ?></th>
		<th><?php echo $paginator->sortableColumn('origin_table', 'Custom') ?></th>
	</tr>
	<?php foreach ($items as $item): ?>
	<tr>
		<td align="right">
			<?php if ($auth->actionAllowed('item', 'view')): ?>
				<?php echo $this->linkToItem($item->item_id, $item->item_id) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($item->item_id) ?>
			<?php endif ?>
		</td>
		<?php if ($icon=$this->iconImage($item->item_id)): ?>
			<td width="24"><img src="<?php echo htmlspecialchars($icon) ?>?nocache=<?php echo rand() ?>" /></td>
			<td><?php echo htmlspecialchars($item->name) ?></td>
		<?php else: ?>
			<td colspan="2"><?php echo htmlspecialchars($item->name) ?></td>
		<?php endif ?>
		<td>
			<?php if ($type=$this->itemTypeText($item->type, $item->view)): ?>
				<?php echo htmlspecialchars($type) ?>
			<?php else: ?>
				<span class="not-applicable">Desconhecido<?php echo " (".$item->type.")" ?></span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($loc=$this->equipLocationCombinationText($item->equip_locations)): ?>
				<?php echo htmlspecialchars($loc) ?>
			<?php else: ?>
				<span class="not-applicable">Desconhecido<?php echo " (".$item->equip_locations.")" ?></span>
			<?php endif ?>
		</td>
		<td><?php echo number_format((int)$item->price_buy) ?></td>
		<td><?php echo number_format((int)$item->price_sell) ?></td>
		<td><?php echo round($item->weight, 1) ?></td>
		<?php if($server->isRenewal && ($item=$this->itemFieldExplode($item, 'attack', ':', array('atk','matk')))): ?>
			<td><?php echo number_format((int)$item->atk) ?></td>
			<td><?php echo number_format((int)$item->matk) ?></td>
		<?php else: ?>
			<td><?php echo number_format((int)$item->attack) ?></td>
		<?php endif ?>
		<td><?php echo number_format((int)$item->defense) ?></td>
		<td><?php echo number_format((int)$item->range) ?></td>
		<td><?php echo number_format((int)$item->slots) ?></td>
		<td>
			<?php if ($item->refineable): ?>
				<span class="refineable yes">Sim</span>
			<?php else: ?>
				<span class="refineable no">Não</span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($item->cost): ?>
				<span class="for-sale yes"><a href="<?php echo $this->url('purchase') ?>" title="Go to Item Shop">Sim</a></span>
			<?php else: ?>
				<span class="for-sale no">Não</span>
			<?php endif ?>
		</td>
		<td>
			<?php if (preg_match('/item_db2$/', $item->origin_table)): ?>
				Sim
			<?php else: ?>
				Não
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Nenhum item encontrado. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>