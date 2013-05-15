<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Vendo Clã</h2>
<?php if ($guild): ?>
<h3>Informações do Clã “<?php echo htmlspecialchars($guild->name) ?>”</h3>
<table class="vertical-table">
	<tr>
		<th>ID do Clã</th>
		<td><?php echo htmlspecialchars($guild->guild_id) ?></td>
		<th>Nome do Clã</th>
		<td><?php echo htmlspecialchars($guild->name) ?></td>
		<th>ID do Emblema</th>
		<td><?php echo number_format($guild->emblem_id) ?></td>
		<td><img src="<?php echo $this->emblem($guild->guild_id) ?>" /></td>
	</tr>
	<tr>
		<th>ID do Líder</th>
		<td><?php echo htmlspecialchars($guild->char_id) ?></td>
		<th>Nome do Líder</th>
		<td>
			<?php if ($auth->allowedToViewCharacter): ?>
				<?php echo $this->linkToCharacter($guild->char_id, $guild->guild_master) ?>
			<?php else: ?>
				<?php echo htmlspecialchars($guild->guild_master) ?>
			<?php endif ?>
		</td>
		<th>Level do Clã</th>
		<td colspan="2"><?php echo number_format($guild->guild_lv) ?></td>
	</tr>
	<tr>
		<th>Membros Online</th>
		<td><?php echo number_format($guild->connect_member) ?></td>
		<th>Capacidade</th>
		<td><?php echo number_format($guild->max_member) ?></td>
		<th>Nível Médio dos Membros</th>
		<td colspan="2"><?php echo number_format($guild->average_lv) ?></td>
	</tr>
	<tr>
		<th>EXP do Clã</th>
		<td><?php echo number_format($guild->exp) ?></td>
		<th>EXP até Subir de Nível</th>
		<td><?php echo number_format($guild->next_exp) ?></td>
		<th>Pontos de Habilidade</th>
		<td colspan="2"><?php echo number_format($guild->skill_point) ?></td>
	</tr>
	<tr>
		<th>Notícias do Clã 1</th>
		<td colspan="6">
			<?php if (trim($guild->mes1)): ?>
				<?php echo htmlspecialchars($guild->mes1) ?>
			<?php else: ?>
				<span class="not-applicable">Nada</span>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>Notícias do Clã 2</th>
		<td colspan="6">
			<?php if (trim($guild->mes2)): ?>
				<?php echo htmlspecialchars($guild->mes2) ?></td>
			<?php else: ?>
				<span class="not-applicable">Nada</span>
			<?php endif ?>
		</td>
	</tr>
</table>
<h3>Alianças de “<?php echo htmlspecialchars($guild->name) ?>”</h3>
<?php if ($alliances): ?>
	<p><?php echo htmlspecialchars($guild->name) ?> tem <?php echo count($alliances) ?> Aliança(s).</p>
	<table class="vertical-table">
		<tr>
			<th>ID do Clã</th>
			<th>Nome do Clã</th>
		</tr>
		<?php foreach ($alliances AS $alliance): ?>
		<tr>
			<td align="right">
				<?php if ($auth->allowedToViewGuild): ?>
					<?php echo $this->linkToGuild($alliance->alliance_id, $alliance->alliance_id) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($alliance->alliance_id) ?>
				<?php endif ?>
			</td>
			<td><?php echo htmlspecialchars($alliance->name) ?></td>
		</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>Esse clã não possui aliança(s).</p>
<?php endif ?>
<h3>Inimigos de “<?php echo htmlspecialchars($guild->name) ?>”</h3>
<?php if ($oppositions): ?>
	<p><?php echo htmlspecialchars($guild->name) ?> tem <?php echo count($oppositions) ?> Inimigo(s).</p>
	<table class="vertical-table">
		<tr>
			<th>ID do Clã</th>
			<th>Nome do Clã</th>
		</tr>
		<?php foreach ($oppositions AS $opposition): ?>
		<tr>
			<td align="right">
				<?php if ($auth->allowedToViewGuild): ?>
					<?php echo $this->linkToGuild($opposition->alliance_id, $opposition->alliance_id) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($opposition->alliance_id) ?>
				<?php endif ?>
			</td>
			<td><?php echo htmlspecialchars($opposition->name) ?></td>
		</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>Esse clã não possui inimigo(s).</p>
