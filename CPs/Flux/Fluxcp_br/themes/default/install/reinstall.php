<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Reinstalar SQL's do Banco de Dados</h2>
<p>Você pode reinstalar os seus arqivos SQL a partir dessa página. Se você tem certeza do que você está fazendo, clique em "Continuar".</p>
<p><strong>Nota:</strong> Fazendo isso, você pode acabar com índices duplicados em suas tabelas do MySQL, mas eles não são prejudiciais (esse recurso é altamente experimental, então tenha certeza do que você está fazendo).</p>
<form action="<?php echo $this->urlWithQs ?>" method="post" class="generic-form">
	<input type="hidden" name="reinstall" value="1" />
	<table class="generic-form-table">
		<tr>
			<td><p>Você está absolutamente certo de que deseja continuar?</p></td>
		</tr>
		<tr>
			<td><input type="submit" value="Continuar" /></td>
		</tr>
	</table>
</form>