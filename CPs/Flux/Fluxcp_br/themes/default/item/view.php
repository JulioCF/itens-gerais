<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Vendo Item</h2>
<?php if ($item): ?>
<?php $icon = $this->iconImage($item->item_id); ?>
<h3>
	<?php if ($icon): ?><img src="<?php echo $icon ?>" /><?php endif ?>
	#<?php echo htmlspecialchars($item->item_id) ?>: <?php echo htmlspecialchars($item->name) ?>
</h3>
<table class="vertical-table">
	<tr>
		<th>ID do Item</th>
		<td><?php echo htmlspecialchars($item->item_id) ?></td>
		<?php if ($image=$this->itemImage($item->item_id)): ?>
		<td rowspan="8" style="width: 150px; text-align: center; vertical-alignment: middle">
			<img src="<?php echo $image ?>" />
		</td>
		<?php endif ?>
		<th>A Venda</th>
		<td>
			<?php if ($item->cost): ?>
				<span class="for-sale yes">
					Sim
				</span>
			<?php else: ?>
				<span class="for-sale no">
					Não
				</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Identificador</th>
		<td><?php echo htmlspecialchars($item->identifier) ?></td>
		<th>Preço em Créditos</th>
		<td>
			<?php if ($item->cost): ?>
				<?php echo number_format((int)$item->cost) ?>
			<?php else: ?>
				<span class="not-applicable">Não está a venda</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Nome</th>
		<td><?php echo htmlspecialchars($item->name) ?></td>
		<th>Tipo</th>
		<td><?php echo $this->itemTypeText($item->type, $item->view) ?></td>
	</tr>
	<tr>
		<th>Preço de Compra em NPC</th>
		<td><?php echo number_format((int)$item->price_buy) ?></td>
		<th>Peso</th>
		<td><?php echo round($item->weight, 1) ?></td>
	</tr>
	<tr>
		<th>Preço de Venda em NPC</th>
		<td>
			<?php if (is_null($item->price_sell) && $item->price_buy): ?>
				<?php echo number_format(floor($item->price_buy / 2)) ?>
			<?php else: ?>
				<?php echo number_format((int)$item->price_sell) ?>
			<?php endif ?>
		</td>
		<th>Level da Arma </th>
		<td><?php echo number_format((int)$item->weapon_level) ?></td>
	</tr>
	<tr>
		<th>Alcance</th>
		<td><?php echo number_format((int)$item->range) ?></td>
		<th>Defesa</th>
		<td><?php echo number_format((int)$item->defence) ?></td>
	</tr>
	<tr>
		<th>Slots</th>
		<td><?php echo number_format((int)$item->slots) ?></td>
		<th>Refinável</th>
		<td>
			<?php if ($item->refineable): ?>
				Sim
			<?php else: ?>
				Não
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Ataque</th>
		<td><?php echo number_format((int)$item->attack) ?></td>
		<th>Mínimo de Level para Equipar</th>
		<td><?php echo number_format((int)$item->equip_level_min) ?></td>
	</tr>
	<?php if($server->isRenewal): ?>
	<tr>
		<th>MATK</th>
		<td><?php echo number_format((int)$item->matk) ?></td>
		<th>Max Equip Level</th>
		<td>
			<?php if ($item->equip_level_max == 0): ?>
				<span class="not-applicable">None</span>
			<?php else: ?>
				<?php echo number_format((int)$item->equip_level_max) ?>
			<?php endif ?>
		</td>
	</tr>
	<?php endif ?>
	<tr>
		<th>Equipado em</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($locs=$this->equipLocations($item->equip_locations)): ?>
				<?php echo htmlspecialchars(implode(' + ', $locs)) ?>
			<?php else: ?>
				<span class="not-applicable">Nada</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Superior</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($upper=$this->equipUpper($item->equip_upper)): ?>
				<?php echo htmlspecialchars(implode(' / ', $upper)) ?>
			<?php else: ?>
				<span class="not-applicable">Nada</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Classes Equipáveis</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($jobs=$this->equippableJobs($item->equip_jobs)): ?>
				<?php echo htmlspecialchars(implode(' / ', $jobs)) ?>
			<?php else: ?>
				<span class="not-applicable">Nada</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Gênero</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($item->equip_genders === '0'): ?>
				Feminino
			<?php elseif ($item->equip_genders === '1'): ?>
				Masculino
			<?php elseif ($item->equip_genders === '2'): ?>
				Ambos (Masculino e Feminino)
			<?php else: ?>
				<span class="not-applicable">Desconhecido</span>
			<?php endif ?>
		</td>
	</tr>
	<?php if (($isCustom && $auth->allowedToSeeItemDb2Scripts) || (!$isCustom && $auth->allowedToSeeItemDbScripts)): ?>
	<tr>
		<th>Script de Uso</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($script=$this->displayScript($item->script)): ?>
				<?php echo $script ?>
			<?php else: ?>
				<span class="not-applicable">Nada</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Script ao Equipar</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($script=$this->displayScript($item->equip_script)): ?>
				<?php echo $script ?>
			<?php else: ?>
				<span class="not-applicable">Nada</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Script ao Desequipar</th>
		<td colspan="<?php echo $image ? 4 : 3 ?>">
			<?php if ($script=$this->displayScript($item->unequip_script)): ?>
				<?php echo $script ?>
			<?php else: ?>
				<span class="not-applicable">Nada</span>
			<?php endif ?>
		</td>
	</tr>
	<?php endif ?>
</table>
<?php if ($itemDrops): ?>
<h3><?php echo htmlspecialchars($item->name) ?> Dropado De</h3>
<table class="vertical-table">
	<tr>
		<th>ID do Monstro</th>
		<th>Nome do Monstro</th>
		<th><?php echo htmlspecialchars($item->name) ?> Chance de Drop</th>
		<th>Level do Monstro</th>
		<th>Raça do Monstro</th>
		<th>Elemento do Monstro</th>
	</tr>
	<?php foreach ($itemDrops as $itemDrop): ?>
	<tr class="item-drop-<?php echo $itemDrop['type'] ?>">
		<td align="right">
			<?php if ($auth->actionAllowed('monster', 'view')): ?>
				<?php echo $this->linkToMonster($itemDrop['monster_id'], $itemDrop['monster_id']) ?>
			<?php else: ?>
				<?php echo $itemDrop['monster_id'] ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($itemDrop['type'] == 'mvp'): ?>
				<span class="mvp">MVP!</span>
			<?php endif ?>
			<?php echo htmlspecialchars($itemDrop['monster_name']) ?>
		</td>
		<td><strong><?php echo $itemDrop['drop_chance'] ?>%</strong></td>
		<td><?php echo number_format($itemDrop['monster_level']) ?></td>
		<td><?php echo Flux::monsterRaceName($itemDrop['monster_race']) ?></td>
		<td>
			Level <?php echo floor($itemDrop['monster_ele_lv']) ?>
			<em><?php echo Flux::elementName($itemDrop['monster_element']) ?></em>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php endif ?>
<?php else: ?>
<p>Nenhum item foi encontrado. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>