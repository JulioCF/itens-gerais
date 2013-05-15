<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>E-mail Confiáveis do PayPal</h2>
<?php if ($emails): ?>
<p>Abaixo está uma lista dos seus e-mail confiáveis do PayPal.</p>
<p>E-mail confiáveis não são submetidos a qualquer processo de pendência, entretanto as doações feitas por eles permitem que você receba seus créditos <strong>instantaneamente</strong>.</p>
<table class="vertical-table">
	<tr>
		<th>Endereço de email</th>
		<th>Data/Hora Estabelecida</th>
	</tr>
	<?php foreach ($emails as $email): ?>
	<tr>
		<td><?php echo htmlspecialchars($email->email) ?></td>
		<td><?php echo $this->formatDateTime($email->create_date) ?></td>
	</tr>
	<?php endforeach ?>
</table>
<?php else: ?>
<p>Você não possui nenhum e-mail confiável do PayPal.</p>
<?php if (!Flux::config('HoldUntrustedAccount')): ?>
<p>Isso é porque provavelmente o sistema de pendências está <strong>sem efeito</strong>,  o que significa que uma doação feita de qualquer e-mail é imediatamente credenciado.</p>
<?php endif ?>
<?php endif ?>