<?php if (!$session->installerAuth): ?>
	<form action="<?php echo $this->url ?>" method="post">
		<p>
			Por favor, digite a <em>senha de instalação</em> (setada em application.php) para continuar com a atualização.
		</p>
		<p>
			<label for="installer_password">
				<strong>Senha:</strong>
				<input type="password" id="installer_password" name="installer_password" />
				<button type="submit">Autenticar</button>
			</label>
		</p>
	</form>
<?php else: ?>
	<?php if (isset($permissionError)): ?>
		<h2 class="error">Erro de Permissões do MySQL Encontrado</h2>
		<p>Uh oh, o instalador encontrou um erro de permissão ao tentar executar um dos arquivos SQL!</p>
		<p>Isso normalmente significa que a consulta falhou devido a falta de permissão de usuários/databases/tabelas no MySQL.</p>
		<table class="schema-info">
			<!--
			<tr>
				<th>Schema Type</th>
				<td><?php echo $permissionError->isLoginDbSchema() ? 'Banco de Dados do Login Server' : 'Banco de Dados do Char/Map Server' ?></td>
			</tr>
			<tr>
				<th>Schema File</th>
				<td><?php echo htmlspecialchars(realpath($permissionError->schemaFile)) ?></td>
			</tr>
			-->
			<tr>
				<th>Servidor</th>
				<td>
					<?php echo htmlspecialchars($permissionError->mainServerName) ?>
					<?php if ($permissionError->charMapServerName): ?>
						(<?php echo htmlspecialchars($permissionError->charMapServerName) ?>)
					<?php endif ?>
				</td>
			</tr>
			<tr>
				<th>Banco de Dados</th>
				<td><?php echo htmlspecialchars($permissionError->databaseName) ?></td>
			</tr>
			<tr>
				<th>Erro</th>
				<td><?php echo htmlspecialchars($permissionError->getMessage()) ?></td>
			</tr>
			<tr>
				<th>SQL Query</th>
				<td><code><?php echo nl2br(htmlspecialchars($permissionError->query)) ?></code></td>
			</tr>
		</table>
		<h4 style="margin: 9px 0 0 0">A solução recomendada para esse problema é que você dê privilégios ao usuário para executar queries em um banco de dados ou tabela.</h4>
		<h4 style="margin: 4px 0 0 0">Executar queries SQL manualmente não é um método suportado porque a versão dos arquivos instalados não vai ser lida e o instalador não vai continuar.</h4>
	<?php else: ?>
		<p class="menu">
			<a href="<?php echo $this->url($params->get('module'), null, array('logout' => 1)) ?>" onclick="return confirm('Você tem certeza que deseja Sair?')">Sair</a> |
			<a href="<?php echo $this->url($params->get('module'), null, array('update_all' => 1)) ?>" onclick="Ao fazer essa ação, alteração serão feitas em seu banco de dados.\n\Você tem certeza que quer continuar ao instalar o Flux e suas respectivas atualizações?')"><strong>Instalar ou Atualizar Tudo</strong></a>
		</p>
		<p>"Instalar ou Atualizar Tudo" irá usar o usuário e senha do MySQL pré-configurados para cada servidor.</p>
		<p>Abaixo está uma lista dos esquemas atualmente instalados ou que precisam ser instalados.</p>
		<form action="<?php echo $this->urlWithQs ?>" method="post">
		<table class="schema-info">
			<?php foreach ($installer->servers as $mainServerName => $mainServer): ?>
			<?php $servName = base64_encode($mainServerName) ?>
			<tr>
				<th colspan="3"><h3><?php echo htmlspecialchars($mainServerName) ?></h3></th>
			</tr>
			<tr>
				<th colspan="3">Usuário e Senha alternativos para o MySQL</th>
			</tr>
			<tr>
				<th><label for="username_<?php echo $servName ?>">Usuário do MySQL</label></th>
				<td colspan="2"><input class="input" type="text" name="username[<?php echo $servName ?>]" id="username_<?php echo $servName ?>" /></td>
			</tr>
			<tr>
				<th><label for="password_<?php echo $servName ?>">Senha do MySQL</label></th>
				<td colspan="2"><input class="input" type="password" name="password[<?php echo $servName ?>]" id="password_<?php echo $servName ?>" /></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2">
					<button type="submit" name="update[<?php echo $servName ?>]">
						Atualizar <strong><?php echo htmlspecialchars($mainServerName) ?></strong>
					</button>
				</td>
			</tr>
			<tr>
				<th>Nome do Esquema</th>
				<th>Última Versão</th>
				<th>Versão Instalada</th>
			</tr>
				<?php foreach ($mainServer->schemas as $schema): ?>
			<tr>
				<td><?php echo htmlspecialchars($schema->schemaInfo['name']) ?></td>
				<td>
					<?php if ($schema->latestVersion > $schema->versionInstalled): ?>
						<span class="schema-query" title="<?php echo htmlspecialchars(file_get_contents($schema->schemaInfo['files'][$schema->latestVersion])) ?>">
						<?php echo htmlspecialchars($schema->latestVersion) ?>
						</span>
					<?php else: ?>
						<?php echo htmlspecialchars($schema->latestVersion) ?>
					<?php endif ?>
				</td>
				<td><?php echo $schema->versionInstalled ? htmlspecialchars($schema->versionInstalled) : '<span class="none">Nada</span>' ?></td>
			</tr>
				<?php endforeach ?>

				<?php foreach ($mainServer->charMapServers as $charMapServerName => $charMapServer): ?>
			<tr>
				<th colspan="3"><h4><?php echo htmlspecialchars($charMapServerName) ?></h4></th>
			</tr>
			<tr>
				<th>Nome do Esquema</th>
				<th>Última Versão</th>
				<th>Versão Instalada</th>
			</tr>
					<?php foreach ($charMapServer->schemas as $schema): ?>
			<tr>
				<td><?php echo htmlspecialchars($schema->schemaInfo['name']) ?></td>
				<td><?php echo htmlspecialchars($schema->latestVersion) ?></td>
				<td><?php echo $schema->versionInstalled ? htmlspecialchars($schema->versionInstalled) : '<span class="none">Nada</span>' ?></td>
			</tr>
					<?php endforeach ?>

				<?php endforeach ?>
			<?php endforeach ?>
		</table>
		</form>
	<?php endif ?>
<?php endif ?>