<?php endif ?>
<h3>Membros do Clã “<?php echo htmlspecialchars($guild->name) ?>”</h3>
<?php if ($members): ?>
	<p><?php echo htmlspecialchars($guild->name) ?> tem <?php echo count($members) ?> membro(s).</p>
	<table class="vertical-table">
		<tr>
			<th>Nome</th>
			<th>Classe</th>
			<th>Nível de Base</th>
			<th>Nível de Job</th>
			<th>EXP de Devoção</th>
			<th>ID de Posição</th>
			<th>Posição no Clã</th>
			<th>Direitos do Clã</th>
			<th>Taxa</th>
			<th>Último Login</th>
		</tr>
		<?php foreach ($members AS $member): ?>
		<tr>
			<td align="right">
				<?php if ($auth->allowedToViewCharacter): ?>
					<?php echo $this->linkToCharacter($member->char_id, $member->name) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($member->name) ?>
				<?php endif ?>
			</td>
			<td>
				<?php if ($job=$this->jobClassText($member->class)): ?>
					<?php echo htmlspecialchars($job) ?>
				<?php else: ?>
					<span class="not-applicable">Desconhecido</span>
				<?php endif ?>
			</td>
			<td><?php echo htmlspecialchars($member->base_level) ?></td>
			<td><?php echo htmlspecialchars($member->job_level) ?></td>
			<td><?php echo number_format($member->devotion) ?></td>
			<td><?php echo htmlspecialchars($member->position) ?></td>
			<td><?php echo htmlspecialchars($member->position_name) ?></td>
			<td>
				<?php if ($member->mode == 17): ?>
					<?php echo htmlspecialchars("Convidar/Expulsar") ?>
				<?php elseif ($member->mode == 16): ?>
					<?php echo htmlspecialchars("Expulsar") ?>
				<?php elseif ($member->mode == 1): ?>
					<?php echo htmlspecialchars("Convidar") ?>
				<?php elseif ($member->mode == 0): ?>
					<span class="not-applicable">Nada</span>
				<?php else: ?>
					<span class="not-applicable">Desconhecido</span>
				<?php endif ?>
			</td>
			<td><?php echo number_format($member->exp_mode) ?>%</td>
			<td><?php echo htmlspecialchars($member->lastlogin) ?></td>
		</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>Não há membros nesse clã.</p>
<?php endif ?>
<h3>Membros expulsos de “<?php echo htmlspecialchars($guild->name) ?>”</h3>
<?php if ($expulsions): ?>
	<p><?php echo htmlspecialchars($guild->name) ?> tem <?php echo count($expulsions) ?> membro(s) expulso(s).</p>
	<table class="vertical-table">
		<tr>
			<th>ID da Conta</th>
			<th>Nome do Personagem</th>
			<th>Razão da Expulsão</th>
		</tr>
		<?php foreach ($expulsions AS $expulsion): ?>
		<tr>
			<td align="right">
				<?php if ($auth->allowedToViewAccount): ?>
					<?php echo $this->linkToAccount($expulsion->account_id, $expulsion->account_id) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($expulsion->account_id) ?>
				<?php endif ?>
			</td>
			<td><?php echo htmlspecialchars($expulsion->name) ?></td>
			<td>
			<?php if($expulsion->mes): ?>
				<?php echo htmlspecialchars($expulsion->mes) ?>
			<?php else: ?>
				<span class="not-applicable">Nada</span>
			<?php endif ?>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
<?php else: ?>
	<p>Nenhum membro foi expluso desse clã.</p>
