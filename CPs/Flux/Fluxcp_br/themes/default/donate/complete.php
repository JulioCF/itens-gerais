<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2>Doação Completa</h2>
<p class="important">Sua transação está sendo processada e você deve receber os seus créditos em pouco tempo.</p>
<?php $hoursHeld = +(int)Flux::config('HoldUntrustedAccount'); ?>
<?php if ($hoursHeld): ?>
	<p>
		Nota: Existe um sistema de proteção nessa conta.Se você o seu e-mail do jogo for igual ao do PayPal e for a sua primeira doação,
		você só irá receber os seus créditos depois de <?php echo number_format($hoursHeld) ?> horas.
	</p>
<?php endif ?>
<p>Para completar, um e-mail foi enviado para você contendo os detalhes da sua transação.</p>
<p>Você também deve olhar o seu histórico na sua conta do PayPal.</p>

<br />
<br />
<p class="important" style="text-align: center; font-weight: bold">“Obrigado pela sua generosa doação!!”</p>
<p class="important" style="text-align: center">&mdash; <?php echo htmlspecialchars($session->loginAthenaGroup->serverName) ?></p>