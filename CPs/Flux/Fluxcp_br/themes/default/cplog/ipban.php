<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>IP's Banidos</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Procurar...</a></p>
<form action="<?php echo $this->url ?>" method="get" class="search-form">
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="ip">Endereço de IP:</label>
		<input type="text" name="ip" id="ip" value="<?php echo htmlspecialchars($params->get('ip')) ?>" />
		...
		<label for="banned_by">Banido Por:</label>
		<input type="text" name="banned_by" id="banned_by" value="<?php echo htmlspecialchars($params->get('banned_by')) ?>" />
		...
		<label for="ban_type">Tipo de Banimento:</label>
		<select name="ban_type" id="ban_type">
			<option value=""<?php if (!($ban_type=$params->get('ban_type'))) echo ' selected="selected"' ?>><?php echo htmlspecialchars(Flux::message('AllLabel')) ?></option>
			<option value="unban"<?php if ($ban_type == 'unban') echo ' selected="selected"' ?>>Desbanimento</option>
			<option value="ban"<?php if ($ban_type == 'ban') echo ' selected="selected"' ?>>Banimento</option>
		</select>
	</p>
	<p>
		<label for="use_ban">Data do Banimento:</label>
		<input type="checkbox" name="use_ban" id="use_ban"<?php if ($params->get('use_ban')) echo ' checked="checked"' ?> />
		<?php echo $this->dateTimeField('ban') ?>
		...
		<label for="use_ban_until">Data do Desbanimento:</label>
		<input type="checkbox" name="use_ban_until" id="use_ban_until"<?php if ($params->get('use_ban_until')) echo ' checked="checked"' ?> />
		<?php echo $this->dateTimeField('ban_until') ?>
	</p>
	<p>
		<input type="submit" value="Procurar" />
		<input type="button" value="Resetar" onclick="reload()" />
	</p>
</form>
<?php if ($ipbans): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('ip', 'Endereço de IP ') ?></th>
		<th><?php echo $paginator->sortableColumn('banned_by', 'Banido Por') ?></th>
		<th><?php echo $paginator->sortableColumn('ban_type', 'Tipo de Banimento') ?></th>
		<th><?php echo $paginator->sortableColumn('ban_date', 'Data do Banimento') ?></th>
		<th><?php echo $paginator->sortableColumn('ban_until', 'Data do Desbanimento') ?></th>
		<th>Motivo do Banimento</th>
	</tr>
	<?php foreach ($ipbans as $ipban): ?>
	<tr>
		<td align="right">
			<?php if ($auth->actionAllowed('account', 'index')): ?>
				<?php echo $this->linkToAccountSearch(array('last_ip' => $ipban->ip_address), $ipban->ip_address) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($ipban->ip_address) ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($auth->actionAllowed('account', 'view') && $auth->allowedToViewAccount): ?>
				<?php echo $this->linkToAccount($ipban->banned_by, $ipban->userid) ?>
			<?php else: ?>
				<?php echo $ipban->banned_by ?>
			<?php endif ?>
		</td>
		<td>
			<?php if (!$ipban->ban_type): ?>
				Desbanido
			<?php elseif ($ipban->ban_type == 1): ?>
				<span class="account-state state-banned">Banido</span>
			<?php else: ?>
				<span class="not-applicable">Unknown</span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($ipban->ban_date == '0000-00-00 00:00:00'): ?>
				<span class="not-applicable">N/A</span>
			<?php else: ?>
				<?php echo $this->formatDateTime($ipban->ban_date) ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($ipban->ban_until == '0000-00-00 00:00:00'): ?>
				<span class="not-applicable">N/A</span>
			<?php else: ?>
				<?php echo $this->formatDateTime($ipban->ban_until) ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($ipban->ban_reason == ''): ?>
				<span class="not-applicable">Nada</span>
			<?php else: ?>
				<?php echo htmlspecialchars($ipban->ban_reason) ?>
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Nenhum banimento foi encontrados. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>