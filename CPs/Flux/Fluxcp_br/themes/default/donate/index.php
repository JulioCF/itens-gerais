<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Doação</h2>
<?php if (Flux::config('AcceptDonations')): ?>
	<?php if (!empty($errorMessage)): ?>
		<p class="red"><?php echo htmlspecialchars($errorMessage) ?></p>
	<?php endif ?>
	
	<p>Ao fazer uma doação, você está ajudando nos custos de <em>execução</em> desde servidor e na <em>manutenção</em> do mesmo. Em troca, você é recompensado com <span class="keyword">créditos de doação</span> que você pode utilizar para comprar coisas da nossa <a href="<?php echo $this->url('purchase') ?>">loja</a>.</p>
	<h3>Você está pronto para doar?</h3>
	<p>Todas as doações feitas para nós são recebidas pelo PayPal, mas não se preocupe! Se você não tiver uma conta no PayPal, você ainda pode usar o seu cartão de crédito para fazer uma doação!</p>
		
	<?php
	$currency         = Flux::config('DonationCurrency');
	$dollarAmount     = (float)+Flux::config('CreditExchangeRate');
	$creditAmount     = 1;
	$rateMultiplier   = 10;
	$hoursHeld        = +(int)Flux::config('HoldUntrustedAccount');
	
	while ($dollarAmount < 1) {
		$dollarAmount  *= $rateMultiplier;
		$creditAmount  *= $rateMultiplier;
	}
	?>
	
	<?php if ($hoursHeld): ?>
		<p>Para evitar pagamentos fraudulentos, nosso servidor trava o processo de crédito por
			<span class="hold-hours"><?php echo number_format($hoursHeld) ?> horas</span>
			depois da doação ser feita para garantir a legitimidade do jogo e a reputação do PayPal.</p>
		<p>Essa trava é aplicada apenas para o e-mail associado ao PayPal e a conta do jogo!</p>
	<?php endif ?>

	<div class="generic-form-div" style="margin-bottom: 10px">
		<table class="generic-form-table">
			<tr>
				<th><label>Taxa de Câmbio:</label></th>
				<td><p><?php echo $this->formatCurrency($dollarAmount) ?> <?php echo htmlspecialchars($currency) ?>
				= <?php echo number_format($creditAmount) ?> crédito(s).</p></td>
			</tr>
			<tr>
				<th><label>Quantidade Mínima de Doação:</label></th>
				<td><p><?php echo $this->formatCurrency(Flux::config('MinDonationAmount')) ?> <?php echo htmlspecialchars($currency) ?></p></td>
			</tr>
		</table>
	</div>
		
	<?php if (!$donationAmount): ?>
	<form action="<?php echo $this->url ?>" method="post">
		<?php echo $this->moduleActionFormInputs($params->get('module')) ?>
		<input type="hidden" name="setamount" value="1" />
		<p class="enter-donation-amount">
			<label>
				Digite a quantidade que você quer doar:
				<input class="money-input" type="text" name="amount"
					value="<?php echo htmlspecialchars($params->get('amount')) ?>"
					size="<?php echo (strlen((string)+Flux::config('CreditExchangeRate')) * 2) + 2 ?>" />
				<?php echo htmlspecialchars(Flux::config('DonationCurrency')) ?>
			</label>
			ou
			<label>
				<input class="credit-input" type="text" name="credit-amount"
					value="<?php echo htmlspecialchars(intval($params->get('amount') / Flux::config('CreditExchangeRate'))) ?>"
					size="<?php echo (strlen((string)+Flux::config('CreditExchangeRate')) * 2) + 2 ?>" />
				Créditos
			</label>
		</p>
		<input type="submit" value="Confirmar Doação" class="submit_button" />
	</form>
	<?php else: ?>
	<p>Quando você estiver pronto para doar, clique no botão “Donate” para proceder com a sua transação.
		(Você pode fazer sua doação usando saldo existente na sua conta do PayPal ou usar o seu cartão de crédito caso você não possua conta).</p>
		
	<p class="credit-amount-text">
		&mdash;
		<span class="credit-amount"><?php echo number_format(floor($donationAmount / Flux::config('CreditExchangeRate'))) ?></span> créditos
		&mdash;
	</p>
		
	<p class="donation-amount-text">Quantidade:
		<span class="donation-amount">
		<?php echo $this->formatCurrency($donationAmount) ?>
		<?php echo htmlspecialchars(Flux::config('DonationCurrency')) ?>
		</span>
	</p>
	<p class="reset-amount-text">
		<a href="<?php echo $this->url('donate', 'index', array('resetamount' => true)) ?>">(Resetar Quantidade)</a>
	</p>
	<p><?php echo $this->donateButton($donationAmount) ?></p>
	<?php endif ?>
<?php else: ?>
	<p><?php echo Flux::message('NotAcceptingDonations') ?></p>
<?php endif ?>