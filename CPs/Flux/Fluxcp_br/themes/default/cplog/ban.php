<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Contas Banidas</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Procurar...</a></p>
<form action="<?php echo $this->url ?>" method="get" class="search-form">
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="account">Conta:</label>
		<input type="text" name="account" id="account" value="<?php echo htmlspecialchars($params->get('account')) ?>" />
		...
		<label for="banned_by">Banido por:</label>
		<input type="text" name="banned_by" id="banned_by" value="<?php echo htmlspecialchars($params->get('banned_by')) ?>" />
		...
		<label for="ban_type">Tipo de Ban:</label>
		<select name="ban_type" id="ban_type">
			<option value=""<?php if (!($ban_type=$params->get('ban_type'))) echo ' selected="selected"' ?>><?php echo htmlspecialchars(Flux::message('AllLabel')) ?></option>
			<option value="unban"<?php if ($ban_type == 'unban') echo ' selected="selected"' ?>>Desbanir</option>
			<option value="ban"<?php if ($ban_type == 'ban') echo ' selected="selected"' ?>>Banir</option>
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
		<input type="submit" value="Search" />
		<input type="button" value="Reset" onclick="reload()" />
	</p>
</form>
<?php if ($bans): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('account', 'Conta') ?></th>
		<th><?php echo $paginator->sortableColumn('banned_by', 'Banido por') ?></th>
		<th><?php echo $paginator->sortableColumn('ban_type', 'Tipo de Ban') ?></th>
		<th><?php echo $paginator->sortableColumn('ban_date', 'Data do Banimento') ?></th>
		<th><?php echo $paginator->sortableColumn('ban_until', 'Data do Desbanimento') ?></th>
		<th>Motivo do Banimento</th>
	</tr>
	<?php foreach ($bans as $ban): ?>
	<tr>
		<td align="right">
			<?php if ($auth->actionAllowed('account', 'view') && $auth->allowedToViewAccount): ?>
				<?php echo $this->linkToAccount($ban->account_id, $ban->banned_userid) ?>
			<?php else: ?>
				<?php echo $ban->account_id ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($auth->actionAllowed('account', 'view') && $auth->allowedToViewAccount): ?>
				<?php echo $this->linkToAccount($ban->banned_by, $ban->banned_by_userid) ?>
			<?php else: ?>
				<?php echo $ban->banned_by ?>
			<?php endif ?>
		</td>
		<td>
			<?php if (!$ban->ban_type): ?>
				Desbanido
			<?php elseif ($ban->ban_type == 1): ?>
				<span class="account-state state-banned">Banimento Temporário</span>
			<?php elseif ($ban->ban_type == 2): ?>
				<span class="account-state state-permanently-banned">Banimento Permanente</span>
			<?php else: ?>
				<span class="not-applicable">Desconhecido</span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($ban->ban_date == '0000-00-00 00:00:00'): ?>
				<span class="not-applicable">N/A</span>
			<?php else: ?>
				<?php echo $this->formatDateTime($ban->ban_date) ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($ban->ban_until == '0000-00-00 00:00:00'): ?>
				<span class="not-applicable">N/A</span>
			<?php else: ?>
				<?php echo $this->formatDateTime($ban->ban_until) ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($ban->ban_reason == ''): ?>
				<span class="not-applicable">Nada</span>
			<?php else: ?>
				<?php echo htmlspecialchars($ban->ban_reason) ?>
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Nenhum registro foi encontrado. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>