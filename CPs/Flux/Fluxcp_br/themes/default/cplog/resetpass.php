<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Redefinições de Senha</h2>
<p class="toggler"><a href="javascript:toggleSearchForm()">Procurar...</a></p>
<form action="<?php echo $this->url ?>" method="get" class="search-form">
	<?php echo $this->moduleActionFormInputs($params->get('module'), $params->get('action')) ?>
	<p>
		<label for="use_request_after">Redefinição entre:</label>
		<input type="checkbox" name="use_request_after" id="use_request_after"<?php if ($params->get('use_request_after')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('request_after') ?>
		<label for="use_request_before">&mdash;</label>
		<input type="checkbox" name="use_request_before" id="use_request_before"<?php if ($params->get('use_request_before')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('request_before') ?>
	</p>
	<p>
		<label for="use_reset_after">Redefinição entre:</label>
		<input type="checkbox" name="use_reset_after" id="use_reset_after"<?php if ($params->get('use_reset_after')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('reset_after') ?>
		<label for="use_reset_before">&mdash;</label>
		<input type="checkbox" name="use_reset_before" id="use_reset_before"<?php if ($params->get('use_reset_before')) echo ' checked="checked"' ?> />
		<?php echo $this->dateField('reset_before') ?>
	</p>
	<p>
		<label for="account_id">ID da Conta:</label>
		<input type="text" name="account_id" id="account_id" value="<?php echo htmlspecialchars($params->get('account_id')) ?>" />
		...
		<label for="username">Usuário:</label>
		<input type="text" name="username" id="username" value="<?php echo htmlspecialchars($params->get('username')) ?>" />
		...
		<label for="request_ip">IP que requeriu:</label>
		<input type="text" name="request_ip" id="request_ip" value="<?php echo htmlspecialchars($params->get('request_ip')) ?>" />
		...
		<label for="reset_ip">IP que redefiniu:</label>
		<input type="text" name="reset_ip" id="reset_ip" value="<?php echo htmlspecialchars($params->get('reset_ip')) ?>" />
		
		<?php if (!$auth->allowedToSearchCpResetPass): ?>
		<input type="submit" value="Procurar" />
		<input type="button" value="Resetar" onclick="reload()" />
		<?php endif ?>
	</p>
	<?php if ($auth->allowedToSearchCpResetPass): ?>
	<p>
		<label for="old_password">Senha Antiga:</label>
		<input type="text" name="old_password" id="old_password" value="<?php echo htmlspecialchars($params->get('old_password')) ?>" />
		...
		<label for="new_password">Nova Senha:</label>
		<input type="text" name="new_password" id="new_password" value="<?php echo htmlspecialchars($params->get('new_password')) ?>" />
		
		<input type="submit" value="Procurar" />
		<input type="button" value="Resetar" onclick="reload()" />
	</p>
	<?php endif ?>
</form>
<?php if ($resets): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('log.account_id', 'ID da Conta') ?></th>
		<th><?php echo $paginator->sortableColumn('userid', 'Usuário') ?></th>
		<?php if (Flux::config('CpResetLogShowPassword') && $auth->allowedToSeeCpResetPass): ?>
		<th><?php echo $paginator->sortableColumn('old_password', 'Senha Antiga') ?></th>
		<th><?php echo $paginator->sortableColumn('new_password', 'Senha Nova') ?></th>
		<?php endif ?>
		<th><?php echo $paginator->sortableColumn('request_date', 'Data de Requisição') ?></th>
		<th><?php echo $paginator->sortableColumn('request_ip', 'IP que requeriu') ?></th>
		<th><?php echo $paginator->sortableColumn('reset_date', 'Data da Redefinição') ?></th>
		<th><?php echo $paginator->sortableColumn('reset_ip', 'IP que redefiniu') ?></th>
	</tr>
	<?php foreach ($resets as $reset): ?>
	<tr>
		<td align="right">
			<?php if ($auth->actionAllowed('account', 'view')): ?>
				<?php echo $this->linkToAccount($reset->account_id, $reset->account_id) ?>
			<?php else: ?>
				<?php echo $reset->account_id ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($reset->userid): ?>
				<?php echo htmlspecialchars($reset->userid) ?>
			<?php else: ?>
				<span class="not-applicable">Unknown</span>
			<?php endif ?>
		</td>
		<?php if (Flux::config('CpResetLogShowPassword') && $auth->allowedToSeeCpResetPass): ?>
		<td><?php echo htmlspecialchars($reset->old_password) ?></td>
		<td><?php echo htmlspecialchars($reset->new_password) ?></td>
		<?php endif ?>
		<td><?php echo $this->formatDateTime($reset->request_date) ?></td>
		<td>
			<?php if ($auth->actionAllowed('account', 'index')): ?>
				<?php echo $this->linkToAccountSearch(array('last_ip' => $reset->request_ip), $reset->request_ip) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($reset->request_ip) ?>
			<?php endif ?>
		</td>
		<td>
			<?php if ($reset->reset_date): ?>
				<?php echo $this->formatDateTime($reset->reset_date) ?>
			<?php else: ?>
				<span class="not-applicable">Nada</span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($reset->reset_ip): ?>
				<?php if ($auth->actionAllowed('account', 'index')): ?>
					<?php echo $this->linkToAccountSearch(array('last_ip' => $reset->reset_ip), $reset->reset_ip) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($reset->reset_ip) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable">Nada</span>
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>Nenhuma redefinição de senha encontrada. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>