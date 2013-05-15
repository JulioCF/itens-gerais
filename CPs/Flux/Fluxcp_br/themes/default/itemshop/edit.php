<?php
if (!defined('FLUX_ROOT')) exit;
$markdownURL = 'http://daringfireball.net/projects/markdown/syntax';
?>
<h2>Loja de Itens</h2>
<h3>Modificar Item na Loja</h3>
<?php if ($item): ?>
<?php if (!empty($errorMessage)): ?>
<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
<?php endif ?>
<form action="<?php echo $this->urlWithQs ?>" method="post" enctype="multipart/form-data">
<?php if (!$stackable): ?>
<input type="hidden" name="qty" value="1" />
<?php endif ?>
<table class="vertical-table">
	<tr>
		<th>ID da Loja</th>
		<td><?php echo htmlspecialchars($item->shop_item_id) ?></td>
	</tr>
	<tr>
		<th>ID do Item</th>
		<td><?php echo $this->linkToItem($item->shop_item_nameid, $item->shop_item_nameid) ?></td>
	</tr>
	<tr>
		<th>Nome</th>
		<td><?php echo htmlspecialchars($item->shop_item_name) ?></td>
	</tr>
	<tr>
		<th><label for="category">Categoria</label></th>
		<td>
			<select name="category" id="category">
				<option value="none"<?php if (is_null($category) || strtolower($category) == 'none') echo ' selected="selected"' ?>><?php echo htmlspecialchars(Flux::message('NoneLabel')) ?></option>
				<?php foreach ($categories as $categoryID => $cat): ?>
					<option value="<?php echo (int)$categoryID ?>"<?php if ($category === (string)$categoryID) echo ' selected="selected"' ?>><?php echo htmlspecialchars($cat) ?></option>
				<?php endforeach ?>
			</select>
		</td>
	</tr>
	<tr>
		<th><label for="cost">Créditos</label></th>
		<td><input type="text" class="short" name="cost" id="cost" value="<?php echo htmlspecialchars($cost) ?>" /></td>
	</tr>
	<?php if ($stackable): ?>
	<tr>
		<th><label for="qty">Quantidade</label></th>
		<td><input type="text" class="short" name="qty" id="qty" value="<?php echo htmlspecialchars($quantity) ?>" /></td>
	</tr>
	<?php endif ?>
	<tr>
		<th><label for="info">Informações</label></th>
		<td>
			<textarea name="info" id="info"><?php echo htmlspecialchars($info) ?></textarea>
			<p style="font-style: italic">Informações da sintaxe Markdown</p>
			<p style="font-style: italic">Veja: <a href="<?php echo $markdownURL ?>"><?php echo $markdownURL ?></a></p>
		</td>
	</tr>
	<tr>
		<th><label for="image">Imagem</label></th>
		<td>
			<input type="file" name="image" id="image" />
			<label>Deseja usar uma imagem existente? <input type="checkbox" name="use_existing" value="1"<?php if ($item->shop_item_use_existing) echo ' checked="checked"' ?> /></label>
			<?php if ($image=$this->shopItemImage($item->shop_item_id)): ?>
			<p>
				Imagem atual:
				<?php if ($auth->actionAllowed('itemshop', 'imagedel')): ?>
					<a href="<?php echo $this->url('itemshop', 'imagedel', array('id' => $item->shop_item_id)) ?>">(Delete)</a>
				<?php endif ?>
			</p>
			<p><img src="<?php echo $image ?>" /></p>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<input type="submit" value="Modify" />
		</td>
	</tr>
</table>
</form>
<?php else: ?>
<p>Impossível modificar item desconhecido na loja. <a href="javascript:history.go(-1)">Go back</a>.</p>
<?php endif ?>