<?php endif ?>
<?php if (!Flux::config('GStorageLeaderOnly') || $amOwner || $auth->allowedToViewGuild): ?>
	<h3>Itens no Armazém do Clã “<?php echo htmlspecialchars($guild->name) ?>”</h3>
	<?php if (Flux::config('GStorageLeaderOnly')): ?>
		<p>Nota: Itens de armazenamento do Clã apenas estão disponíveis para você, o Líder do Clã.</p>
	<?php endif ?>
	<?php if ($items): ?>
		<p><?php echo htmlspecialchars($guild->name) ?> tem <?php echo count($items) ?> item(s) em seu Armazém do Clã.</p>
		<table class="vertical-table">
			<tr>
				<th>ID do Item</th>
				<th colspan="2">Nome</th>
				<th>Quantidade</th>
				<th>Identificado</th>
				<th>Quebrado</th>
				<th>Carta 0</th>
				<th>Carta 1</th>
				<th>Carta 2</th>
				<th>Carta 3</th>
				</th>
			</tr>
			<?php foreach ($items AS $item): ?>
			<?php $icon = $this->iconImage($item->nameid) ?>
			<tr>
				<td align="right"><?php echo $this->linkToItem($item->nameid, $item->nameid) ?></td>
				<?php if ($icon): ?>
				<td><img src="<?php echo htmlspecialchars($icon) ?>" /></td>
				<?php endif ?>
				<td<?php if (!$icon) echo ' colspan="2"' ?><?php if ($item->cardsOver) echo ' class="overslotted' . $item->cardsOver . '"'; else echo ' class="normalslotted"' ?>>
					<?php if ($item->refine > 0): ?>
						+<?php echo htmlspecialchars($item->refine) ?>
					<?php endif ?>
					<?php if ($item->card0 == 255 && intval($item->card1/1280) > 0): ?>
						<?php for ($i = 0; $i < intval($item->card1/1280); $i++): ?>
							Muito
						<?php endfor ?>
						Forte
					<?php endif ?>
					<?php if ($item->card0 == 254 || $item->card0 == 255): ?>
						<?php if ($item->char_name): ?>
							<?php if ($auth->actionAllowed('character', 'view') && ($isMine || (!$isMine && $auth->allowedToViewCharacter))): ?>
								<?php echo $this->linkToCharacter($item->char_id, $item->char_name, $session->serverName) . "'s" ?>
							<?php else: ?>
								<?php echo htmlspecialchars($item->char_name . "'s") ?>
							<?php endif ?>
						<?php else: ?>
							<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('UnknownLabel')) ?></span>'s
						<?php endif ?>
					<?php endif ?>
					<?php if ($item->card0 == 255 && array_key_exists($item->card1%1280, $itemAttributes)): ?>
						<?php echo htmlspecialchars($itemAttributes[$item->card1%1280]) ?>
					<?php endif ?>
					<?php if ($item->name_japanese): ?>
						<span class="item_name"><?php echo htmlspecialchars($item->name_japanese) ?></span>
					<?php else: ?>
						<span class="not-applicable">Item Desconhecido</span>
					<?php endif ?>
					<?php if ($item->slots): ?>
						<?php echo htmlspecialchars(' [' . $item->slots . ']') ?>
					<?php endif ?>
				</td>
				<td><?php echo number_format($item->amount) ?></td>
				<td>
					<?php if ($item->identify): ?>
						<span class="identified yes">Sim</span>
					<?php else: ?>
						<span class="identified no">Não</span>
					<?php endif ?>
				</td>
				<td>
					<?php if ($item->attribute): ?>
						<span class="broken yes">Sim</span>
					<?php else: ?>
						<span class="broken no">Não</span>
					<?php endif ?>
				</td>
				<td>
					<?php if($item->card0 && ($item->type == 4 || $item->type == 5) && $item->card0 != 254 && $item->card0 != 255 && $item->card0 != -256): ?>
						<?php if (!empty($cards[$item->card0])): ?>
							<?php echo $this->linkToItem($item->card0, $cards[$item->card0]) ?>
						<?php else: ?>
							<?php echo $this->linkToItem($item->card0, $item->card0) ?>
						<?php endif ?>
					<?php else: ?>
						<span class="not-applicable">Nada</span>
					<?php endif ?>
				</td>
				<td>
					<?php if($item->card1 && ($item->type == 4 || $item->type == 5) && $item->card0 != 255 && $item->card0 != -256): ?>
						<?php if (!empty($cards[$item->card1])): ?>
							<?php echo $this->linkToItem($item->card1, $cards[$item->card1]) ?>
						<?php else: ?>
							<?php echo $this->linkToItem($item->card1, $item->card1) ?>
						<?php endif ?>
					<?php else: ?>
						<span class="not-applicable">Nada</span>
					<?php endif ?>
				</td>
				<td>
					<?php if($item->card2 && ($item->type == 4 || $item->type == 5) && $item->card0 != 254 && $item->card0 != 255 && $item->card0 != -256): ?>
						<?php if (!empty($cards[$item->card2])): ?>
							<?php echo $this->linkToItem($item->card2, $cards[$item->card2]) ?>
						<?php else: ?>
							<?php echo $this->linkToItem($item->card2, $item->card2) ?>
						<?php endif ?>
					<?php else: ?>
						<span class="not-applicable">Nada</span>
					<?php endif ?>
				</td>
				<td>
					<?php if($item->card3 && ($item->type == 4 || $item->type == 5) && $item->card0 != 254 && $item->card0 != 255 && $item->card0 != -256): ?>
						<?php if (!empty($cards[$item->card3])): ?>
							<?php echo $this->linkToItem($item->card3, $cards[$item->card3]) ?>
						<?php else: ?>
							<?php echo $this->linkToItem($item->card3, $item->card3) ?>
						<?php endif ?>
					<?php else: ?>
						<span class="not-applicable">Nada</span>
					<?php endif ?>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	<?php else: ?>
		<p>Não há itens no Armazém desse clã.</p>
	<?php endif ?>
<?php endif ?>
<?php else: ?>
<p>Nenhum clã encontrado. <a href="javascript:history.go(-1)">Voltar</a>.</p>
<?php endif ?>