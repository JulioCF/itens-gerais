<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Histórico de Doação</h2>
<h3>Transações: Completas</h3>
<?php if ($completedTxn): ?>
<p>Você possui <?php echo number_format($completedTotal) ?> transação(ões) completa(s).</p>
<table class="vertical-table">
	<tr>
		<th>Transação</th>
		<th>Data de Pagamento</th>
		<th>E-mail</th>
		<th>Quantidade</th>
		<th>Moeda</th>
		<th>Créditos</th>
	</tr>
	<?php foreach ($completedTxn as $txn): ?>
	<tr>
		<td><?php echo htmlspecialchars($txn->txn_id) ?></td>
		<td><?php echo $this->formatDateTime($txn->payment_date) ?></td>
		<td><?php echo htmlspecialchars($txn->payer_email) ?></td>
		<td><?php echo htmlspecialchars($txn->mc_gross) ?></td>
		<td><?php echo htmlspecialchars($txn->mc_currency) ?></td>
		<td><?php echo number_format($txn->credits) ?></td>
	</tr>
	<?php endforeach ?>
</table>
<?php else: ?>
<p>Você não possui transações completas.</p>
<?php endif ?>

<h3>Transações: Pendentes</h3>
<?php if ($heldTxn): ?>
<p>Você possui <?php echo number_format($heldTotal) ?> transação(oes) pendente(s).</p>
<table class="vertical-table">
	<tr>
		<th>Transação</th>
		<th>Data de Pagamento</th>
		<th>E-mail</th>
		<th>Quantidade</th>
		<th>Moeda</th>
		<th>Créditos</th>
	</tr>
	<?php foreach ($heldTxn as $txn): ?>
	<tr>
		<td><?php echo htmlspecialchars($txn->txn_id) ?></td>
		<td><?php echo $this->formatDateTime($txn->payment_date) ?></td>
		<td><?php echo htmlspecialchars($txn->payer_email) ?></td>
		<td><?php echo htmlspecialchars($txn->mc_gross) ?></td>
		<td><?php echo htmlspecialchars($txn->mc_currency) ?></td>
		<td><?php echo number_format($txn->credits) ?></td>
	</tr>
	<tr>
		<td colspan="6">
			↳ Pendente Até:
			<strong><?php echo $this->formatDateTime($txn->hold_until) ?></strong>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php else: ?>
<p>Você não possui transações pendentes.</p>
<?php endif ?>

<h3>Transações: Falhas</h3>
<?php if ($failedTxn): ?>
<p>You have <?php echo number_format($failedTotal) ?> held transaction(s).</p>
<table class="vertical-table">
	<tr>
		<th>Transação</th>
		<th>Data de Pagamento</th>
		<th>E-mail</th>
		<th>Quantidade</th>
		<th>Moeda</th>
		<th>Créditos</th>
	</tr>
	<?php foreach ($failedTxn as $txn): ?>
	<tr>
		<td><?php echo htmlspecialchars($txn->txn_id) ?></td>
		<td><?php echo $this->formatDateTime($txn->payment_date) ?></td>
		<td><?php echo htmlspecialchars($txn->payer_email) ?></td>
		<td><?php echo htmlspecialchars($txn->mc_gross) ?></td>
		<td><?php echo htmlspecialchars($txn->mc_currency) ?></td>
		<td><?php echo number_format($txn->credits) ?></td>
	</tr>
	<?php endforeach ?>
</table>
<?php else: ?>
<p>Você não possui transações falhas.</p>
<?php endif ?>