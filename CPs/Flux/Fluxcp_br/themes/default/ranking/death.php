<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Ranking de Mortes</h2>
<h3>
	Top <?php echo number_format($limit=(int)Flux::config('DeathRankingLimit')) ?> Personagens mais morto
	<?php if (!is_null($jobClass)): ?>
	(<?php echo htmlspecialchars($className=$this->jobClassText($jobClass)) ?>)
	<?php endif ?>
	no <?php echo htmlspecialchars($server->serverName) ?>
</h3>
<?php if ($chars): ?>
<form action="" method="get" class="search-form2">
	<?php echo $this->moduleActionFormInputs('ranking', 'death') ?>
	<p>
		<label for="jobclass">Pesquisar por classe:</label>
		<select name="jobclass" id="jobclass">
			<option value=""<?php if (is_null($jobClass)) echo 'selected="selected"' ?>>Todas</option>
		<?php foreach ($classes as $jobClassIndex => $jobClassName): ?>
			<option value="<?php echo $jobClassIndex ?>"
				<?php if (!is_null($jobClass) && $jobClass == $jobClassIndex) echo ' selected="selected"' ?>>
				<?php echo htmlspecialchars($jobClassName) ?>
			</option>
		<?php endforeach ?>
		</select>
		
		<input type="submit" value="Procurar" />
		<input type="button" value="Resetar" onclick="reload()" />
	</p>
</form>
<table class="horizontal-table">
	<tr>
		<th>Posição no Rank</th>
		<th>Nome do Personagem</th>
		<th>Quantidade de Mortes</th>
		<th>Classe</th>
		<th>Nível de Base</th>
		<th>Nível de Job</th>
		<th colspan="2">Nome do Clã</th>
	</tr>
	<?php $topRankType = !is_null($jobClass) ? $className : '' ?>
	<?php for ($i = 0; $i < $limit; ++$i): ?>
	<tr<?php if (!isset($chars[$i])) echo ' class="empty-row"'; if ($i === 0) echo ' class="top-ranked" title="<strong>'.htmlspecialchars($chars[$i]->char_name).'</strong> é o personagem mais morto '.$topRankType.'!"' ?>>
		<td align="right"><?php echo number_format($i + 1) ?></td>
		<?php if (isset($chars[$i])): ?>
		<td><strong>
			<?php if ($auth->actionAllowed('character', 'view') && $auth->allowedToViewCharacter): ?>
				<?php echo $this->linkToCharacter($chars[$i]->char_id, $chars[$i]->char_name) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($chars[$i]->char_name) ?>
			<?php endif ?>
		</strong></td>
		<td><?php echo number_format((int)$chars[$i]->death_count) ?></td>
		<td><?php echo $this->jobClassText($chars[$i]->char_class) ?></td>
		<td><?php echo number_format($chars[$i]->base_level) ?></td>
		<td><?php echo number_format($chars[$i]->job_level) ?></td>
		<?php if ($chars[$i]->guild_name): ?>
		<?php if ($chars[$i]->guild_emblem_len): ?>
		<td width="24"><img src="<?php echo $this->emblem($chars[$i]->guild_id) ?>" /></td>
		<?php endif ?>
		<td<?php if (!$chars[$i]->guild_emblem_len) echo ' colspan="2"' ?>>
			<?php if ($auth->actionAllowed('guild', 'view') && $auth->allowedToViewGuild): ?>
				<?php echo $this->linkToGuild($chars[$i]->guild_id, $chars[$i]->guild_name) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($chars[$i]->guild_name) ?>
			<?php endif ?>
		</td>
		<?php else: ?>
		<td colspan="2"><span class="not-applicable">Nada</span></td>
		<?php endif ?>
		<?php else: ?>
		<td colspan="8"></td>
		<?php endif ?>
	</tr>
	<?php endfor ?>
</table>
<?php else: ?>
<p>Não há nenhum personagem dessa classe no ranking. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>