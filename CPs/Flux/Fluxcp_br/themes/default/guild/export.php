<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Exportar Emblemas dos Clãs</h2>
<p>Por favor, selecione os servidores que você gostaria de exportar os emblemas do clã como um arquivo ZIP.</p>
<form action="<?php echo $this->url ?>" method="post">
	<input type="hidden" name="post" value="1" />
	<?php foreach ($serverNames as $serverName): ?>
	<p class="emblem-server"><label>
		&raquo;
		<input type="checkbox" name="server[]" checked="checked" value="<?php echo htmlspecialchars($serverName) ?>" />
		<span><?php echo htmlspecialchars($serverName) ?></span>
	</label></p>
	<?php endforeach ?>
	<button type="submit" class="submit_button">Exportar</button>
</form>