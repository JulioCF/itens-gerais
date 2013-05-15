<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Mudar Slot de Personagem</h2>
<?php if (!empty($errorMessage)): ?>
<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>
<form action="<?php echo $this->urlWithQs ?>" method="post" class="generic-form">
	<input type="hidden" name="changeslot" value="1" />
	<table class="generic-form-table">
		<tr>
			<th><label>Nome do Personagem</label></th>
			<td><div><?php echo htmlspecialchars($char->name) ?></div></td>
			<td></td>
		</tr>
		<tr>
			<th><label for="slot">Slot</label></th>
			<td><input type="text" name="slot" id="slot"
					size="<?php echo strlen($server->maxCharSlots) * 2 ?>"
					value="<?php echo (int)$char->char_num + 1 ?>"
					maxlength="<?php echo strlen($server->maxCharSlots) ?>" /></td>
			<td><p>Você deve colocar um slot entre 1 e <?php echo (int)$server->maxCharSlots ?>.</p></td>
		</tr>
		<tr>
			<td colspan="2" align="right"><input type="submit" value="Mudar Slot" /></td>
			<td></td>
		</tr>
	</table>
</form>