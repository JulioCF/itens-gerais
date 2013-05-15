<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Modificar Item</h2>
<?php if ($item): ?>
<p>Os campos requeridos são apenas <em>ID do Item</em>, <em>Identificado</em>, <em>Nome</em> e <em>Tipo</em>.</p>
<p><strong>Nota:</strong> Se o campo <em>Preço de Venda no NPC</em> ficar em branco, o padrão será a metade do preço de compra.</p>
<?php if (!empty($errorMessage)): ?>
<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>
<form action="<?php echo $this->urlWithQs ?>" method="post" name="edit_item_form">
	<input type="hidden" name="edititem" value="1" />
	<table class="vertical-table">
		<tr>
			<th><label for="item_id">ID do Item</label></th>
			<td><label><strong><?php echo htmlspecialchars($itemID) ?></strong></label></td>
			<th><label for="view">View ID</label></th>
			<td><input type="text" name="view" id="view" value="<?php echo htmlspecialchars($viewID) ?>" /></td>
		</tr>
		<tr>
			<th><label for="name_english">Identificado</label></th>
			<td><input type="text" name="name_english" id="name_english" value="<?php echo htmlspecialchars($identifier) ?>" /></td>
			<th><label for="type">Tipo</label></th>
			<td>
				<select name="type" id="type" onchange="if (this.options[this.selectedIndex].value.indexOf('-') != -1) document.edit_item_form.view.value=this.options[this.selectedIndex].value.substring(this.options[this.selectedIndex].value.indexOf('-')+1)">
				<?php foreach (Flux::config('ItemTypes')->toArray() as $nameid => $typeName): ?>
					<?php $itemTypes2 = Flux::config('ItemTypes2')->toArray() ?>
					<?php if (!array_key_exists($nameid, $itemTypes2)): ?>
						<option value="<?php echo htmlspecialchars($nameid) ?>"<?php if ($nameid == $type) echo ' selected="selected"' ?>>
							<?php echo htmlspecialchars($typeName) ?>
						</option>
					<?php endif ?>
					<?php if (array_key_exists($nameid, $itemTypes2)): ?>
						<?php foreach ($itemTypes2[$nameid] as $typeId2 => $typeName2): ?>
						<option value="<?php echo $nameid ?>-<?php echo $typeId2 ?>"<?php if ($nameid == $type && $viewID == $typeId2) echo ' selected="selected"' ?>>
							<?php echo htmlspecialchars($typeName . ' - ' . $typeName2) ?>
						</option>
						<?php endforeach ?>
					<?php endif ?>
				<?php endforeach ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="name_japanese">Nome</label></th>
			<td><input type="text" name="name_japanese" id="name_japanese" value="<?php echo htmlspecialchars($itemName) ?>" /></td>
			<th><label for="slots">Slots</label></th>
			<td><input type="text" name="slots" id="slots" value="<?php echo htmlspecialchars($slots) ?>" /></td>
		</tr>
		<tr>
			<th><label for="npc_buy">Preço de Compra em NPC</label></th>
			<td><input type="text" name="npc_buy" id="npc_buy" value="<?php echo htmlspecialchars($npcBuy) ?>" /></td>
			<th><label for="weight">Peso</label></th>
			<td><input type="text" name="weight" id="weight" value="<?php echo htmlspecialchars(round($weight, 1)) ?>" /></td>
		</tr>
		<tr>
			<th><label for="npc_sell">Preço de Venda em NPC</label></th>
			<td><input type="text" name="npc_sell" id="npc_sell" value="<?php echo htmlspecialchars($npcSell) ?>" /></td>
			<th><label for="range">Alcance</label></th>
			<td><input type="text" name="range" id="range" value="<?php echo htmlspecialchars($range) ?>" /></td>
		</tr>
		<tr>
			<th><label for="weapon_level">Level da Arma</label></th>
			<td><input type="text" name="weapon_level" id="weapon_level" value="<?php echo htmlspecialchars($weaponLevel) ?>" /></td>
			<th><label for="defense">Defesa</label></th>
			<td><input type="text" name="defense" id="defense" value="<?php echo htmlspecialchars($defense) ?>" /></td>

		</tr>
		<tr>
			<th><label for="attack">Ataque</label></th>
			<td><input type="text" name="attack" id="attack" value="<?php echo htmlspecialchars($attack) ?>" /></td>
			<th><label for="equip_level">Mínimo de Level para Equipar</label></th>
			<td><input type="text" name="equip_level_min" id="equip_level_min" value="<?php echo htmlspecialchars($equipLevelMin) ?>" /></td>
		</tr>
		<?php if($server->isRenewal): ?>
		<tr>
			<th><label for="matk">MATK</label></th>
			<td><input type="text" name="matk" id="matk" value="<?php echo htmlspecialchars($matk) ?>" /></td>
			<th><label for="equip_level_max">Máximo de Level para Equipar</label></th>
			<td><input type="text" name="equip_level_max" id="equip_level_max" value="<?php echo htmlspecialchars($equipLevelMax) ?>" /></td>
		</tr>
		<?php endif ?>
		<tr>
			<th><label>Refinável</label></th>
			<td colspan="3">
				<label style="display: inline"><input type="radio" name="refineable" value="1"<?php if ($refineable) echo ' checked="checked"' ?>/>Sim</label>
				<label style="display: inline"><input type="radio" name="refineable" value="0"<?php if (!$refineable) echo ' checked="checked"' ?> />Não</label>
			</td>
		</tr>
		<tr>
			<th><label for="equip_locations">Lugar Para Equipar</label></th>
			<td colspan="3">
				<select name="equip_locations" id="equip_locations">
				<?php foreach (Flux::config('EquipLocationCombinations')->toArray() as $locId => $locName): ?>
					<option value="<?php echo htmlspecialchars($locId) ?>"<?php if ($locId == $equipLoc) echo ' selected="selected"' ?>>
						<?php echo htmlspecialchars($locName) ?>
					</option>
				<?php endforeach ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="equip_upper">Equipamento Superior</label></th>
			<td colspan="3">
				<select class="multi-select" name="equip_upper[]" id="equip_upper" size="5" multiple="multiple">
				<?php foreach (Flux::getEquipUpperList() as $bit => $upper): ?>
					<option value="<?php echo htmlspecialchars($bit) ?>"<?php if ($equipUpper && in_array($bit, $equipUpper)) echo ' selected="selected"' ?>>
						<?php echo htmlspecialchars($upper) ?>
					</option>
				<?php endforeach ?>
				</select>
				<p class="action">
					<span class="anchor" onclick="$('#equip_upper option').attr('selected', 'selected')">Selecionar Tudo</span> |
					<span class="anchor" onclick="$('#equip_upper option').attr('selected', false)">Não Selecionar Nada</span>
				</p>
			</td>
		</tr>
		<tr>
			<th><label for="equip_jobs">Classes Equipáveis</label></th>
			<td colspan="3">
				<select class="multi-select" name="equip_jobs[]" id="equip_jobs" size="10" multiple="multiple">
				<?php foreach (Flux::getEquipJobsList() as $bit => $className): ?>
					<option value="<?php echo htmlspecialchars($bit) ?>"<?php if ($equipJobs && in_array($bit, $equipJobs)) echo ' selected="selected"' ?>>
						<?php echo htmlspecialchars($className) ?>
					</option>
				<?php endforeach ?>
				</select>
				<p class="action">
					<span class="anchor" onclick="$('#equip_jobs option').attr('selected', 'selected')">Selecionar Tudo</span> |
					<span class="anchor" onclick="$('#equip_jobs option').attr('selected', false)">Não Selecionar Nada</span>
				</p>
			</td>
		</tr>
		<tr>
			<th><label>Gênero</label></th>
			<td colspan="3">
				<label style="display: inline"><input type="checkbox" name="equip_male" value="1"<?php if ($equipMale) echo ' checked="checked"' ?> />Masculino</label>
				<label style="display: inline"><input type="checkbox" name="equip_female" value="1"<?php if ($equipFemale) echo ' checked="checked"' ?> />Feminino</label>
			</td>
		</tr>
		<tr>
			<th><label for="script">Script de Uso</label></th>
			<td colspan="3"><textarea class="script" name="script" id="script"><?php echo htmlspecialchars($script) ?></textarea></td>
		</tr>
		<tr>
			<th><label for="equip_script">Script ao Equipar</label></th>
			<td colspan="3"><textarea class="script" name="equip_script" id="equip_script"><?php echo htmlspecialchars($equipScript) ?></textarea></td>
		</tr>
		<tr>
			<th><label for="unequip_script">Script ao Desequipar</label></th>
			<td colspan="3"><textarea class="script" name="unequip_script" id="unequip_script"><?php echo htmlspecialchars($unequipScript) ?></textarea></td>
		</tr>
		<tr>
			<td colspan="4" align="right"><input type="submit" value="Modify Item" /></td>
		</tr>
	</table>
</form>
<?php else: ?>
<p>Nenhum item encontrado. <a href="javascript:history.go(-1)">voltar</a>.</p>
<?php endif ?>